<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    public function index(Instance $instance)
    {
        return view('nova::setup', compact('instance'));
    }

    public function setup(Instance $instance)
    {
        return view('nova::setup-digitalocean', compact('instance'));
    }

    public function deploy(Instance $instance)
    {
        return view('nova::setup-deploy', compact('instance'));
    }

    public function vncServer(Instance $instance)
    {
        return view('nova::setup-vncserver', compact('instance'));
    }

    public function vpn(Instance $instance)
    {
        return view('nova::setup-vpn', compact('instance'));
    }
}
