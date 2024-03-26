<?php

namespace App\Jobs;

use Http;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RegisterOpenSearchUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // https://openobserve.ai/docs/api/user/create/
        $data = [
            "email" => $this->user->email,
            "first_name" => $this->user->name,
            "last_name" => "",
            "password" => $this->user->open_search_password,
            "role" => "user"
        ];
        Http::withBasicAuth(config('openobserve.root_user'), config('openobserve.root_password'))
            ->post(config('openobserve.url').'/api/default/users');
    }
}
