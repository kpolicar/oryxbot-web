<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LinkDiscordController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $request->user()->linkDiscord($id);

        return view('discord-linked');
    }
}
