@extends('layouts.hero')

@section('title', __('titles.forgot'))


@section('content')
    <x-main-hero>
        <div class="flex flex-col-reverse">
            <div class="flex justify-center lg:justify-between">
                <h1 class="my-4 text-3xl font-bold leading-tight">{{ __('forms.forgot_header') }}</h1>
                <i class="fas fa-user-lock text-4xl p-3"></i>
            </div>

            <h2 class="uppercase tracking-loose w-full">{{ __('forms.forgot_subheader') }}</h2>
        </div>

        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white opacity-25 my-0 py-0 rounded-t"></div>
        </div>

        @if (!session('status'))
            <form class="w-full" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="email">
                            {{ __('forms.email') }}
                        </label>

                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border @error('email') border-red-700 @enderror border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="email" name="email" type="email" placeholder="{{ __('forms.email_example') }}">
                        @error('email')
                        <p class="text-red-700 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded py-4 px-8 shadow-lg"
                        type="submit">
                    {{ __('forms.forgot_form_submit') }}
                </button>
            </form>
        @else
            <p class="my-4 font-medium text-sm">
                {{ __('forms.forgot_sent_instructions') }}
            </p>
        @endif

    </x-main-hero>
@endsection



