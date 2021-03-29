@extends('layouts.hero')

@section('content')
    <x-main-hero>
        <div class="flex flex-col-reverse">
            <div class="flex justify-center lg:justify-between">
                <h1 class="my-4 text-3xl font-bold leading-tight">
                    {{ __('forms.login_header') }}
                </h1>
                <i class="fas fa-sign-in-alt text-4xl p-3"></i>
            </div>

            <h2 class="uppercase tracking-loose w-full">
                {{ __('forms.login_subheader') }}
            </h2>
        </div>

        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white opacity-25 my-0 py-0 rounded-t"></div>
        </div>

        @include('partials/login-form')

        <p class="mt-3 text-gray-900 text-base lg:text-left text-center">
            <a href="{{ route('password.request') }}" class="font-bold">
                {{ __('forms.login_form_forgot_password') }}
            </a>
        </p>
    </x-main-hero>
@endsection


