@extends('layouts.hero')

@section('title', __('titles.register'))
@section('meta:description', __('meta.register_description'))

@if (request('ref'))
    @section('og:title')
        <meta property="og:title" content="Oryxbot {{ __('titles.invite') }} - {{ __('titles.main') }}" />
    @endsection

    @section('og:description')
        @if (($user = App\Models\User::findByReferral(request('ref'))) && $user->exists)
            <meta property="og:description" content="{{ __('meta.invite_description', ['name' => App\Models\User::findByReferral(request('ref'))->name]) }}" />
        @else
            <meta property="og:description" content="{{ __('meta.invite_anonymous_description') }}" />
        @endif
    @endsection
@endif

@php($formElementId="register-form")
@include('partials/captcha', compact('formElementId'))

@section('content')
    <x-main-hero>
        <div class="flex flex-col-reverse">
            <div class="flex justify-center lg:justify-between">
                <h1 class="my-4 text-3xl font-bold leading-tight">{{ __('forms.register_header') }}</h1>
                <i class="fas fa-user-plus text-4xl p-3"></i>
            </div>

            <h2 class="uppercase tracking-loose w-full">{{ __('forms.register_subheader') }}</h2>
        </div>
        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white opacity-25 my-0 py-0 rounded-t"></div>
        </div>

        <form class="w-full" method="POST" action="{{ route('register') }}" id="{{ $formElementId }}">
            @csrf
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="name">
                        {{ __('forms.name') }}
                    </label>
                    <input class="appearance-none block w-full bg-white text-gray-700 border @error('name') border-red-700 @enderror border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="name" name="name" type="text" placeholder="{{ __('forms.name_example') }}">

                    @error('name')
                    <p class="text-red-700 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="email">
                        {{ __('forms.email') }}
                    </label>

                    <input class="appearance-none block w-full bg-white text-gray-700 border @error('email') border-red-700 @enderror border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="email" name="email" type="email" placeholder="{{ __('forms.email_example') }}">
                    @error('email')
                    <p class="text-red-700 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="password">
                        {{ __('forms.password') }}
                    </label>
                    <input class="appearance-none block w-full bg-white text-gray-700 border @error('password') border-red-700 @enderror border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="password" name="password" type="password" placeholder="******">
                    @error('password')
                    <p class="text-red-700 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @error('g-recaptcha-response')
                <p class="text-red-700 text-xs italic">{{ $message }}</p>
            @enderror

            <button class="g-recaptcha mx-auto lg:mx-0 bg-gray-900 text-gray-200 font-bold rounded py-4 px-8 shadow-lg group"
                    data-sitekey="{{ config('captcha.sitekey') }}" data-callback="onFormSubmit">
                {{ __('forms.register_form_submit') }}
                <i class="fas fa-angle-right text-lg ml-2 -mr-2 transform group-hover:translate-x-2 group-hover:translate-x-2 duration-100"></i>
            </button>
        </form>

        <p class="mt-3 text-gray-900 text-base lg:text-left text-center">
            <a href="{{ route('login') }}" class="font-bold">
                {{ __('forms.register_form_already_registered') }}
            </a>
        </p>
    </x-main-hero>
@endsection

