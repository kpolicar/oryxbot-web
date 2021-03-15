<?php namespace DiscordApp;

use DiscordApp\Controllers\MessageController;
use DiscordApp\Controllers\WebhookController;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Guild;

include __DIR__.'/../vendor/autoload.php';
const GUILD_ID = 816747376449421422;
const WEBHOOK_USER_ID = 821073200972038196;

$discord = new \Discord\Discord([
    'token' => '***REMOVED***',
    'loadAllMembers' => true,
]);

$discord->on('ready', function (\Discord\Discord $discord) {

    $discord->guilds->fetch(GUILD_ID)->then(function (Guild $guild) use ($discord) {

        $discord->on('message', function (Message $message, Discord $discord) use ($guild) {
            try {
                if ($message->author->id == WEBHOOK_USER_ID && str_starts_with($message->content, "!"))
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
    });
    echo "Bot is ready.", PHP_EOL;

    // Listen for events here


});

$discord->run();
