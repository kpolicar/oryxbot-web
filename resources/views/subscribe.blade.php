@extends('layouts.hero')

@section('title', __('titles.subscribe'))

@section('scripts')
    @parent
    <script src="{{ mix('js/stripe.js') }}"></script>
@endsection

@section('content')
    <x-main-hero>
        <div class="flex flex-col">
            <h1 class="uppercase tracking-loose w-full">
                {{ __('subscribe.subheading') }}
            </h1>
            <h2 class="my-4 text-5xl font-bold leading-tight mb-6">
                {{ __('subscribe.heading') }}
            </h2>
        </div>

        <p class="leading-normal text-lg mb-2 pr-10">
            {{ __('subscribe.description')  }}
        </p>

        <div class="flex">

            <a data-checkout="{{ route('create-checkout-session') }}"
               class="w-full text-center hover:underline bg-gray-900 text-gray-200 font-bold my-6 py-4 mr-2 shadow-lg rounded cursor-pointer">
                <i class="far fa-credit-card text-4xl mb-1 text-gray-400"></i><br>
                {{ __('subscribe.method_card') }}
            </a>

            <form method="POST" action="{{ route('subscribe.coinbase.checkout') }}"
                  class="group w-full text-center bg-gray-900 my-6 ml-2 shadow-lg rounded relative cursor-pointer">
                @csrf
                <button class="group-hover:underline text-gray-200 font-bold h-full w-full py-4">
                    <i class="fab fa-bitcoin text-4xl mb-1 text-gray-400"></i><br>
                    {{ __('subscribe.method_crypto') }}
                    @if ($cryptoPromo)
                        <aside class="absolute top-0 left-0 -ml-2 uppercase shadow-lg">
                        <span class="p-2 bg-green-400 rounded pr-4">
                            {{ __('subscribe.description_promotion_title') }}
                        </span>
                        </aside>
                        <aside class="absolute bottom-0 right-0 pt-3 -mr-2 shadow-lg">
                        <span class="p-2 bg-gray-200 rounded pr-4 text-gray-800">
                            {{ __('subscribe.method_crypto_badge') }}
                        </span>
                        </aside>
                    @endif
                </button>
            </form>
        </div>

        @if ($cryptoPromo)
            <p class="leading-normal text-lg mb-2 pr-10">
                {{ __('subscribe.description_promotion')  }}
            </p>
            <p class="leading-normal text-lg mb-2 pr-10">
                {!! __('subscribe.description_promotion_expires') !!}
            </p>
        @endif
    </x-main-hero>
@endsection
