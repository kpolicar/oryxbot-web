<?php

namespace App\Models;

use DB;
use DigitalOceanV2\Exception\RuntimeException;
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Server extends Model
{
    const IMAGE = 'ubuntu-20-04-x64';

    use HasFactory;

    protected $name = 'user-x-bot-x--s-1vcpu-1gb-fra1';
    protected $size = 's-1vcpu-1gb';
    protected $region = 'fra1';

    protected $visible = [
        'ip_address',
        'vpn_username',
        'vpn_password',
        'online',
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function (Server $server) {
            $remoteServer = DigitalOcean::droplet()->create(
                $server->name,
                $server->region,
                $server->size,
                static::IMAGE);
            $server->droplet_id = $remoteServer->id;
        });
        static::deleting(function () {
            DB::beginTransaction();
        });

        static::deleted(function (Server $server) {
            try {
                DigitalOcean::droplet()->remove($server->droplet_id);
                DB::commit();
            } catch (RuntimeException $exception) {
                if ($exception->getCode() != 404) {
                    DB::rollback();
                    throw $exception;
                }
            }
        });
    }

    public static function makeWithName($iteration, $userId)
    {
        $iteration++;
        $self = static::make();
        $self->name = "user-$userId-bot-$iteration"."--{$self->size}-{$self->region}";
        return $self;
    }

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }
}
