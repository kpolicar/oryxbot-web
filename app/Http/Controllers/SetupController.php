<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetupController extends Controller
{
    public function index()
    {
        return view('nova::setup');
    }
    public function digitalOcean()
    {
        return view('nova::setupdigitalocean');
    }
}
