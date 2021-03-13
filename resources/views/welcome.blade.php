@extends('layouts.app')

@section('head')
    <meta property="og:video" content="{{ storage_path('videos/oryxbot_intro.mp4') }}" />
    <meta property="og:video:width" content="1920">
    <meta property="og:video:height" content="1080">
@show

@section('hero')
    <x-main-hero>
        <div class="flex flex-col-reverse">
            <h1 class="my-4 text-5xl font-bold leading-tight">{!! __('messages.heading') !!}</h1>
            <h2 class="uppercase tracking-loose w-full">{{ __('messages.category') }}</h2>
        </div>
        <p class="leading-normal text-2xl mb-8">{{ __('messages.subheading') }}</p>
        <a href="{{ asset($download_asset) }}"
           download
           class="inline-block mx-auto lg:mx-0 hover:underline bg-gray-900 text-gray-200 font-bold rounded mt-6 py-4 px-8 shadow-lg">
            {{ __('common.download') }}
        </a>
        <p class="my-2">
            <a href="{{ route('install') }}" class="text-gray-700 font-bold hover:underline">
                {{ __('messages.install_instructions') }}
            </a>
        </p>
    </x-main-hero>
@endsection

@section('content')
    @include('partials.features')
    @include('partials.introvideo')
    @include('partials.pricing')
@endsection
