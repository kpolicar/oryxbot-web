<?php

namespace App\Http\Controllers;

use App\Models\Server;
use DigitalOceanV2\Client as DigitalOcean;
use DigitalOceanV2\Exception\RuntimeException;
use Illuminate\Http\Request;

class DigitalOceanController extends Controller
{
    public function validateToken(Request $request)
    {
        $client = $this->digitalOceanClientOrRedirect($request);
        if (!($client instanceof DigitalOcean)) {
            return $client;
        }

        return redirect(route('setup'));
    }

    public function deployServer(Request $request)
    {
        $request->validate([
            'terms' => 'accepted',
        ]);
        $client = $this->digitalOceanClientOrRedirect($request);
        if (!($client instanceof DigitalOcean)) {
            return $client;
        }
        dd($client->key()->getAll());

        return redirect(route('setup'));
    }

    protected function digitalOceanClientOrRedirect(Request $request)
    {
        $accessToken = $request->post('digitalocean_token');

        try {
            $client = new DigitalOcean();
            $client->authenticate($accessToken);
            $userInformation = $client->account()->getUserInformation();

            $request->session()->put('setup.digitalocean.token_validated', true);
            $request->session()->put('setup.digitalocean.user_status', $userInformation->status);
        } catch (RuntimeException $exception) {
            return redirect()->back()->withErrors([
                'digitalocean_token' => 'Could not connect to Digital Ocean with the provided access token.'
            ]);
        } catch (\Throwable $exception) {
            return redirect()->back()->withErrors([
                'digitalocean_token' => 'There was an error sending the request to Digital Ocean.'
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
