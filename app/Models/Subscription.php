<?php namespace App\Models;

use DB;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{

    protected static function boot()
    {
        parent::boot();
        static::saving(function (Subscription $subscription) {
            if ($subscription->isDirty(['stripe_status', 'quantity'])) {
                DB::beginTransaction();
            }
        });
        static::saved(function (Subscription $subscription) {
            if ($subscription->wasChanged(['stripe_status', 'quantity'])) {
                try {
                    $subscription->updateInstances();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    throw $e;
                }
            }
        });
    }

    public function instances()
    {
        return $this->hasMany(Instance::class);
    }

    private function updateInstances()
    {
        if ($this->stripe_status = \Stripe\Subscription::STATUS_ACTIVE) {
            for ($i=$this->getOriginal('quantity');$i < $this->quantity; $i++) {
                if (!$this->instances->has($i)) {
                    $instance = $this->instances()->make([
                        'name' => 'Bot #'.($i+1),
                        'slug' => 'bot-'.($i+1),
                    ]);
                    $instance->serverToCreate = Server::makeWithName($i, $this->user_id);
                    $instance->save();
                }
            }
            for ($i=$this->quantity;$i < $this->getOriginal('quantity'); $i++) {
                optional($this->instances->get($i))->delete();
            }
        } else {
            $this->instances()->with('server')->get()->each(function (Instance $instance) {
                $instance->delete();
            });
        }
    }
}
