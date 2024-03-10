<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Stripe\Stripe;
use Stripe\Subscription;
use Tests\CreatesApplication;
use Tests\TestCase;

class UserSubscriptionTest extends TestCase
{
    use CreatesApplication, DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $u = new User([
            'email' => 'admin@app.com',
            'name' => 'Admin',
            'password' => '1234'
        ]);
        $u->save();
        $u->subscriptions()->create([
            'name' => 'default',
            'stripe_id' => 'sub_J3Q8kMMBBRI7Tf',
            'stripe_status' => Subscription::STATUS_ACTIVE,
            'stripe_plan' => config('pricing.trade_mission_bot.stripe_id'),
            'quantity' => 1,
            'ends_at' => now()->addMonth()->subDay(),
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ]);

        dd($u->instances()->first()->server);

        $this->assertTrue($u->exists);
    }
}
