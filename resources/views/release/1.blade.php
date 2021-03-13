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
                        <span class="pt-1"><strong class="text-gray-300">Default</strong> trade route mission on road in <strong class="text-gray-300">Lymhurst</strong>
                        </span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1"><strong class="text-gray-300">Repeatable</strong> trade mission runs
                            - <strong class="text-gray-300">banks reward</strong> items and
                            <strong class="text-gray-300">unbanks required token</strong> items
                        </span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">Basic behavior for
                            <strong class="text-gray-300">avoiding character from getting stuck</strong>
                            between obstacles
                        </span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">Works at <strong class="text-gray-300">any screen resolution</strong> with the
                            game in full-screen mode
                        </span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">Works with <strong class="text-gray-300">FPS freezing</strong>,
                            although the bot will often stop moving while the screen is frozen
                        </span>
                    </li>
                </ul>

                <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-200 mt-10">Upcoming</h2>
                <div class="w-full mb-4">
                    <div class="h-1 gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
                </div>

                <ul class="text-gray-500 p-6 px-4 -mx-2 rounded-lg">
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">
                            Add <strong class="text-gray-300">default routes</strong> for other Albion cities
                        </span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">
                            Record and run <strong class="text-gray-300">custom routes</strong>
                        </span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">Improve behavior for
                            <strong class="text-gray-300">avoiding character from getting stuck</strong>
                            between obstacles
                        </span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">Improve <strong class="text-gray-300">NPC interactions</strong></span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">
                            Improve the <strong class="text-gray-300">running</strong> algorithm,
                            <strong class="text-gray-300">reduce twitchy</strong> behavior,
                            improve dealing with the game's <strong class="text-gray-300">FPS freezing</strong>
                        </span>
                    </li>
                    <li class="py-3 flex">
                        <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                        <span class="pt-1">Restart the bot <strong class="text-gray-300">on character death</strong></span>
                    </li>
                </ul>

            </div>
            <x-limitations :restrictions="['in_foreground', 'stable_connection']" />
        </div>

    </section>

@endsection
