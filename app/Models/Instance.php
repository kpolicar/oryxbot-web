<?php

namespace App\Models;

use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    use HasFactory;

    protected $guarded = [

    ];

    protected $visible = [
        'id',
        'name',
        'slug',
        'server',
        'setup_route',
        'is_active',
    ];

    protected $with = [
        'server',
    ];

    protected $appends = [
        'setup_route',
        'is_active',
    ];



    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booting()
    {
        parent::booting();
        static::deleting(function (Instance $instance) {
            optional($instance->server)->delete();
        });
    }

    public static function queryForSubscription(Subscription $subscription)
    {
        return $subscription->instances();
    }

    public function findOrCreateServer()
    {
        return $this->server ?: $this->server()->create();
    }

    public function server()
    {
        return $this->hasOne(Server::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function getSetupRouteAttribute()
    {
        return route('setup', ['instance' => $this]);
    }

    public function getIsActiveAttribute()
    {
        return !!optional($this->server)->ip_address;
    }
}
