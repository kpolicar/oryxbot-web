@extends('layouts.app')

@section('title', 'v1.0 - Release Notes')


@section('hero')
    <x-main-hero>

        <h2 class="tracking-loose text-xl w-full font">v1.0</h2>
        <h1 class="mb-0 text-5xl font-bold leading-tight">Release notes</h1>
        <h2 class="mb-4 font-bold tracking-loose text-lg w-full font">1st April 2021</h2>
        <p class="leading-normal text-lg mb-2">
            Welcome to the first release of Oryxbot! We did it!
        </p>
        <p class="leading-normal text-lg mb-2">
            Below you will find important information regarding this version of the bot client.
            Read the release notes carefully so you know what to watch out for.
        </p>
        <p class="leading-normal text-lg mb-8">
            Bear in mind this is an early release. <br> Much is yet to be added & improved.
        </p>

    </x-main-hero>
@endsection

@section('content')


    <section class="bg-gray-900 py-8">


        <div class="container mx-auto flex flex-col lg:flex-row pt-4 pb-12">

            <div class="mx-auto flex flex-col w-full lg:w-3/5 p-6">

                <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-200">What's new</h2>
                <div class="w-full mb-4">
                    <div class="h-1 gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
                </div>

                <ul class="text-gray-500 p-6 px-4 -mx-2 rounded-lg">
                    <li class="py-3 flex">
                        <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1"><strong class="text-gray-300">Simple maging AI</strong> mages until the desired stats are achieved.
                            The stats will never go over the defined limits and the appropriate rune (SM, PA, RA) for the current
                            stat value will be used.<br>
                            <a href="#ai" class="text-gray-600">Read more</a>
                        </span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1"><strong class="text-gray-300">Stats configurator</strong> allows you to specify what stats you want on your item</span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1"><strong class="text-gray-300">Error detection</strong> will stop the mage if an unexpected stat landed (this may happen
                        if you run out of runes or due to poor internet connection)</span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1"><strong class="text-gray-300">Error notifications</strong> will notify you when something went wrong - this will
                        happen often as this version is not very stable</span>
                    </li>
                </ul>

                <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-200 mt-10">Upcoming</h2>
                <div class="w-full mb-4">
                    <div class="h-1 gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
                </div>

                <ul class="text-gray-500 p-6 px-4 -mx-2 rounded-lg">
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">Support usage of the bot in <strong class="text-gray-300">any resolution</strong></span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">Allow the bot to run when the window is in <strong class="text-gray-300">minimized mode</strong></span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">Fix <strong class="text-gray-300">user input interference</strong> with the bot's input</span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1"><strong class="text-gray-300">Detailed logs</strong> for errors, warnings and simply maging information</span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1"><strong class="text-gray-300">French translation</strong> to allow running Dofus in English & French</span>
                    </li>
                </ul>

            </div>
            <x-limitations :restrictions="['in_foreground', 'stable_connection']" />
        </div>

    </section>

@endsection
