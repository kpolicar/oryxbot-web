@extends('layouts.hero')

@section('title', __('titles.discord-link'))
@section('meta:description', __('meta.discord_link_description'))

@section('head')
    <meta name="robots" content="noindex">
@endsection

@section('content')
    <x-main-hero>
        <div class="flex flex-col-reverse">
            <div class="flex flex-col lg:flex-row justify-between">
                <h1 class="mb-0 text-5xl font-bold leading-tight">
                    Link successful
                </h1>
                <i class="fab fa-discord text-5xl p-2"></i>
            </div>

            <h2 class="uppercase tracking-loose w-full">Discord</h2>
        </div>

        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white opacity-25 my-0 py-0 rounded-t"></div>
        </div>

        <p>
            <strong>You have successfully connected Discord with your Oryxbot account.</strong><br>
            You should be receiving a message confirming
            the successful link from the Oryxbot Discord Bot shortly.
        </p>
        <p>
            If you do not receive a message from the bot, please notify the Oryxbot staff.
        </p>
        <p>
            Now that you have linked your account with Discord, you will be receiving notifications
            during your botting sessions. Enjoy!
        </p>
        <p class="my-4">
            Your Discord ID is <b>{{ request()->user()->discord_id ?? '―' }}</b>
        </p>
    </x-main-hero>
@endsection
