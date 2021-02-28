@extends('layouts.app')

@section('title', 'v0.1 Beta - Release Notes')


@section('hero')
    <x-main-hero>

        <h2 class="tracking-loose text-xl w-full font">v0.1 BETA</h2>
        <h1 class="mb-0 text-5xl font-bold leading-tight">Release notes</h1>
        <h2 class="mb-4 font-bold tracking-loose text-lg w-full font">1st November 2020</h2>
        <p class="leading-normal text-lg mb-2">
            Welcome to the first release of Oryxbot! We did it!
        </p>
        <p class="leading-normal text-lg mb-2">
            Below you will find important information regarding this version of the bot client.
            Read the release notes carefully so you know what to watch out for.
        </p>
        <p class="leading-normal text-lg mb-8">
            Bear in mind this is an early release, therefore it may be unstable and rather restrictive.
        </p>

    </x-main-hero>
@endsection

@section('content')


    <section class="bg-white py-8 border-b">


        <div class="container mx-auto flex flex-col lg:flex-row pt-4 pb-12">

            <div class="mx-auto flex flex-col w-full lg:w-3/5 p-6">

                <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-800">What's new</h2>
                <div class="w-full mb-4">
                    <div class="h-1 gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
                </div>

                <ul class="text-black">
                    <li class="p-3 pl-0 flex">
                        <i class="fas fa-plus text-3xl mr-3"></i>
                        <span class="pt-1"><strong>Simple maging AI</strong> mages until the desired stats are achieved.
                            The stats will never go over the defined limits and the appropriate rune (SM, PA, RA) for the current
                            stat value will be used.<br>
                            <a href="#ai" class="text-gray-600">Read more</a>
                        </span>
                    </li>
                    <li class="p-3 pl-0 flex">
                        <i class="fas fa-plus text-3xl mr-3"></i>
                        <span class="pt-1"><strong>Stats configurator</strong> allows you to specify what stats you want on your item</span>
                    </li>
                    <li class="p-3 pl-0 flex">
                        <i class="fas fa-plus text-3xl mr-3"></i>
                        <span class="pt-1"><strong>Error detection</strong> will stop the mage if an unexpected stat landed (this may happen
                        if you run out of runes or due to poor internet connection)</span>
                    </li>
                    <li class="p-3 pl-0 flex">
                        <i class="fas fa-plus text-3xl mr-3"></i>
                        <span class="pt-1"><strong>Error notifications</strong> will notify you when something went wrong - this will
                        happen often as this version is not very stable</span>
                    </li>
                </ul>

                <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-800 mt-10">Upcoming</h2>
                <div class="w-full mb-4">
                    <div class="h-1 gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
                </div>

                <ul class="text-black">
                    <li class="p-3 pl-0 flex">
                        <i class="fas fa-clock text-3xl mr-3"></i>
                        <span class="pt-1">Support usage of the bot in <strong>any resolution</strong></span>
                    </li>
                    <li class="p-3 pl-0 flex">
                        <i class="fas fa-clock text-3xl mr-3"></i>
                        <span class="pt-1">Allow the bot to run when the window is in <strong>minimized mode</strong></span>
                    </li>
                    <li class="p-3 pl-0 flex">
                        <i class="fas fa-clock text-3xl mr-3"></i>
                        <span class="pt-1">Fix <strong>user input interference</strong> with the bot's input</span>
                    </li>
                    <li class="p-3 pl-0 flex">
                        <i class="fas fa-clock text-3xl mr-3"></i>
                        <span class="pt-1"><strong>Detailed logs</strong> for errors, warnings and simply maging information</span>
                    </li>
                    <li class="p-3 pl-0 flex">
                        <i class="fas fa-clock text-3xl mr-3"></i>
                        <span class="pt-1"><strong>French translation</strong> to allow running Dofus in English & French</span>
                    </li>
                </ul>

            </div>
            <x-limitations :restrictions="['1920x1080', 'administrator', 'in_background', 'stable_connection']" />
        </div>

    </section>

    <div class="anchor" id="usage"></div>
    <section class="bg-gray-100 py-8 pb-12">

        <div class="container mx-auto px-2 pt-4 pb-2 text-gray-800">

            <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">How to use</h2>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
            </div>

            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-700 uppercase">
                    1. Open Oryxbot and Login
                </h3>
                <p class="text-base">You will need to login to your Oryxbot account to gain access to the Dofus client. From there on
                    you can login to your Dofus account as you would normally.</p>
            </div>

            <img src="{{ asset('images/releases/login.jpg') }}" class="shadow-lg rounded-t rounded-b-xl my-4" alt="">

            <div class="anchor" id="ocr-bounds"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-700 uppercase">
                    2. Ensure the OCR indicators cover the appropriate bounds
                </h3>
                <p class="text-base">
                    You can view the OCR bounds by pressing the "Debug" button on the sidebar.
                    The bot is configured to run in 1920x1080 resolution simply because it's the most common resolution,
                    thus if you are running in this resolution you will not encounter issues. Run the bot in full-screen mode
                    and make sure your Windows display settings are not scaled over 100%.
                </p>
            </div>

            <img src="{{ asset('images/releases/ocr.jpg') }}" class="shadow-lg rounded-t rounded-b-xl my-4" alt="">

            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-700 uppercase">
                    3. Configure your stats and begin maging!
                </h3>
                <p class="text-base">
                    You can access the stats configurator by pressing the "Stats" button on the sidebar.
                    You will know the bot is finished when it removes the item from the maging table.
                </p>
                <p class="text-base">Make sure you do not have any runes on the maging table when you begin.</p>
            </div>

            <img src="{{ asset('images/releases/stats.gif') }}" class="shadow-lg rounded-t rounded-b-xl my-4" alt="">
        </div>

    </section>

    @include('release.content.basic_ai')

    @include('release.content.notes')

@endsection
