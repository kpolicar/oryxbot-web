<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetupController extends Controller
{
    public function index()
    {
        return view('nova::setup');
    }

    public function setup()
    {
        return view('nova::setup-digitalocean');
    }

    public function deploy()
    {
        return view('nova::setup-deploy');
    }

    public function vncServer()
    {
        return view('nova::setup-vncserver');
    }

    public function vpn()
    {
        return view('nova::setup-vpn');
    }
}
