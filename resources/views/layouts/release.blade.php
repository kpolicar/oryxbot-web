@extends('layouts.app')

@section('title', $version['name'].' - Release Notes')

@section('link:alternate')
    @if (LaravelLocalization::getCurrentLocale() != ($defaultLocale = LaravelLocalization::getDefaultLocale()))
        <link rel="canonical" href="{{ LaravelLocalization::getLocalizedURL($defaultLocale, null, [], true) }}" />
    @endif
    @parent
@endsection

@section('hero')
    <x-main-hero>

        <h2 class="tracking-loose text-xl w-full font">{{ $version['name'] }}</h2>
        <h1 class="mb-0 text-5xl font-bold leading-tight">Release notes</h1>
        @if ('date')
        <h2 class="mb-4 font-bold tracking-loose text-lg w-full font">@yield('date')</h2>
        @endif

        <p class="leading-normal text-lg mb-2">
            @yield('welcome', 'Welcome to this release of Oryxbot!')
            <small class="text-sm font-bold">({{ Str::before($version['name'], '.') }}.*)</small>
        </p>
        <p class="leading-normal text-lg mb-2">
            Below you will find important information regarding this version of the bot client.
            Read the release notes carefully so you know what to watch out for.
        </p>

    </x-main-hero>
@endsection
