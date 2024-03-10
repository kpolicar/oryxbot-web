<?php namespace App\Models;

use DB;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{

    protected static function boot()
    {
        parent::boot();
        static::saved(function (Subscription $subscription) {
            if ($subscription->wasChanged(['stripe_status', 'quantity']) || $subscription->wasRecentlyCreated) {
                $subscription->updateSubscriptionInstances();
            }
        });
    }

    private function isActiveSubscriptionStatus()
    {
        return in_array($this->stripe_status, [\Stripe\Subscription::STATUS_ACTIVE, \Stripe\Subscription::STATUS_TRIALING]);
    }

    private function updateSubscriptionInstances()
    {
        if ($this->isActiveSubscriptionStatus()) {
            $originalQuantity = $this->instances->count();

            // Make new instances (increasing quantity)
            for ($i=$originalQuantity; $i < $this->quantity; $i++) {
                if (!$this->instances->has($i)) {
                    $instance = $this->instances()->make([
                        'name' => 'Oryxbot #'.($i+1),
                        'slug' => 'bot-'.($i+1),
                    ]);
                    $instance->save();
                }
            }
            // Delete existing instances (lowering quantity)
            for ($i=$this->quantity;$i < $originalQuantity; $i++) {
                optional($this->instances->get($i))->delete();
            }
        } else {
            $this->instances()->get()->each(function (Instance $instance) {
                $instance->delete();
            });
        }
    }

    public function instances()
    {
        return $this->hasMany(Instance::class);
    }
}
