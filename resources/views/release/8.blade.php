@extends('layouts.app')

@section('title', 'v1.0 - Release Notes')
@section('meta:description', __('meta.news_description'))


@section('hero')
    <x-main-hero>

        <h2 class="tracking-loose text-xl w-full font">v2.0</h2>
        <h1 class="mb-0 text-5xl font-bold leading-tight">Release notes</h1>
        <h2 class="mb-4 font-bold tracking-loose text-lg w-full font">14th April 2023</h2>
        <p class="leading-normal text-lg mb-2">
            Welcome to the official rework of Oryxbot!
        </p>
        <p class="leading-normal text-lg mb-2">
            Below you will find important information regarding this version of the bot client.
            Read the release notes carefully so you know what to watch out for.
        </p>

    </x-main-hero>
@endsection

@section('content')


    <section class="bg-gray-900 py-8">


        <div class="container mx-auto pt-4 pb-12">

            <div class="flex flex-col lg:flex-row">
                <div class="mx-auto flex flex-col w-full lg:w-3/5 p-6 px-4">

                    <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-200">What's new</h2>
                    <div class="w-full mb-4">
                        <div class="h-1 gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
                    </div>

                    <ul class="text-gray-500 p-6 px-4 -mx-2 rounded-lg">
                        <li class="py-3 flex">
                            <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                            <span>
                                Reworked <strong class="text-gray-300">Oryxbot client</strong>: it is now hosted on the
                                user's Digital Ocean
                            </span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                            <span>
                                Created a new <strong class="text-gray-300">installation wizard</strong> for setting up an Oryxbot-managed Digital Ocean droplet
                            </span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                            <span>
                                Bot is once again <strong class="text-gray-300">undetected by EAC</strong>
                            </span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                            <span>
                                Added <strong class="text-gray-300">live logs</strong> to the dashboard
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
                            <span class="pt-1">Improve the <strong class="text-gray-300">dashboard controls</strong>, more consistent functionality</span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                            <span class="pt-1">Add more <strong class="text-gray-300">live data</strong> about the game to the dashboard</span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                            <span class="pt-1">Fix the <strong class="text-gray-300">VPN and VNC status indicators</strong></span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                            <span class="pt-1">Re-add the feature for recording <strong class="text-gray-300">custom trade mission routes</strong></span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                            <span class="pt-1">Add additional <strong class="text-gray-300">trade mission locations</strong></span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                            <span class="pt-1">Improve behavior for when the <strong class="text-gray-300">bot is stuck</strong></span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                            <span class="pt-1">Recover the trade mission <strong class="text-gray-300">when the character dies</strong></span>
                        </li>
                    </ul>

                </div>
                <x-limitations :restrictions="['in_foreground', 'full_screen', 'needs_assistance']" />
            </div>

            <a href="{{ route('release', ['version' => 'v0.6beta']) }}" class="flex items-center group" style="width: fit-content">
                <i class="fas fa-backward text-3xl pr-4 transform group-hover:-translate-x-2 duration-100"></i>
                <span class="group-hover:underline">
                Check out the <strong class="text-gray-300">previous release notes</strong>
                </span>
            </a>
        </div>

    </section>

@endsection
