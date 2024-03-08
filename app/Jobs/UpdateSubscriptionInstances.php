<?php

namespace App\Jobs;

use App\Models\Instance;
use App\Models\Server;
use DB;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateSubscriptionInstances implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscription;


    /**
     * Create a new job instance.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->onConnection('database');
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $this->updateSubscriptionInstances();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    protected function updateSubscriptionInstances()
    {
        if (in_array($this->subscription->stripe_status, [\Stripe\Subscription::STATUS_ACTIVE, \Stripe\Subscription::STATUS_TRIALING])) {
            $originalQuantity = $this->subscription->instances->count();

            for ($i=$originalQuantity;$i < $this->subscription->quantity; $i++) {
                if (!$this->subscription->instances->has($i)) {
                    $instance = $this->subscription->instances()->make([
                        'name' => 'Oryxbot #'.($i+1),
                        'slug' => 'bot-'.($i+1),
                    ]);
                    $instance->serverToCreate = $server = $instance->server()->make();
                    $server->setToken(
                        $this->subscription->user->createToken($server->getPersonalAccessTokenName()));
                    $instance->save();
                }
            }
            for ($i=$this->subscription->quantity;$i < $originalQuantity; $i++) {
                optional($this->subscription->instances->get($i))->delete();
            }
        } else {
            $this->subscription->instances()->with('server')->get()->each(function (Instance $instance) {
                $instance->delete();
            });
        }
    }
}
