<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>
        @hasSection('title')@yield('title') - @endif{{ 'Oryxbot - ' . __('titles.main') }}
    </title>

    <meta name="description" content="{{ __('meta.main_description') }}">
    <meta name="keywords" content="Albion, Online, Bot, Maging, Mage, Magus, Profession, Items, Cheat, Hack, Stats, Game, Automate, Program">
    <meta name="author" content="Oryxbot">


    @section('og:title')
        <meta property="og:title" content="@hasSection('title')@yield('title') - @endif{{ 'Oryxbot - ' . __('titles.main') }}" />
    @show
    @section('og:description')
        <meta name="og:description" content="{{ __('meta.main_description') }}" />
    @show
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="{{ LaravelLocalization::getCurrentLocale() }}" />
    <meta property="og:url" content="/" />
    <meta property="og:site_name" content="Oryxbot" />
    <meta property="og:image" content="{{ asset('oryx_colored.png') }}" />

    @section('link:alternate')
        <link rel="alternate"
              hreflang="x-default"
              href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getDefaultLocale(), null, [], true) }}" />
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <link rel="alternate"
                  hreflang="{{ $localeCode }}"
                  href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" />
        @endforeach
    @show

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">

    @yield('head')
    @include('partials.onesignal')
</head>

<body class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif;">


<aside id="development-notification" class="text-white pr-6 py-4 border-0 rounded-lg bg-black fixed bottom-0 left-0 right-0 top-0 mx-2 md:mx-auto m-auto text-center w-auto z-30" style="opacity: 0.85; height: fit-content; width: fit-content">
    <span class="inline-block align-middle mx-5 mr-8 font-bold flex items-center">
        <i class="fas fa-wrench mr-3 mx-1 text-3xl"></i>
        <span class="mx-2">This project is <strong class="underline">under construction</strong>. Purchases of subscriptions will be carried over to when the bot will be up and running.</span>
  </span>
    <button id="download-notification-close" data-hide="#download-notification" class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
        <span>×</span>
    </button>
</aside>
<script>
    let devNotification = document.getElementById("development-notification");
    devNotification.addEventListener("click", () => devNotification.classList.add("hidden"))
</script>

@section('body')
@show

@section('nav')
    @include('partials.nav')
@show

<header class="relative">
    <canvas id="gradient-canvas">
    </canvas>
    @yield('hero')
</header>

<main class="relative z-10">
    @yield('content')
</main>

@section('footer')
    @include('partials.engage')
    @include('partials.footer')
@show

@include('partials.notification-download')

@section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
    @auth
        <script src="{{ mix('js/stripe.js') }}"></script>
    @endauth
@show
@include('partials.analytics')
</body>

</html>
