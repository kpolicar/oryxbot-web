<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Stripe\Subscription;

class ExtendSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:extend {user} {--days=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extend subscription for a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = is_numeric($user = $this->argument('user'))
            ? User::findOrFail($user)
            : User::where('email', $user)->firstOrFail();
        $days = (int) $this->option('days');


        if ($subscription = $user->subscription()) {
            $stripeSubscription = $subscription->asStripeSubscription();

            $currentPeriodStart = Carbon::createFromTimestamp($stripeSubscription->current_period_end)->subMonth();
            $currentPeriodEnd = Carbon::createFromTimestamp($stripeSubscription->current_period_end);
            $cancelAt = $stripeSubscription->cancel_at
                ? Carbon::createFromTimestamp($stripeSubscription->cancel_at)
                : null;

            $newSubscription = $user->newSubscription('default', $subscription->stripe_plan)
                ->quantity($subscription->quantity)
                ->noProrate()
                ->withMetadata([
                    'previous_stripe_id' => $subscription->stripe_id
                ])
                ->create(null, [], [
                    'backdate_start_date' => $currentPeriodStart->addDays($days)->unix(),
                    'billing_cycle_anchor' => $currentPeriodEnd->addDays($days)->unix(),
                    'cancel_at' => $cancelAt ? $cancelAt->addDays($days)->unix() : null,
                ]);

            if ($newSubscription) {
                $subscription
                    ->noProrate()
                    ->cancelNow();
            }

            $this->info('Successfully extended subscription for user '.$user->email.' until '.$currentPeriodEnd->format('Y-m-d').'.');
        } else {
            $this->error('User '.$user->email.' is not subscribed!');
        }

        return 0;
    }
}
