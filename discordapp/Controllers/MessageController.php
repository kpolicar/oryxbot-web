<?php namespace DiscordApp\Controllers;

use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Guild;
use Discord\Parts\User\User;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;

class MessageController
{
    protected $commands = [
        'login'
    ];

    /**
     * @var Guild
     */
    private $guild;

    public function __construct(Guild $guild) {
        $this->guild = $guild;
    }

    public function handle(Message $message)
    {
        $command = Str::after($message->content, "!");
        $command = Str::before($command, " ");
        $argument = Str::of($message->content)
            ->matchAll("/[^ \"]+|\".*?\"/")
            ->skip(1)
            ->map(function ($str) {
                return str_replace('"', '', $str);
            });

        if (!in_array($command, $this->commands)) {
            $this->replyWithInfo($message);
        } else {
            try {
                $this->$command($message, ...$argument);
                echo "Executed command: $message->content\n";
            } catch (\ArgumentCountError $error) {
                $this->replyWithInfo($message);
            }
        }
    }

    private function replyWithInfo(Message $message) {
        $message->reply($this->messageContent());
    }

    public function replyWithInfoToUser(User $user) {
        $user->sendMessage($this->messageContent());
    }

    private function messageContent() {
        return "Greetings!\n".
            "To connect Discord with your Oryxbot account, you should execute the command: `!login email`\n".
            "Replace *email* with the email address you have associated with your Oryxbot account.\n".
            "Once you connect your account, you will be granted the appropriate role.\n".
            "Happy botting!";
    }

    public function login(Message $message, $email) {
        $endpoint = "https://oryxbot.com/api/v1/discord/login";
        $request = (new PendingRequest)->acceptJson();
        $response = new Response($request->post($endpoint, [
            'email' => $email,
            'discord_id' => $message->author->id,
        ]));

        // Validation Error
        if ($response->status() == 422) {
            if ($emailErrorMessage = $response->json('errors.email.0')) {
                $message->reply($emailErrorMessage);
            } else if ($errorMessage = $response->json('message')) {
                $message->reply($errorMessage);
            } else {
                $message->reply("Something went wrong.");
            }
        }
        if ($response->ok()) {
            $message->reply("You have successfully linked Discord with your Oryxbot account.");
        }
    }
}
