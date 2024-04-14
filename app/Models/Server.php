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
    const IMAGE = 'ubuntu-23-10-x64';

    use HasFactory;

//    protected $size = 's-1vcpu-1gb';
//    protected $region = 'fra1';

    protected $visible = [
        'ip_address',
        'vpn_username',
        'vpn_password',
        'online',
        'client_version',
    ];


    protected static function boot()
    {
        parent::boot();
    }

    public static function findOrFailByDropletId($id)
    {
        return static::where('droplet_id', $id)->firstOrFail();
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
