@extends('layouts.hero')

@section('title', 'Temporarily Disabled')

@section('content')
    <x-main-hero>
        <div class="flex flex-col">
            <h2 class="uppercase tracking-loose w-full">
                Notice
            </h2>
            <h1 class="my-4 text-5xl font-bold leading-tight mb-6">
                Temporarily disabled
            </h1>
        </div>

        <p class="leading-normal text-lg mb-2 pr-10">
            Oryxbot is currently <b>incompatible</b> with the latest Albion Online.
            For this reason, subscriptions have been temporarily disabled.
        </p>
        <p class="leading-normal text-lg mb-2 pr-10">
            We will let everyone know via Discord when we're back up and running!
        </p>

    </x-main-hero>
@endsection
