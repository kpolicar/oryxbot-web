<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use App\Models\Server;
use DigitalOceanV2\Client as DigitalOcean;
use DigitalOceanV2\Exception\RuntimeException;
use Illuminate\Http\Request;

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

    public function deployServer(Request $request, Instance $instance)
    {
        $request->validate([
            'terms' => 'accepted',
        ]);

        $server = $instance->server()->make();

        $client = $this->digitalOceanClientOrRedirect($request, $instance);
        if (!($client instanceof DigitalOcean)) {
            return $client;
        }

        try {
            $existingSshKey = collect($client->key()->getAll())->firstWhere('publicKey', config('digitalocean.ssh_key_public'));

            $key = $existingSshKey
                ?: $client->key()->create('oryxbot.com', config('digitalocean.ssh_key_public'));

            $server->ssh_key_id = $key->id;
        } catch (\Throwable $exception) {
            report($exception);
            return redirect()->back()->withErrors([
                'digitalocean' => 'Failed to add our SSH key to your Digital Ocean account.'
            ]);
        }


        $droplet = $client->droplet()->create(
            $server->name,
            $server->droplet_region = $request->post('region'),
            $server->droplet_size = 's-1vcpu-512mb-10gb',
            config('digitalocean.bot_snapshot_id'),
            false,
            false,
            false,
            [$server->ssh_key_id],
            '#!/bin/bash'."\n\n".'echo "'.$server->accessToken.'" > /etc/oryxbot.apikey',
            true,
            [],
            ['bot']);

        $server->ip_address = optional(collect($droplet->networks)->firstWhere('type', 'public'))->ipAddress;
        $server->private_ip_address = optional(collect($droplet->networks)->firstWhere('type', 'private'))->ipAddress;
        $server->save();

        try {
            $key = $client->key()->create('oryxbot.com', config('digitalocean.ssh_key_public'));
        } catch (\Throwable $exception) {
            report($exception);
            return redirect()->back()->withErrors([
                'digitalocean' => 'Failed to add our SSH key to your Digital Ocean account.'
            ]);
        }

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
        $server->ip_address = $request->json('ip_address');
        $server->private_ip_address = $request->json('private_ip_address');
        $server->save();
    }

    public function vpnCredentials(Request $request)
    {
        $server = Server::findOrFailByDropletId($request->input('droplet_id'));
        return $server->vpn_username."\t*\t".$server->vpn_password."\t\t*";
    }
}
