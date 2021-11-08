@extends('layouts.app')

@section('title', __('titles.usage'))
@section('meta:description', __('meta.usage_description'))

@section('hero')
    <x-main-hero>

        <div class="flex flex-col-reverse">
            <div class="flex flex-col lg:flex-row justify-between">
                <h1 class="mb-0 text-5xl font-bold leading-tight">
                    How to use
                </h1>
                <i class="fas fa-compass text-5xl p-2"></i>
            </div>

            <h2 class="uppercase tracking-loose w-full">
                What's it all about
            </h2>
        </div>

        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white opacity-25 my-0 py-0 rounded-t"></div>
        </div>

        <p class="leading-normal text-lg mb-2">
            Welcome to the usage guide for the latest version of Oryxbot.
            This guide is updated regularly to keep up with updates.
        </p>
        <p class="leading-normal text-lg mb-2">
            If you have not yet installed Oryxbot and are encountering issues, please refer to the
            <a class="font-bold text-gray-800 hover:underline" href="{{ route('install') }}">Installation instructions</a>.
        </p>

    </x-main-hero>
@endsection

@section('content')

    <div class="anchor" id="steps"></div>
    <section class="bg-gray-900 py-8 pb-20">

        <div class="container mx-auto px-2 pt-4 pb-2 text-gray-500 lg:px-32 px-10">

            <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-200 text-center">
                Instructions
            </h2>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
            </div>

            <div class="anchor" id="bank"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    1. Setup your bank appropriately
                </h3>

                <p class="text-base text-justify">
                    Oryxbot tries to remain as stealthy as possible.
                    For this reason, it expects you you have your bank set up a certain way.
                    Improvements will be made in the future to reduce setup requirements -
                    but for now, this step is necessary.
                </p>
            </div>

            <div class="flex flex-wrap justify-between my-4">
                <img src="{{ asset('images/usage/bank.webp') }}"
                     class="object-contain md:w-1/3 w-full"
                     alt="{{ __('install.step_download_img_alt') }}">
                <img src="{{ asset('images/usage/inventory.webp') }}"
                     class="object-contain md:w-1/2 w-full"
                     alt="{{ __('install.step_download_img_alt') }}">
            </div>

            <div class="anchor" id="position"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    2. Get into position
                </h3>

                <p class="text-base text-justify">
                    Make your way to the city's faction NPC and turn on faction mode.
                    Make sure you have enough carrying weight to accept the quest.
                </p>

                <div class="flex flex-wrap justify-center my-4">
                    <img src="{{ asset('images/usage/faction_on.webp') }}"
                         class="object-contain w-1/2 md:w-1/4 mb-3"
                         alt="{{ __('install.step_download_img_alt') }}">
                    <img src="{{ asset('images/usage/starting_position.webp') }}"
                         class="object-contain w-full border border-gray-700"
                         alt="{{ __('install.step_download_img_alt') }}">
                </div>
            </div>

            <div class="anchor" id="hotkeys"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    3. Start the bot
                </h3>

                <p class="text-base text-justify">
                    Make sure you're connected to the Oryxbot VPN!<br>
                    Refer to the
                    <a class="text-gray-300 font-bold hover:underline"
                       href="{{ route('install') }}#vpn">
                        VPN installation instructions
                    </a>
                    if you're having trouble with this.
                </p>

                <p class="text-base text-justify mt-2">
                    Once you're in position and you've successfully connected to the VPN, you may start the bot.
                </p>
                <p class="text-base text-justify mt-2">
                    Press the "Start" button in the dashboard, then bring the focus back to Albion Online and
                    put your hand off the mouse.
                    During the bots' operation, you must not interact with your computer. Oryxbot will take
                    control of your computer and run the trade missions.<br>
                </p>


                <div class="flex flex-wrap justify-center my-4">
                    <img src="{{ asset('images/usage/dashboard.png') }}"
                         class="object-contain w-full border border-gray-700"
                         alt="">
                </div>

                <div class="px-4 lg:px-3 flex items-center border border-primary rounded p-5 lg:mx-10 mx-0 mb-2">
                    <i class="fas fa-exclamation-circle text-4xl mr-3 text-red-400"></i>
                    <p class="text-base text-justify">
                        The connection status will only update once you have started the bot!
                    </p>
                </div>

                <div class="px-4 lg:px-3 flex items-center border border-primary rounded p-5 lg:mx-10 mx-0">
                    <i class="fas fa-info-circle text-4xl mr-3 text-gray-300"></i>
                    <p class="text-base text-justify">
                        You can control the instance via the dashboard on your mobile phone, to prevent interrupting the bot on your computer.
                    </p>
                </div>

            </div>

            <div class="anchor" id="begin"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    4. Lay back and enjoy the ride
                </h3>

                <p class="text-base text-justify">
                    You are now ready to start botting. The steps the bot will take are as follows (in order):
                </p>
                <ol class="list-decimal px-10 py-2 pb-4">
                    <li class="my-2">
                        Run to <strong class="text-gray-300">bank</strong> to unbank the required items for the quest & bank any reward items from your inventory
                    </li>
                    <li class="my-2">
                        Run back to <strong class="text-gray-300">quest NPC</strong> and accept the trade mission quest
                    </li>
                    <li class="my-2">
                        Run the <strong class="text-gray-300">trade mission</strong> route
                    </li>
                    <li class="my-2">
                        Once the character has arrived, <strong class="text-gray-300">progress</strong> the quest and run back
                    </li>
                    <li class="my-2">
                        <strong class="text-gray-300">Repeat</strong> the process
                    </li>
                </ol>

                <p class="text-base text-justify">
                    Should your character die along the way, the bot will stop working. Unfortunately, character
                    death is not yet handled on our part, but will definitely be implemented in future updates.
                </p>
            </div>

        </div>

    </section>

@endsection
