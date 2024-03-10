@extends('nova::layout_basic')


@section('title', 'Deploy Server - Setup - '.\Laravel\Nova\Nova::name())

@section('content')

@include('nova::auth.partials.header')

<style>
    /* Tab content - closed */
    .tab-content {
        max-height: 0;
        -webkit-transition: max-height .35s;
        -o-transition: max-height .35s;
        transition: max-height .35s;
    }
    /* :checked - resize to full height */
    .tab input:checked ~ .tab-content {
        max-height: 100vh;
        border-color: var(--80);
    }
    /* Label formatting when open */
    .tab > input + label {
        border-left-width: 1px; /*.border-l*/
    }
    /* Label formatting when open */
    .tab > input:checked + label{
        border-left-width: 1px;
        color: var(--90); /*.text-indigo*/
        font-weight: 600;
    }
    /* Label formatting when open */
    .tab > input:checked + label{
        border-color: var(--80);
    }
    /* Label formatting when open */
    .tab > input + label{
        color: var(--60); /*.text-indigo*/
    }
    /* Icon */
    .tab label::after {
        float:right;
        right: 0;
        top: 0;
        display: block;
        width: 1.5em;
        height: 1.5em;
        line-height: 1.5;
        font-size: 1.25rem;
        text-align: center;
        -webkit-transition: all .35s;
        -o-transition: all .35s;
        transition: all .35s;
    }
    .bookmarks a {
        text-decoration: none;
    }
    /* p formatting when open */
    .tab.success > input + label {
        border-left-width: 1px;
        color: var(--primary-50); /*.text-indigo*/
        font-weight: 600;
    }
    /* p formatting when open */
    .tab.success > input + label{
        border-color: var(--primary-50);
    }
    /* p formatting when open */
    .tab > input + label{
        color: var(--60); /*.text-indigo*/
    }
    /* Icon */
    .tab > label::after {
        float:right;
        right: 0;
        top: 0;
        display: block;
        width: 1.5em;
        height: 1.5em;
        line-height: 1.5;
        font-size: 1.25rem;
        text-align: center;
        -webkit-transition: all .35s;
        -o-transition: all .35s;
        transition: all .35s;
    }

    .tab.success > input:hover + label {
        border-left-width: 1px;
        color: var(--primary-70); /*.text-indigo*/
        font-weight: 600;
    }
</style>

<div
    class="bg-white shadow rounded-lg p-8 mx-auto"
    style="max-width: 35rem"
>
    <div class="mb-4 bookmarks">
        <a href="{{ route('setup', compact('instance')) }}" class="hover:underline text-primary">Setup</a>
        /
        <a href="{{ route('setup.deploy', compact('instance')) }}" class="hover:underline text-primary">Deploy Server</a>
    </div>
    @php($step2Complete = !!data_get($instance, 'server.droplet_id'))

    @component('nova::auth.partials.heading')
        {{ __('Deploy Oryxbot Server!') }}
    @endcomponent
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

    <div class="tab w-full overflow-hidden @if($step2Complete) success @endif">
        <input class="absolute opacity-0" id="tab-single-three" type="radio" name="tabs2" checked>
        <label class="block p-4 leading-normal cursor-pointer border-60 flex" for="tab-single-three">
            <span class="mr-3">1</span>

            @if($step2Complete)
                <span class="primary-50 relative mr-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     data-vnc-online
                     class="fill-current" style="height: 20px;width: 20px;"
                     viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
            </span>
            @endif

            Create the droplet
        </label>
        <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
            <p class="p-4 pb-2">
                Oryxbot will be interacting with the server you deploy using SSH.
                To grant us access, we'll be adding our public key to your Digital Ocean account.
            </p>
            <p class="p-4 pt-2">
                Please configure the droplet with the options below.
            </p>


            <div class="p-4 pt-0 {{ $errors->has('digitalocean_token') ? ' has-error' : '' }}">
                <form action="{{ route('setup.digitalocean.deploy', compact('instance')) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="region" class="text-sm" style="color: var(--70)">
                            Select the city closest to you
                        </label>
                        <select
                            id="region"
                            name="region"
                            class="block w-full form-control-sm form-select"
                        >
                            <option value="nyc" selected>New York</option>
                            <option value="sfo">San Francisco</option>
                            <option value="ams">Amsterdam</option>
                            <option value="sgp">Singapore</option>
                            <option value="lon">London</option>
                            <option value="fra">Frankfurt</option>
                            <option value="tor">Toronto</option>
                            <option value="blr">Bangalore</option>
                            <option value="syd">Syndney</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="size" class="text-sm" style="color: var(--70)">
                            Select the droplet size (LOCKED)
                        </label>
                        <select
                            id="size"
                            name="size"
                            class="block w-full form-control-sm form-select"
                            disabled
                        >
                            <option value="nyc" selected>$4 per month | 512MB, 1 CPU, 10GB SSD, 500GB Transfer</option>
                        </select>
                    </div>

                    <div class="text-90">
                        <input type="checkbox" id="terms" name="terms">
                        <label for="terms" class="border-none">
                            I understand that by submitting this form I am authorizing Oryxbot to create
                            resources on my Digital Ocean account which will incur monthly costs.
                        </label>
                    </div>
                    @error('terms')
                    <p class="text-center font-semibold text-danger my-3">
                        {{ $message }}
                    </p>
                    @enderror

                    <div class="flex mt-8">
                        <input class="form-control form-input form-input-bordered w-full" id="digitalocean_token" type="text" name="digitalocean_token" required autofocus
                               placeholder="{{ __('Paste your access token here') }}">

                        <button type="submit" class="text-center btn btn-default btn-primary hover:bg-primary-dark ml-1 w-1/2">
                            {{ __('Create droplet') }}
                        </button>
                    </div>
                </form>
                @error('digitalocean')
                <p class="text-center font-semibold text-danger my-3">
                    {{ $message }}
                </p>
                @enderror
            </div>
        </div>
    </div>

    <div class="p-4 pt-0 flex justify-between mt-6 pt-4">
        <a href="{{ route('setup.digitalocean', compact('instance')) }}" class="text-center px-10 btn btn-default btn-primary hover:bg-primary-dark">
            {{ __('Previous step') }}
        </a>
        <a href="{{ route('setup.vncserver.tightvnc', compact('instance')) }}" class="text-center px-10 btn btn-default btn-primary hover:bg-primary-dark">
            {{ __('Next step') }}
        </a>
    </div>
</div>

<div class="mx-auto py-8 max-w-sm text-center text-90">
    <div class="text-primary flex items-center justify-center mx-auto" style="width: 200px">
        @include('nova::partials.digitalocean_logo')
    </div>
</div>


@endsection
