<?php namespace App\Models\Traits;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait UserTrademissionData
{
    private $tradeMissionRunningKey = 'user-:key-trademission_running';


    public function setTradeMissionRunning($running)
    {
        Cache::put(Str::replace(':key', $this->getKeyName(), $this->tradeMissionRunningKey), $running);
        return $this;
    }

    public function tradeMissionRunning()
    {
        return Cache::get(Str::replace(':key', $this->getKeyName(), $this->tradeMissionRunningKey));
    }
}
