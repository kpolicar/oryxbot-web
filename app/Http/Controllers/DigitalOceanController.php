<?php

namespace App\Http\Controllers;

use App\ImageVersion;
use File;
use DB;
use App\Models\Instance;
use App\Models\Server;
use DigitalOceanV2\Client as DigitalOcean;
use DigitalOceanV2\Exception\ExceptionInterface;
use DigitalOceanV2\Exception\RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DigitalOceanController extends Controller
{
    public function validateToken(Request $request, Instance $instance)
    {
        $client = $this->digitalOceanClientOrRedirect($request, $instance);
        if (!($client instanceof DigitalOcean)) {
            return $client;
        }

        return redirect(route('setup', compact('instance')));
    }

    // todo: memoize the str replacements
    protected function generateServerSetupScript(Server $server, $accessToken)
    {
        $script = '';
        $script .= '#!/bin/bash'."\n\n";
        $script .= "echo $accessToken > /etc/oryxbot.apikey;"."\n\n";
        $script .= "export VPN_USERNAME=$server->vpn_username;"."\n\n";
        $script .= "export VPN_PASSWORD=$server->vpn_password;"."\n\n";

        if (Str::endsWith(config('app.domain'), '.test')) {
            $script .= 'echo "10.0.0.100 '.config('app.domain') ."\" >> /etc/hosts\n\n";
            $script .= 'echo "10.0.0.100 '.config('nova.domain') . "\" >> /etc/hosts\n\n";
        }

        $script .= File::get(base_path('server-setup.sh'))."\n\n";

        $script = Str::replace("{{ app_url }}", config('app.url'), $script);

        $scriptStartup = File::get(base_path('server-startup.sh'))."\n\n";
        $scriptStartup = Str::replace("{{ app_url }}", config('app.url'), $scriptStartup);
        $scriptStartup = base64_encode($scriptStartup);

        $vectorConfigFile = File::get(base_path('vector.yaml'))."\n\n";
        $vectorConfigFile = Str::replace("{{ open_observe_user }}", $server->user->email, $vectorConfigFile);
        $vectorConfigFile = Str::replace("{{ open_observe_password }}", $server->user->open_observe_password, $vectorConfigFile);
        $vectorConfigFile = base64_encode($vectorConfigFile);

        $script = Str::replace("{{ vector_config_base64 }}", $vectorConfigFile, $script);

        $script .= "base64 -d <<< \"$scriptStartup\" > /etc/oryxbot.startup.sh\n";
        $script .= "chown oryxbot:oryxbot /etc/oryxbot.startup.sh\n";
        $script .= "chmod -R ug+x /etc/oryxbot.startup.sh\n";
        $script .= "/etc/oryxbot.startup.sh\n";

        return $script;
    }

    public function reset(Request $request, Instance $instance) {
        $request->validate([
            'terms' => 'accepted',
        ]);

        $client = $this->digitalOceanClientOrRedirect($request, $instance);
        if (!($client instanceof DigitalOcean)) {
            return $client;
        }

        if ($instance->server) {
            try {
                $client->droplet()->remove($instance->server->droplet_id);
            } catch (\Throwable $exception) {
                // If the droplet wasn't found, user may have already deleted it previously. If not, throw error
                if (optional($exception)->getCode() != 404) {
                    report($exception);
                    return redirect()->back()->withErrors([
                        'digitalocean' => 'Failed to delete the server from your Digital Ocean account.'
                    ]);
                }
            }
        }
        optional($instance->server)->delete();
        $request->session()->forget("instance-$instance->id");
        return redirect(route('setup', compact('instance')));
    }

    public function deployServer(Request $request, Instance $instance, ImageVersion $imageVersion)
    {
        $request->validate([
            'terms' => 'accepted',
        ]);
        if ($instance->server) {
            return redirect(route('setup.reset', compact('instance')))->withErrors([
                'digitalocean' => 'You must first delete any existing resources!'
            ]);
        }
        $user = $instance->subscription->user;


        $client = $this->digitalOceanClientOrRedirect($request, $instance);
        if (!($client instanceof DigitalOcean)) {
            return $client;
        }

        DB::beginTransaction();
        $server = $instance->server()->make();
        $accessToken = $user->createToken($instance->name);
        $server->vpn_username = Str::before($user->email, '@');
        $server->vpn_password = Str::random(16);
        $server->droplet_region = $request->post('region');
        $server->droplet_size = 's-1vcpu-512mb-10gb';
        $server->token_id = $accessToken->token->id;
        $server->droplet_image = Server::IMAGE;
        $server->droplet_name = $instance->slug . "--$server->droplet_size-$server->droplet_region";
        $server->image_version = $imageVersion->latest()['name'];

        try {
            $existingSshKey = collect($client->key()->getAll())->firstWhere('publicKey', config('digitalocean.ssh_key_public'));

            $key = $existingSshKey
                ?: $client->key()->create('oryxbot.com', config('digitalocean.ssh_key_public'));

            $server->ssh_key_id = $key->id;
        } catch (\Throwable $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withErrors([
                'digitalocean' => 'Failed to add our SSH key to your Digital Ocean account.'
            ]);
        }

        try {
            $startupScript = $this->generateServerSetupScript($server, $accessToken->accessToken);
        } catch (\Throwable $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withErrors([
                'digitalocean' => 'Failed to generate startup script for your deployment.'
            ]);
        }

        try {
            $droplet = $client->droplet()->create(
                $server->droplet_name,
                $server->droplet_region,
                $server->droplet_size,
                $server->droplet_image,
                false,
                false,
                false,
                [$server->ssh_key_id],
                $startupScript,
                true,
                [],
                ['bot']);
        } catch (\Throwable $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withErrors([
                'digitalocean' => 'Failed to deploy new droplet on your Digital Ocean account.'
            ]);
        }

        $server->droplet_id = optional($droplet)->id;
        $server->ip_address = optional(collect($droplet->networks)->firstWhere('type', 'public'))->ipAddress;
        $server->private_ip_address = optional(collect($droplet->networks)->firstWhere('type', 'private'))->ipAddress;
        $server->save();
        DB::commit();

        return redirect(route('setup', compact('instance')));
    }

    protected function digitalOceanClientOrRedirect(Request $request, Instance $instance)
    {
        $accessToken = $request->post('digitalocean_token');

        try {
            $client = new DigitalOcean();
            $client->authenticate($accessToken);
            $userInformation = $client->account()->getUserInformation();

            $request->session()->put("instance-{$instance->id}.setup.digitalocean.token_validated", true);
            $request->session()->put("instance-{$instance->id}.setup.digitalocean.user_status", $userInformation->status);
        } catch (RuntimeException $exception) {
            report($exception);
            return redirect()->back()->withErrors([
                'digitalocean' => 'Could not connect to Digital Ocean with the provided access token.'
            ]);
        } catch (\Throwable $exception) {
            report($exception);
            return redirect()->back()->withErrors([
                'digitalocean' => 'There was an error sending the request to Digital Ocean.'
            ]);

        }

        return $client;
    }

    public function handleWebhook(Request $request)
    {
        $server = Server::findOrFailByDropletId($request->json('droplet_id'));
        if (!$request->user()->is(optional($server)->user)) {
            abort(404);
        }
        $server->ip_address = $request->json('ip_address');
        $server->private_ip_address = $request->json('private_ip_address');
        $server->save();
    }

    public function vpnCredentials(Request $request)
    {
        $server = Server::findOrFailByDropletId($request->input('droplet_id'));
        if (!$request->user()->is(optional($server)->user)) {
            abort(404);
        }
        return $server->vpn_username."\t*\t".$server->vpn_password."\t\t*";
    }
}
