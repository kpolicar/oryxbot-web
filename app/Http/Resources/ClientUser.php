<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientUser extends JsonResource
{

    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'evmgKPdAiRlfcfa' => $this->id,
            'KEwTWbPyWmdjUKh' => $this->email,
            'efteqXlZxvUNNvi' => $this->name,
            'MVsdYkjeqDKCQBD' => $this->is_subscribed,
            'uCdeLPhkzFyOSTE' => $this->on_free_trial,
        ];
    }
}
