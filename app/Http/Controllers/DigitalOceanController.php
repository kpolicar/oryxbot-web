<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController;

class DigitalOceanController extends Controller
{
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
