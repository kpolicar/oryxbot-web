@extends('layouts.hero')

@section('title', __('titles.free-trial'))

@section('content')
    <x-main-hero>
        <div class="flex flex-col-reverse">
            <div class="flex flex-col lg:flex-row justify-between">
                <h1 class="mb-0 text-5xl font-bold leading-tight">
                    Free trial
                </h1>
                <i class="fas fa-hand-holding-heart text-5xl p-2"></i>
            </div>

            <h2 class="uppercase tracking-loose w-full">
                Get to know Oryxbot
            </h2>
        </div>

        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white opacity-25 my-0 py-0 rounded-t"></div>
        </div>

        <p class="leading-normal text-lg mb-2">
            So you would like to try Oryxbot, but you're not willing to commit just yet?
        </p>
        <p class="leading-normal text-lg mb-2">
            <strong>Unfortunately, Oryxbot no longer offers a free trial.</strong>
            {{-- You're in luck! Oryxbot offers a <strong>3 days free trial</strong>. The free version is limited to
            default routes on roads. If you want to record and run your own custom routes, you will need
            to purchase the full version of Oryxbot.--}}
        </p>
        {{--<p class="leading-normal text-lg mb-2">
            After the free trial expires your billing cycle will begin and you will be charged on the card you
            have provided.
            You can cancel your subscription at any time on your profile page.
        </p>--}}

        @auth
            <x-billing-button trial class="inline-block mx-auto lg:mx-0 hover:underline bg-gray-900 text-gray-200 font-bold rounded mt-6 py-4 px-8 shadow-lg group">
                @if (!Auth::user()->eligibleForFreeTrial())
                    {{ __('common.manage') }}
                @else
                    {{  __('common.activate') }}
                    <i class="fas fa-angle-right text-lg ml-2 -mr-2 @if(Auth::user()->eligibleForFreeTrial()) transform group-hover:translate-x-2 duration-100 @endif"></i>
                @endif
            </x-billing-button>
        @else
            <a href="{{ route('register') }}"
               class="inline-block mx-auto lg:mx-0 hover:underline bg-gray-900 text-gray-200 font-bold rounded mt-6 py-4 px-8 shadow-lg">
                {{ __('common.signup') }}
            </a>
        @endauth
    </x-main-hero>
@endsection

@section('scripts')
    @parent
    @auth
        <script src="{{ mix('js/stripe.js') }}"></script>
    @endauth
@endsection
