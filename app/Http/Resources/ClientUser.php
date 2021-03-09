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
            'CXpD6X71WZhYsHf' => $this->email,
            'email' => $this->email,

            'i30jfVx9krmacQH' => $this->name,
            'name' => $this->name,

            'wVakGMaAnUQkCFZ' => $this->is_subscribed,
            'is_subscribed' => $this->is_subscribed,

            'Sw6mNjvR0HZofKj' => $this->on_free_trial,
            'on_free_trial' => $this->on_free_trial,
        ];
    }
}
