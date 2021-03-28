@extends('layouts.app')

@section('title', 'v0.3 - Release Notes')
@section('meta:description', __('meta.news_description'))


@section('hero')
    <x-main-hero>

        <h2 class="tracking-loose text-xl w-full font">v0.3 <span class="uppercase">Beta</span></h2>
        <h1 class="mb-0 text-5xl font-bold leading-tight">Release notes</h1>
        <h2 class="mb-4 font-bold tracking-loose text-lg w-full font">28th March 2021</h2>
        <p class="leading-normal text-lg mb-2">
            Welcome to the third release of Oryxbot!
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
                            <span class="pt-1">
                                Updated for <strong class="text-gray-300">compatibility</strong> with Albion's <strong class="text-gray-300">latest patch</strong>
                            </span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                            <span>
                                Added <strong class="text-gray-300">default routes</strong> for all Albion cities
                            </span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-plus text-3xl mr-3 text-gray-200"></i>
                            <span>
                                Improved recording <strong class="text-gray-300">custom routes</strong> - you
                                now configure for what <strong class="text-gray-300">city</strong> you are running,
                                what region is your <strong class="text-gray-300">destination</strong>
                                and you can add a <strong class="text-gray-300">label</strong> to the route
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
                            <span class="pt-1">Add additional <strong class="text-gray-300">trade mission locations</strong></span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                            <span class="pt-1">Improve <strong class="text-gray-300">NPC interactions</strong></span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                            <span class="pt-1">Support running <strong class="text-gray-300">any</strong>
                                of the trade mission types - not just 3 hearts</span>
                        </li>
                        <li class="py-3 flex">
                            <i class="fas fa-clock text-3xl mr-3 text-gray-200"></i>
                            <span class="pt-1">Restart the bot <strong class="text-gray-300">on character death</strong></span>
                        </li>
                    </ul>

                </div>
                <x-limitations :restrictions="['in_foreground', 'full_screen', 'needs_assistance']" />
            </div>

            <a href="{{ route('release', ['version' => 'v0.2beta']) }}" class="flex items-center group" style="width: fit-content">
                <i class="fas fa-backward text-3xl pr-4 transform group-hover:-translate-x-2 duration-100"></i>
                <span class="group-hover:underline">
                Check out the <strong class="text-gray-300">previous release notes</strong>
                </span>
            </a>
        </div>

    </section>

@endsection
