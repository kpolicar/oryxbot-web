<?php

namespace App\Http\Controllers;

use App\Http\Middleware\DeploymentAuth;
use Illuminate\Http\Request;

class DeploymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(DeploymentAuth::class);
    }

    public function deployOryxbot()
    {

    }
}
