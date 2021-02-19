@extends('layouts.hero')

@section('title', 'Christmas Gift')


@section('content')
    <x-main-hero>
        <div style="background-image: url('{{ asset('images/gift.gif') }}'); background-size: cover; background-repeat: no-repeat; background-position: center center;">

            <h2 class="uppercase tracking-loose w-full">It's Christmas time!</h2>
            <div class="flex justify-center lg:justify-between">
                <h1 class="my-4 text-3xl font-bold leading-tight">Claim your Oryxbot gift!</h1>
            </div>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto bg-white opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <form class="w-full" method="POST" action="{{ route('gifts.christmas') }}">
                @csrf
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">

                        <p>
                            Welcome friends!<br>
                            It's that time of year again. The time to relax and spend time with your loved ones.
                        </p>
                        <figure class="italic my-2">
                            <blockquote>
                                Winter, a lingering season, is a time to gather golden moments, embark upon a sentimental journey, and enjoy every idle hour.
                            </blockquote>
                            <figcaption class="text-xs">- John Boswell</figcaption>
                        </figure>

                        <p class="mt-4">
                            Don't waste your time maging during Christmas. Let Oryxbot take a load off and have some fun.
                        </p>

                        <label class="inline-flex mt-8">
                            <input type="checkbox" name="confirmation" class="mt-1 form-checkbox h-5 w-5 text-gray-700">
                            <span class="ml-2 text-white">
                                I solemnly swear I have and will continue to be a good boy/girl and will continue to bring joy to my friends & family during and after the holiday season
                            </span>
                        </label>
                        @error('confirmation')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded py-4 px-8 shadow-lg"
                        type="submit">
                    Accept Subscription Gift
                </button>
            </form>
        </div>
    </x-main-hero>
@endsection


