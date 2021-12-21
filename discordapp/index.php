<?php namespace DiscordApp;

use Discord\Parts\User\User;
use Discord\Parts\WebSockets\MessageReaction;
use Discord\WebSockets\Event;
use DiscordApp\Controllers\MessageController;
use DiscordApp\Controllers\ReactionController;
use DiscordApp\Controllers\WebhookController;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Guild;

include __DIR__.'/../vendor/autoload.php';
const GUILD_ID = 859768917256699934;
const WEBHOOK_INTEGRATION_CHANNEL_ID = 922898266029424650;
const BOT_USER_ID = 907306866248400909;
const REACTION_MESSAGE_ID = 922897100365242438;

$discord = new \Discord\Discord([
    'token' => '***REMOVED***',
    'loadAllMembers' => true,
]);

$discord->on('ready', function (\Discord\Discord $discord) {

    $discord->guilds->fetch(GUILD_ID)->then(function (Guild $guild) use ($discord) {

        $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) use ($guild) {
            try {
                if ($message->channel_id == WEBHOOK_INTEGRATION_CHANNEL_ID && str_starts_with($message->content, "!"))
                    return (new WebhookController($guild))->handleMessage($message);

                if ($discord->username == $message->author->username ||
                    $message->channel->type != Channel::TYPE_DM)
                    return;

                return (new MessageController($guild))->handle($message);

                echo "Recieved a message from {$message->author->username}: {$message->content}", PHP_EOL;
            } catch (\Throwable $throwable) {
                echo "[ERROR]: ".$throwable->getMessage();
            }
        });


        $discord->on(Event::MESSAGE_REACTION_ADD, function (MessageReaction $reaction, Discord $discord) use ($guild) {
            if ($reaction->message_id != REACTION_MESSAGE_ID || $reaction->user_id == BOT_USER_ID)
                return;

            $discord->users->fetch($reaction->user_id)->then(function ($user) use ($guild, $reaction) {
                return (new ReactionController($guild))->handle($user, $reaction);
            });
        });
    });
    echo "Bot is ready.", PHP_EOL;

    // Listen for events here


});

$discord->run();
