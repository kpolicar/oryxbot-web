@extends('layouts.app')

@push('head')
    <meta property="og:video" content="{{  Storage::url('videos/oryxbot_intro.mp4') }}" />
    <meta property="og:video:width" content="1920">
    <meta property="og:video:height" content="1080">
@endpush

@section('hero')
    <x-main-hero>
        <div class="flex flex-col">
            <h1 class="uppercase tracking-loose w-full">{{ __('messages.category') }}</h1>
            <h2 class="my-4 text-5xl font-bold leading-tight">{!! __('messages.heading') !!}</h2>
        </div>
        <p class="leading-normal text-2xl mb-8">{{ __('messages.subheading') }}</p>
        <a href="{{ route('register') }}"
           class="inline-block mx-auto lg:mx-0 hover:underline bg-gray-900 text-gray-200 font-bold rounded mt-6 py-4 px-8 shadow-lg">
            {{ __('common.signup') }}
        </a>
    </x-main-hero>
@endsection

@section('content')
    @include('partials.features')
    @include('partials.introvideo')
    @include('partials.pricing')

    <aside id="notification" class="text-white pr-6 py-4 border-0 rounded-lg m-2 bg-green-800 fixed bottom-0 w-auto z-10 opacity-75">
        <span class="inline-block align-middle mx-5 mr-8">
            <strong>APRIL 2024</strong>: Use promocode <strong>RELEASE2024</strong> for <strong>100% OFF</strong>
      </span>
        <button id="notification-close" data-hide="#notification"  class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
            <span>×</span>
        </button>
    </aside>
@endsection
