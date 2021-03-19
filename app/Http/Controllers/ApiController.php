<?php

namespace App\Http\Controllers;

use App\ClientVersion;
use App\Exceptions\ConfigMissingException;
use Illuminate\Http\Request;
use App\Http\Resources\ClientUser as ClientUserResource;

class ApiController extends Controller
{
    public function Info(ClientVersion $versions) {
        $last = $versions->latest();

        return [
            'name' => $last['name'],
            'endpoint' => $last['code'],
            'number' => $last['number'],
        ];
    }

    public function User(Request $request) {
        return new ClientUserResource($request->user());
    }
}
