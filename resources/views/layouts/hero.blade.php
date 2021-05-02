<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>
        @hasSection('title')@yield('title') - @endif{{ 'Oryxbot - ' . __('titles.main') }}
    </title>

    <meta name="description" content="@yield('meta:description', __('meta.main_description'))">
    <meta name="keywords" content="Albion, Online, Bot, Trade, Mission, Silver, Run, Route, Cheat, Hack, External, Game, Automate, Program">
    <meta name="author" content="Oryxbot">

    @section('og:title')
        <meta property="og:title" content="@hasSection('title')@yield('title') - @endif{{ 'Oryxbot - ' . __('titles.main') }}" />
    @show
    @section('og:description')
        <meta name="og:description" content="@yield('meta:description', __('meta.main_description'))" />
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

    @stack('head')
    @include('partials.onesignal')
</head>

<body class="leading-normal tracking-normal text-white bg-white" style="font-family: 'Source Sans Pro', sans-serif;">

<div class="gradient">
    @section('nav')
        @include('partials.nav')
    @show

    <main class="relative">
        <canvas id="gradient-canvas">
        </canvas>
        @yield('content')
    </main>
    <div class="relative -mt-2 p-4 bg-gray-900"></div>
</div>

@include('partials.notification-download')


@section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@show
@include('partials.analytics')
</body>

</html>
