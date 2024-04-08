<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Subscribed;
use App\Models\Instance;
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
        $ssh = new SSH2($instance->server->ip_address);
        $key = RSA\PrivateKey::loadPrivateKey(file_get_contents(base_path('id_oryxbot_admin')));
        $ssh->login(
            'root',
            $key
        );

        return $ssh->exec('ls -la');
    }
}
