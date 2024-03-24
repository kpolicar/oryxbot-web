<nav id="header" class="fixed w-full z-30 top-0 text-gray-900 flex justify-between">

    <div class="" style="flex-grow: 1;"></div>
    <div class="container flex flex-wrap flex-columns xl:items-center justify-between mt-0 py-2">

        <div class="flex justify-between lg:w-auto w-full">
            <div class="pl-4 flex items-center">
                <a class="toggleColour text-gray-900 no-underline hover:no-underline font-bold text-2xl lg:text-4xl"  href="{{ route('home') }}" aria-label="{{ __('common.home') }}">
                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" class="mb-1 h-10 fill-current inline"
                         viewBox="0 0 700.000000 654.000000"
                         preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,654.000000) scale(0.100000,-0.100000)" stroke="none">
                            <path d="M2380 6331 c-41 -5 -95 -12 -120 -16 l-45 -8 95 -24 c589 -148 1015
-364 1300 -659 105 -108 156 -173 225 -288 39 -64 54 -80 108 -110 306 -172
452 -498 417 -931 -14 -168 -42 -305 -62 -305 -8 0 -9 26 -4 88 14 183 -27
461 -94 641 -55 149 -145 292 -243 384 -42 39 -57 45 -57 24 0 -32 -228 -616
-281 -718 -62 -119 -155 -213 -279 -281 -73 -40 -165 -74 -324 -118 -405 -113
-699 -281 -978 -556 -179 -177 -306 -352 -413 -569 -146 -297 -205 -554 -205
-892 0 -114 -4 -183 -10 -183 -13 0 -50 60 -118 193 -328 640 -389 1430 -166
2130 47 148 134 343 217 490 358 630 974 1070 1632 1166 l120 18 -104 52
c-174 88 -800 212 -561 213 -56 1 -366 -153 -551 -274 -673 -440 -1138 -1134
-1293 -1933 -42 -214 -50 -316 -50 -595 0 -301 12 -423 64 -672 123 -583 393
-1095 799 -1510 393 -404 806 -653 1311 -792 463 -128 997 -138 1465 -27 1091
259 1937 1109 2214 2226 64 256 91 488 91 775 0 495 -101 933 -314 1360 -161
322 -343 569 -608 826 -396 381 -893 646 -1428 759 -103 21 -414 65 -459 65
-9 0 29 -24 84 -53 109 -58 158 -89 280 -181 89 -67 271 -241 325 -310 25 -32
51 -51 90 -67 458 -188 856 -514 1134 -928 448 -668 560 -1555 296 -2351 -178
-539 -492 -977 -932 -1301 -102 -75 -271 -179 -291 -179 -7 0 -42 26 -77 59
-98 88 -200 150 -465 283 -389 196 -515 270 -598 351 -68 67 -87 108 -87 189
0 50 7 77 31 128 61 130 149 191 289 198 213 11 397 -89 660 -357 126 -128
156 -153 226 -189 106 -54 178 -72 289 -72 200 0 355 81 458 238 54 83 74 137
86 227 23 185 -40 347 -194 800 -213 212 -300 341 -345 511 -24 94 -27 253 -6
335 67 257 58 445 -31 627 -25 50 -49 92 -54 92 -5 0 -16 -15 -25 -32 -24 -46
-74 -118 -82 -118 -4 0 -7 125 -7 278 0 222 -4 299 -18 385 -166 986 -796
1627 -1742 1772 -115 18 -474 27 -585 16z m2065 -2991 c22 -16 60 -49 84 -75
l43 -47 -6 -81 c-6 -71 -4 -87 14 -122 11 -21 20 -41 20 -44 0 -2 -25 -1 -55
2 -97 10 -176 88 -214 211 -20 67 -37 209 -26 226 7 11 58 -15 140 -70z"></path>
                        </g>
                    </svg> ORYXBOT
                    <span style="bottom: 5px" class="absolute inline-block bg-green-800 rounded-full px-3 py-1 text-sm font-semibold text-white mr-2">NEW</span>
                </a>
            </div>

            <div class="block lg:hidden pr-4">
                <button id="nav-toggle" class="flex items-center p-1 text-gray-900 hover:text-gray-800 border-none">
                    <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>{{ __('common.menu') }}</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                </button>
            </div>
        </div>

        <div class="flex-grow lg:flex justify-end lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 bg-white lg:bg-transparent lg:text-gray-900 text-gray-900 p-4 lg:p-0 z-20" id="nav-content">
            <ul class="list-reset lg:flex justify-end items-center">
                <li class="xl:mr-3 m-1">
                    <a class="inline-block no-underline hover:text-gray-800 hover:text-underline xl:py-2 xl:px-4 p-2" href="{{ route('release', ['version' => 'latest']) }}">{{ __('common.whats_new') }}</a>
                </li>
                <li class="xl:mr-3 m-1">
                    <a class="inline-block no-underline hover:text-gray-800 hover:text-underline xl:py-2 xl:px-4 p-2" target="_blank" href="{{ route('discord') }}">Discord</a>
                </li>
                <li class="xl:mr-3 m-1">
                    <a class="inline-block no-underline hover:text-gray-800 hover:text-underline xl:py-2 xl:px-4 p-2"
                       href="#pricing">Pricing</a>
                </li>
                @if (Auth::check() && Auth::user()->subscribedToTradeMissionBot())
                    <li class="xl:mr-3 m-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="outline: none" class="inline-block no-underline hover:text-gray-700 hover:text-underline xl:py-2 xl:px-4 p-2">{{ __('common.logout') }}</button>
                        </form>
                    </li>
                @endauth
                @if (Auth::check() && !Auth::user()->subscribedToTradeMissionBot())
                <li class="xl:mr-3 m-1">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-block no-underline hover:text-gray-800 hover:text-underline xl:py-2 xl:px-4 p-2">
                            Sign out
                        </button>
                    </form>
                </li>
                @endif
            </ul>
            <div class="lg:ml-24 ml-0 py-4">
                <a id="navAction"
                   @if (!Auth::check() || Auth::user()->subscribedToTradeMissionBot())
                   href="{{ Auth::check() ? Request::getScheme().'://'.config('nova.domain') : route('nova.login') }}"
                   @else
                   href="{{ route('subscribe') }}"
                   @endif
                   rel="nofollow"
                   class="cursor-pointer mx-auto lg:mx-0 lg:mx-2 bg-black text-white font-bold rounded mt-4 lg:mt-0 py-2 px-4 pr-6 rounded-full shadow opacity-75 hover:opacity-100 hover:bg-gray-900 transition duration-300 group">
                    @auth
                        @if (Auth::user()->subscribedToTradeMissionBot())
                            {{ __('common.dashboard') }}
                        @else
                            {{ __('common.purchase') }}
                        @endif
                    @endauth
                    @guest
                        {{ __('common.login') }}
                    @endguest
                    <i class="fas fa-angle-right text-lg ml-2 -mr-2 transform group-hover:translate-x-2 duration-100"></i>
                </a>
            </div>
        </div>
    </div>
    <div style="flex: 1" class="text-right">
    </div>
</nav>
