<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Subscribed;
use App\Models\Instance;
use Illuminate\Support\Str;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;
use phpseclib3\Net\SSH2;

class SshController extends Controller
{
    public function __construct()
    {
        $this->middleware(Subscribed::class)
            ->except(['Info', 'User']);
    }


    public function reboot(Instance $instance) {
        if (!optional($instance->server)->ip_address) {
            abort(400, "Instance IP address has not yet been assigned!");
        }
        $ssh = new SSH2($instance->server->ip_address);
        $key = RSA\PrivateKey::loadPrivateKey(file_get_contents(base_path('id_oryxbot_admin')));
        $ssh->login(
            'root',
            $key
        );

        $result = $ssh->exec('/etc/oryxbot.startup.sh');
        if (Str::contains($result, 'No such file')) {
            abort(400, "Instance initialization has not yet been finalized!");
        }
    }
}
