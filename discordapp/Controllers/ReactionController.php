<?php namespace DiscordApp\Controllers;


use Discord\Parts\User\User;
use Discord\Parts\WebSockets\MessageReaction;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

class ReactionController
{
    public function handle(User $user, MessageReaction $reaction)
    {
        $endpoint = "https://oryxbot.com/api/v1/discord/link-generate";

        $request = (new PendingRequest)->acceptJson();
        $response = new Response($request->post($endpoint, [
            'id' => $reaction->user_id,
        ]));

        if ($response->ok()) {
            $user->sendMessage($response->body());
        } else {
            $user->sendMessage("Something went wrong.");
        }
    }
}
