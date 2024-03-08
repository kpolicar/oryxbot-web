<?php

namespace App\Models;

use DB;
use DigitalOceanV2\Exception\RuntimeException;
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Passport\Token;
use PHPUnit\Util\Exception;

class Server extends Model
{
    const FALLBACK_USERNAME = 'user';
    const IMAGE = 'ubuntu-20-04-x64';

    use HasFactory;

//    protected $size = 's-1vcpu-1gb';
//    protected $region = 'fra1';
    protected $accessToken;

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
            $server->vpn_username = optional($server->user)->username ?: static::FALLBACK_USERNAME;
            $server->vpn_password = Str::random(16);
        });
        static::deleting(function () {
            throw new Exception("Servers cannot be deleted.");
            DB::beginTransaction();
        });

        static::deleted(function (Server $server) {
            try {
                $server->token()->delete();
                DigitalOcean::droplet()->remove($server->droplet_id);
            } catch (RuntimeException $exception) {
                if ($exception->getCode() != 404) {
                    DB::rollback();
                    throw $exception;
                }
            }
            DB::commit();
        });
    }

    public function getNameAttribute()
    {
        return 'oryxbot--s-1vcpu-1gb-fra1';
    }

    public static function findOrFailByDropletId($id)
    {
        return static::where('droplet_id', $id)->firstOrFail();
    }

    public static function makeWithName($iteration, $userId)
    {
        // deprecated
        $iteration++;
        $self = static::make();
        $self->droplet_name = "user-$userId-bot-$iteration"."--{$self->size}-{$self->region}";
        return $self;
    }

    public function getPersonalAccessTokenName()
    {
        return $this->name;
    }

    public function setToken($personalAccessToken)
    {
        $this->accessToken = $personalAccessToken->accessToken;
        $this->token_id = $personalAccessToken->token->id;
    }

    public function token()
    {
        return $this->belongsTo(Token::class);
    }

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    public function getUserAttribute()
    {
        return data_get($this, 'instance.subscription.user');
    }
}
