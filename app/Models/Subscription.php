<?php namespace App\Models;

use App\Jobs\UpdateSubscriptionInstances;
use DB;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{

    protected static function boot()
    {
        parent::boot();
        static::saved(function (Subscription $subscription) {
            UpdateSubscriptionInstances::dispatchIf(
                $subscription->wasChanged(['stripe_status', 'quantity']) || $subscription->wasRecentlyCreated,
                $subscription);
        });
    }

    public function instances()
    {
        return $this->hasMany(Instance::class);
    }
}
