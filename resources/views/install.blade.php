@extends('layouts.app')

@section('title', __('titles.installation'))

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
        <a href="{{ asset($download_asset) }}"
           download
           class="inline-block mx-auto lg:mx-0 hover:underline bg-gray-900 text-gray-200 font-bold rounded my-6 py-4 px-8 shadow-lg">
            {{ __('common.download') }}
        </a>

    </x-main-hero>
@endsection

@section('content')

    <div class="anchor" id="usage"></div>
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
                    {{ __('install.step_download_description') }}
                </p>
            </div>

            <img src="{{ asset('images/install/install.webp') }}"
                 class="my-4 object-contain"
                 alt="{{ __('install.step_download_img_alt') }}">

            <div class="anchor" id="antivirus"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    1A. {{ __('install.step_download_antivirus') }}
                </h3>

                <p class="text-base mb-2 text-justify">
                    {{ __('install.step_download_antivirus_description') }}<br>
                    {{ __('install.step_download_antivirus_description_malware') }}
                </p>
                <p class="text-base text-justify">
                    @section('antivirus_avast_link')
                        <a class="font-bold text-gray-300 hover:underline" target="_blank" href="https://support.avast.com/en-ww/article/Mac-Security-scan-exclusions/">
                           {{  __('install.step_download_antivirus_avast_link') }}
                        </a>
                    @endsection
                    {!! __('install.step_download_antivirus_avast', ['link' => View::getSection('antivirus_avast_link')]) !!}
                </p>
            </div>

            <div class="anchor" id="dependency"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    1B. {{ __('install.step_download_dependency') }}
                </h3>

                <p class="text-base mb-2 text-justify">
                    {{ __('install.step_download_dependency_target') }}
                </p>
                <p class="text-base mb-2 text-justify">
                    {{ __('install.step_download_dependency_target_detailed') }}
                </p>
                <p class="text-base text-justify">
                    @section('download_official')
                    <a class="font-bold text-gray-300 hover:underline" target="_blank" href="https://support.microsoft.com/en-us/help/2977003/the-latest-supported-visual-c-downloads">
                        {{ __('install.step_download_dependency_download_link_official') }}
                    </a>
                    @endsection
                    @section('download_direct')
                    <a class="font-bold text-gray-300 hover:underline" href="https://aka.ms/vs/16/release/vc_redist.x86.exe" download data-external>
                        {{ __('install.step_download_dependency_download_link_direct') }}
                    </a>
                    @endsection

                    {!! __('install.step_download_dependency_download', [
                        'link_official' => View::getSection('download_official'),
                        'link_direct' => View::getSection('download_direct')
                    ]) !!} <br>

                    {{ __('install.step_download_dependency_download_32bit') }}
                </p>
            </div>

            <div class="anchor" id="extract"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    2. {{ __('install.step_extract') }}
                </h3>

                <p class="text-base text-justify">
                    {!! __('install.step_extract_description', ['password' => '<strong class="text-gray-300">"'.$download_password.'"</strong>']) !!}
                </p>
            </div>

            <div class="flex items-middle justify-center flex-wrap">
                <img src="{{ asset('images/install/extract.webp') }}"
                     class="xl:w-3/4 w-full my-4 object-contain pr-1"
                     alt="{{ __('install.step_extract_img_alt') }}" />
                <img src="{{ asset('images/install/password.webp') }}"
                     class="xl:w-1/4 w-full my-4 object-contain pl-1 h-64 xl:h-auto"
                     alt="{{ __('install.step_extract_img_alt') }}" />
            </div>

            <div class="anchor" id="run"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    3. Install dependencies
                </h3>

                <p class="text-base text-justify">
                    Run the <strong class="text-gray-300">setup.npcap-1.00.exe</strong> file to install Oryxbot's dependency. This program
                    allows Oryxbot to monitor your network's traffic and is therefore needed to listen in on the
                    Albion client's messaging with their server. You need only go through this setup once - you do not need to repeat the
                    process when updating to newer Oryxbot versions.
                </p>
            </div>

            <img src="{{ asset('images/install/run_setup.webp') }}"
                 class="my-4 xl:w-2/3 w-full object-contain"
                 alt="{{ __('install.step_run_img_alt') }}" />

            <div class="anchor" id="run"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    4. {{ __('install.step_run') }}
                </h3>

                <p class="text-base text-justify">
                    {{ __('install.step_run_description') }}
                </p>
            </div>

            <img src="{{ asset('images/install/run_as_admin.webp') }}"
                 class="my-4 xl:w-2/3 w-full object-contain"
                 alt="{{ __('install.step_run_img_alt') }}" />

            <div class="px-4 lg:px-0">
                <h3 class=" w-full text-xl font-bold leading-tight text-gray-300 uppercase">
                    5. {{ __('install.step_finish') }}
                </h3>

                <p class="text-base text-justify">
                    {{ __('install.step_finish_description') }}
                </p>
            </div>

            <div class="flex flex-wrap items-bottom justify-between">
                <img src="{{ asset('images/install/login.webp') }}"
                     class="my-4 md:w-1/2 w-full object-contain"
                     alt="{{ __('install.step_finish_img_alt') }}" />

                <img src="{{ asset('images/install/system_tray.webp') }}"
                     class="my-4 md:w-1/2 w-full object-contain"
                     alt="{{ __('install.step_finish_img_alt') }}" />
            </div>

            <p class="text-xl">
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
