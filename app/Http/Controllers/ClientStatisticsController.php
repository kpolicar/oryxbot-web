<?php

namespace App\Http\Controllers;

use Str;
use Storage;
use Image;
use App\Models\Maging;
use App\Models\User;
use Illuminate\Http\Request;

class ClientStatisticsController extends Controller
{
    public function Update(Request $request) {
        $maging = Maging::todaysForUser($request->user());

        if (($expended = $request->input('expend', 0)) > 300000)
            $expended = 0;
        $maging->expended += $expended;
        foreach (json_decode($request->input('attempts_exo', "{}"), true) as $stat => $attempts) {
            $exoAttempts = $maging->exo_attempts ?? [];
            $exoAttempts[$stat] = $attempts + ($exoAttempts[$stat] ?? 0);
            $maging->exo_attempts = $exoAttempts;
        }
        foreach (json_decode($request->input('successes_exo', "{}"), true) as $stat => $attempts) {
            $exoSuccesses = $maging->exo_successes ?? [];
            $exoSuccesses[$stat] = $attempts + ($exoSuccesses[$stat] ?? 0);
            $maging->exo_successes = $exoSuccesses;
        }

        $maging->save();
    }

    public function Publish(Request $request) {
        $request->validate([
            'image'=> 'required|image|max:1000',
        ]);
        $image = Image::make($request->file('image'))->encode('jpg');
        $image->insert(asset('images/oryxbot_watermark.png'), 'bottom-right');
        $image->insert(asset('images/smithmagus_parachment_watermark.png'), 'top-right', 8, 39);

        $fileName = Str::random(40).'.jpg';
        $path = "public/mages/{$request->user()->id}";
        Storage::makeDirectory($path);
        $image->save(storage_path("app/$path/$fileName"), 75);

        $request->user()->publishes()->create([
            'image_path' => Storage::url("$path/$fileName")
        ]);
    }
}
