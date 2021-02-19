<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendUpdatePushNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pushnotify:newupdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all users subscribed to push notifications a message for the new Oryxbot Update';

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
        \OneSignal::sendNotificationToAll(
            "A new version of Oryxbot has just been released!",
            $url = route('release', ['version' => 'latest']),
            $data = null,
            $buttons = null,
            $schedule = null,
            $headings = "Oryxbot Update"
        );

        return 0;
    }
}
