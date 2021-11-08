@extends('layouts.app')

@section('title', __('titles.installation'))
@section('meta:description', __('meta.instructions_description'))

@section('hero')
    <x-main-hero>

        <div class="flex flex-col-reverse">
            <div class="flex flex-col lg:flex-row justify-between">
                <h1 class="mb-0 text-5xl font-bold leading-tight">
                    {{ __('install.header') }}
                </h1>
                <i class="fas fa-cloud-download-alt text-5xl p-2"></i>
            </div>

            <h2 class="uppercase tracking-loose w-full">
                {{ __('install.subheader') }}
            </h2>
        </div>

        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white opacity-25 my-0 py-0 rounded-t"></div>
        </div>

        <p class="leading-normal text-lg mb-2">
            {{ __('install.engage') }}
        </p>
        <p class="leading-normal text-lg mb-2">
            {{ __('install.refer_usage') }}
            <a class="font-bold text-gray-800 hover:underline" href="{{ route('usage') }}">{{ __('install.refer_usage_link') }}</a>.
        </p>

    </x-main-hero>
@endsection

@section('content')

    <div class="anchor" id="steps"></div>
    <section class="bg-gray-900 py-8 pb-20">

        <div class="container mx-auto px-2 pt-4 pb-2 text-gray-500 lg:px-32 px-10">

            <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-200 text-center">
                {{ __('install.steps') }}
            </h2>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
            </div>

            <div class="anchor" id="download"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    1. {{ __('install.step_download') }}
                </h3>

                <p class="text-base text-justify">
                    Oryxbot does not run on your local computer. Instead, the bot runs on a server and connects
                    to your machine through "remote access software".
                </p>

                <p class="text-base text-justify">
                    Therefore, you will be installing software from third parties:
                </p>

                <div class="anchor" id="tightvnc"></div>
                <div class="ml-10">
                    <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300">
                        1A. TightVNC SERVER
                    </h3>

                    <p class="text-base text-justify">
                        Download from the
                        <a class="text-gray-300 font-bold inline-flex group"
                           target="_blank"
                           href="https://www.tightvnc.com/download.php">
                        <span class="group-hover:underline">
                            Official TightVNC Website
                        </span>
                            <i class="fas fa-external-link-alt text-xs mx-1 mt-1"></i>
                        </a>
                    </p>

                    <p class="text-base text-justify mt-2">
                        Alongside Albion Online, you will be running a TightVNC server on your local machine.
                        The Oryxbot server will connect to your machine's server software and take control of your computer.
                    </p>
                    <p class="text-base text-justify mt-2">
                        You will want to adjust your server settings to what you can see below:
                    </p>
                </div>
                <div class="flex flex-wrap">
                    <img src="{{ asset('images/install/tightvnc_first.png') }}"
                         class="xl:w-1/3 w-full my-4 object-contain pr-1"
                         alt="" />
                    <img src="{{ asset('images/install/tightvnc_second.png') }}"
                         class="xl:w-1/3 w-full my-4 object-contain pr-1"
                         alt="" />
                    <img src="{{ asset('images/install/tightvnc_third.png') }}"
                         class="xl:w-1/3 w-full my-4 object-contain pr-1"
                         alt="" />
                </div>
            </div>


            <div class="anchor" id="vpn"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    2. Setup VPN
                </h3>

                <p class="text-base text-justify">
                    Next, you will need to setup a VPN connection to your Oryxbot server. This is done without
                    installing any software, as VPNs are supported natively by Windows.
                </p>

                <p class="text-base text-justify">
                    It's highly recommended you follow
                    <a class="text-gray-300 font-bold inline-flex group"
                       target="_blank"
                       href="https://support.microsoft.com/en-us/windows/connect-to-a-vpn-in-windows-3d29aeb1-f497-f6b7-7633-115722c1009c">
                        <span class="group-hover:underline">Microsoft's official guide</span>
                        <i class="fas fa-external-link-alt text-xs mx-1 mt-1"></i>
                    </a>
                    for using the built-in Windows VPN.
                </p>
            </div>
        </div>

        <div class="flex items-middle justify-center flex-wrap px-5">
            <img src="{{ asset('images/install/add_vpn.png') }}"
                 class="xl:w-1/2 w-full my-4 object-contain pr-1"
                 alt="{{ __('install.step_extract_img_alt') }}" />
            <img src="{{ asset('images/install/vpn_settings.png') }}"
                 class="xl:w-1/2 w-full my-4 object-contain pl-1"
                 alt="{{ __('install.step_extract_img_alt') }}" />
        </div>

        <div class="container mx-auto px-2 pt-4 pb-2 text-gray-500 lg:px-32 px-10">
            <div class="px-4 lg:px-3 flex items-center border border-primary rounded p-5 lg:mx-10 mx-0">
                <i class="fas fa-info-circle text-4xl mr-3 text-gray-300"></i>
                <p class="text-base text-justify">
                    You can find the connection details for your server (IP address, login credentials)
                    on your instance page in the
                    <a class="text-gray-300 hover:underline font-bold"
                       target="_blank"
                       href="{{ Request::getScheme().'://'.config('nova.domain') }}">dashboard</a>.
                </p>
            </div>

            <p class="text-xl mt-10">
                <i class="fas fa-caret-right"></i>
                @section('usage')
                <a class="font-bold text-gray-300 hover:underline" href="{{ route('usage') }}">
                    {{ __('install.step_finish_continue_link') }}
                </a>
                @endsection
                {!! __('install.step_finish_continue', ['link' => View::getSection('usage')]) !!}
            </p>

        </div>

    </section>

@endsection
