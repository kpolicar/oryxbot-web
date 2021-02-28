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
            {{ __('install.refer_release_notes') }}
            <a class="font-bold text-gray-500" href="{{ route('release', ['version' => 'latest']) }}">{{ __('install.refer_release_notes_link') }}</a>.
        </p>
        <a href="{{ asset($download_asset) }}"
           download
           class="inline-block mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded my-6 py-4 px-8 shadow-lg">
            {{ __('common.download') }}
        </a>

    </x-main-hero>
@endsection

@section('engage_comingfrom', '#ffffff')
@section('content')

    <div class="anchor" id="usage"></div>
    <section class="bg-white py-8 pb-12">

        <div class="container mx-auto px-2 pt-4 pb-2 text-gray-800">

            <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
                {{ __('install.steps') }}
            </h2>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
            </div>

            <div class="anchor" id="download"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-700 uppercase">
                    1. {{ __('install.step_download') }}
                </h3>

                <p class="text-base">
                    {{ __('install.step_download_description') }}
                </p>
            </div>

            <img src="{{ asset('images/installation/downloadfolder.png') }}"
                 class="my-4"
                 alt="{{ __('install.step_download_img_alt') }}">

            <div class="anchor" id="antivirus"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-700 uppercase">
                    1A. {{ __('install.step_download_antivirus') }}
                </h3>

                <p class="text-base mb-2">
                    {{ __('install.step_download_antivirus_description') }}<br>
                    {{ __('install.step_download_antivirus_description_malware') }}
                </p>
                <p class="text-base">
                    @section('antivirus_avast_link')
                        <a class="font-bold text-gray-800" target="_blank" href="https://support.avast.com/en-ww/article/Mac-Security-scan-exclusions/">
                           {{  __('install.step_download_antivirus_avast_link') }}
                        </a>
                    @endsection
                    {!! __('install.step_download_antivirus_avast', ['link' => View::getSection('antivirus_avast_link')]) !!}
                    {{ __('install.step_download_antivirus_avast_link') }}
                </p>
            </div>

            <div class="anchor" id="dependency"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-700 uppercase">
                    1B. {{ __('install.step_download_dependency') }}
                </h3>

                <p class="text-base mb-2">
                    {{ __('install.step_download_dependency_target') }}
                </p>
                <p class="text-base mb-2">
                    {{ __('install.step_download_dependency_target_detailed') }}
                </p>
                <p class="text-base">
                    @section('download_official')
                    <a class="font-bold text-gray-800" target="_blank" href="https://support.microsoft.com/en-us/help/2977003/the-latest-supported-visual-c-downloads">
                        {{ __('install.step_download_dependency_download_link_official') }}
                    </a>
                    @endsection
                    @section('download_direct')
                    <a class="font-bold text-gray-800" href="https://aka.ms/vs/16/release/vc_redist.x86.exe" download data-external>
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
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-700 uppercase">
                    2. {{ __('install.step_extract') }}
                </h3>

                <p class="text-base">
                    {!! __('install.step_extract_description', ['password' => $download_password]) !!}
                </p>
            </div>

            <img src="{{ asset('images/installation/extracthere.png') }}"
                 class="my-4"
                 alt="{{ __('install.step_extract_img_alt') }}" />

            <div class="anchor" id="run"></div>
            <div class="px-4 lg:px-0">
                <h3 class="mt-10 w-full text-xl font-bold leading-tight text-gray-700 uppercase">
                    3. {{ __('install.step_run') }}
                </h3>

                <p class="text-base">
                    {{ __('install.step_run_description') }}
                </p>
            </div>

            <img src="{{ asset('images/installation/runasadmin.png') }}"
                 class="my-4"
                 alt="{{ __('install.step_run_img_alt') }}" />

            <div class="anchor" id="path"></div>
            <div class="flex flex-col lg:flex-row mt-10">
                <div class="px-4 lg:px-0 lg:w-1/3 mr-4">
                    <h3 class="w-full text-xl font-bold leading-tight text-gray-700 uppercase">
                        4. {{ __('install.step_path') }}
                    </h3>
                    <p class="text-base">
                        {{ __('install.step_path_folder_default') }}
                    </p>
                    <p class="text-sm text-gray-500">
                        %APPDATA%\..\Local\Ankama\zaap\dofus\dofus.exe
                    </p>
                    <p class="text-base">
                        {{ __('install.step_path_folder_launcher') }}
                    </p>

                    <img src="{{ asset('images/installation/selectpath.png') }}"
                         class="my-4"
                         alt="">
                </div>

                <div class="lg:w-2/3 ml-4">
                    <img src="{{ asset('images/installation/savelocation.png') }}"
                         class="mb-4"
                         alt="">
                </div>
            </div>

            <div class="px-4 lg:px-0">
                <h3 class=" w-full text-xl font-bold leading-tight text-gray-700 uppercase">
                    5. {{ __('install.step_finish') }}
                </h3>

                <p class="text-base">
                    {{ __('install.step_finish_description') }}
                </p>
            </div>

            <img src="{{ asset('images/installation/logindialogue.png') }}"
                 class="my-4"
                 alt="{{ __('install.step_finish_img_alt') }}" />

            <p class="text-xl">
                <i class="fas fa-caret-right"></i>
                @section('usage')
                <a class="font-bold text-gray-800" href="{{ route('release', ['version' => 'latest']) }}#usage">
                    {{ __('install.step_finish_continue_link') }}
                </a>
                @endsection
                {!! __('install.step_finish_continue', ['link' => View::getSection('usage')]) !!}
            </p>

        </div>

    </section>

@endsection
