<?php

namespace App\Models;

use App\Models\Traits\UserThrottles;
use App\Models\Traits\UserTrademissionData;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, Billable, UserThrottles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'stripe_id',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
        'card_brand',
        'card_last_four',
        'open_observe_password',
    ];

    protected $appends = [
        'is_subscribed',
        'on_free_trial',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscribed_to' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        parent::creating(function ($user) {
            $user->GenerateReferralCode();
            $user->GenerateOpenObservePassword();

            if ($referredBy = \Cookie::get('referral')) {
                $user->referred_by = static::FindByReferral($referredBy)->id;
            }
        });
    }

    public function getUsernameAttribute()
    {
        return Str::before($this->email, '@');
    }

    public function instances()
    {
        return $this->hasManyThrough(Instance::class, Subscription::class);
    }

    public function referrer() {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }

    protected function GenerateReferralCode() {
        do {
            $this->referral_code = $referralCode = \Str::random(10);
        } while (static::FindByReferral($referralCode)->exists);
    }

    protected function GenerateOpenObservePassword() {
        $this->open_observe_password = \Str::random(16);
    }

    public static function FindByReferral($code) {
        return optional(static::firstWhere('referral_code', $code));
    }

    public function subscribedToTradeMissionBot()
    {
        return $this->subscribedToPlan(config('pricing.trade_mission_bot.stripe_id'));
    }

    public function eligibleForFreeTrial()
    {
        return false && $this->hasVerifiedEmail() && !$this->subscriptions()->exists();
    }

    public function getIsSubscribedAttribute()
    {
        return $this->subscribed() || !!optional($this->subscribed_to)->isAfter($this->freshTimestamp());
    }

    public function getSubscriptionInstancesAttribute()
    {
        return $this->instances()->count();
    }

    public function getOnFreeTrialAttribute()
    {
        return $this->onTrial();
    }

    public function linkDiscord($id)
    {
        $this->forceFill([
            'discord_id' => $id
        ])->save();
    }

    public function hasOneActiveInstance()
    {
        return !!$this->subscription()->instances->firstWhere('is_active');
    }
}
