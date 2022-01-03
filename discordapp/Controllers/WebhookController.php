<?php namespace DiscordApp\Controllers;

use Illuminate\Support\Str;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Guild;
use Discord\Parts\Guild\Role;
use Discord\Parts\User\Member;

class WebhookController
{
    const ROLE_SUBSCRIBER_ID = 922899362886082632;
    /**
     * @var Guild
     */
    private $guild;

    public function __construct(Guild $guild) {
        $this->guild = $guild;
    }

    public function handleMessage(Message $message)
    {
        $command = Str::after($message->content, "!");
        $command = Str::before($command, " ");
        $argument = Str::of($message->content)
            ->matchAll("/[^ \"]+|\".*?\"/")
            ->skip(1)
            ->map(function ($str) {
                return str_replace('"', '', $str);
            });
        $this->$command($message, ...$argument);
        echo "Executed command: $message->content\n";
    }

    public function linked(Message $message, $id)
    {
        $this->guild->members->fetch($id)->then(function (Member $member) {
            $member->user->sendMessage("You have successfully linked Discord with your Oryxbot account.");
        });
    }

    public function subscribe(Message $message, $id) {
        $this->guild->members->fetch($id)->then(function (Member $member) use($message) {
            if ($member->roles->has(WebhookController::ROLE_SUBSCRIBER_ID))
                return;

            $member->addRole(WebhookController::ROLE_SUBSCRIBER_ID)
                ->then(function () use ($member, $message) {
                    $member->user->sendMessage("Your discord role on has been updated to: **Subscriber**.");
                });
        });
    }

    public function unsubscribe(Message $message, $id) {
        $this->guild->members->fetch($id)->then(function (Member $member) use($message) {
            if (!$member->roles->has(WebhookController::ROLE_SUBSCRIBER_ID))
                return;

            $member->removeRole(WebhookController::ROLE_SUBSCRIBER_ID)
                ->then(function () use ($member, $message) {
                    $member->user->sendMessage("Your discord role on has been updated to: **Guest**.");
                });
        });
    }

    public function notify(Message $_, $id, $message)
    {
        $this->guild->members->fetch($id)->then(function (Member $member) use($message) {
            $member->user->sendMessage($message);
        });
    }
}
