@extends('layouts.hero')

@section('title', __('titles.verify'))


@section('content')
    <x-main-hero>

        <div class="flex flex-col-reverse">
            <div class="flex justify-center lg:justify-between">
                <h1 class="my-4 text-3xl font-bold leading-tight">
                    {{ __('forms.verify_header') }}
                </h1>
                <i class="fas fa-user-shield text-4xl p-3"></i>
            </div>

            <h2 class="uppercase tracking-loose w-full">
                {{ __('forms.verify_subheader') }}
            </h2>
        </div>

        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white opacity-25 my-0 py-0 rounded-t"></div>
        </div>

        @if (!session('status'))
            <p>
                {{ __('forms.verify_instructions_send') }} <strong>{{ Auth::user()->email }}</strong>.
            </p>
            <p>
                {{ __('forms.verify_instructions_complete') }}
            </p>

            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded py-4 px-8 mt-8 shadow-lg"
                        type="submit">
                    {{ __('forms.verify_action') }}
                </button>
            </form>

        @else
            <p>
                {{ __('forms.verify_instructions_sent') }} <strong>{{ Auth::user()->email }}</strong>.
            </p>
            <p>
                {{ __('forms.verify_instructions_complete') }}
            </p>
            <a href="{{ route('profile') }}" class="inline-block mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded py-4 px-8 mt-8 shadow-lg">
                {{ __('forms.verify_action_back') }}
            </a>
        @endif

        <p class="text-gray-400 text-sm mt-4">
            @section('support_email')
                <a href="mailto:support@oryxbot.com" class="font-bold">support@oryxbot.com</a>
            @endsection
            {!! __('forms.verify_instructions_unexpected', ['link' => View::getSection('support_email')]) !!}
        </p>

    </x-main-hero>
@endsection
