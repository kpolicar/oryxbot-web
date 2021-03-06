<div class="anchor" id="pricing"></div>
<section class="bg-gray-900 py-8 pb-12">

    <div class="container mx-auto px-2 pt-4 pb-2 text-gray-200">

        <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center">{{ __('pricing.heading') }}</h2>
        <div class="w-full mb-4">
            <div class="h-1 mx-auto gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
        </div>
        <p class="w-full my-2 text-xl leading-tight text-center">
            {{ __('pricing.description') }}<br>
            {{ __('pricing.description_thank_you') }}
        </p>

        <div class="flex flex-col sm:flex-row justify-center pt-12 my-12 sm:my-4">

            <div class="flex flex-col w-5/6 lg:w-1/3 xl:w-1/4 mx-auto lg:mx-0 rounded-none lg:rounded-l-lg bg-white mt-4">
                <div class="flex-1 bg-white text-gray-600 rounded-t rounded-b-none overflow-hidden shadow">
                    <div class="w-full p-8 text-3xl font-bold text-center border-b-4 border-gray-500">
                        {{ __('pricing.package_free') }}
                    </div>
                    <ul class="w-full text-center text-sm">
                        <li class="border-b py-4">{{ __('pricing.package_free_duration') }}</li>
                        <li class="border-b py-4">{{ __('pricing.package_feature_routes_default') }}</li>
                    </ul>
                </div>
                <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
                    <div class="w-full pt-6 text-3xl text-gray-600 font-bold text-center leading-none mb-2">
                        €0
                    </div>
                    <div class="flex items-center justify-center">
                        @guest
                            <a href="{{ route('register') }}"
                                class="inline-block mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded mt-6 py-4 px-8 shadow-lg">
                                {{ __('common.signup') }}
                            </a>
                        @endguest
                        @auth
                            <x-billing-button trial class="inline-block mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded mt-6 py-4 px-8 shadow-lg" />
                        @endauth
                    </div>
                    <a href="{{ route('free-trial') }}" class="flex items-end justify-center text-gray-600 h-6 text-xs hover:underline">
                        Read more
                    </a>
                </div>
            </div>
            <div class="flex flex-col w-5/6 lg:w-1/3 xl:w-1/4 mx-auto lg:mx-0 rounded-lg bg-white mt-4 sm:-mt-6 shadow-lg z-10 text-gray-800">
                <div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow">
                    <div class="w-full p-8 text-3xl font-bold text-center">{{ __('pricing.package_subscription') }}</div>
                    <div class="h-1 w-full gradient my-0 py-0 rounded-t"></div>
                    <ul class="w-full text-center text-sm">
                        <li class="border-b py-4">{{ __('pricing.package_subscription_duration') }}</li>
                        <li class="border-b py-4">{{ __('pricing.package_feature_routes_default') }}</li>
                        <li class="border-b py-4"><span class="line-through">{{ __('pricing.package_feature_routes_custom') }}</span>*</li>
                        <li class="border-b py-4"><span class="line-through">{{ __('pricing.package_feature_notifications') }}</span>*</li>
                    </ul>
                </div>
                <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
                    <div class="w-full pt-6 text-3xl font-bold text-center leading-none mb-2">
                        €{{ config('pricing.trade_mission_bot.price')/100 }} <small class="text-sm">/ {{ __('common.month') }}</small>
                    </div>

                    @php($promoCode = config('pricing.trade_mission_bot.promo'))
                    @php($shouldDisplayPromo = $promoCode && !($user = Auth::user()) || !$user->subscribedToTradeMissionBot())

                    <div class="flex items-center justify-center">
                        @auth
                            <x-billing-button class="inline-block mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded {{ $shouldDisplayPromo ? 'mt-6' : 'my-6' }} py-4 px-8 shadow-lg" />
                        @else
                            <a href="{{ route('register') }}"
                               class="inline-block mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded {{ $shouldDisplayPromo ? 'mt-6' : 'my-6' }} py-4 px-8 shadow-lg">
                                {{ __('common.signup') }}
                            </a>
                        @endauth
                    </div>
                    @if ($shouldDisplayPromo)
                    <p class="flex items-end justify-center text-gray-600 h-6 text-xs">
                        <span>€{!! __('common.discount_promo', ['amount' => 5, 'code' => $promoCode]) !!}</span>
                    </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <p class="w-full my-2 leading-tight text-center text-gray-200">* {{ __('pricing.package_feature_in_development') }}</p>


</section>
