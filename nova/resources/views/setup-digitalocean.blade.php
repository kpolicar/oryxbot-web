@extends('nova::layout_basic')


@section('title', 'Digital Ocean - Setup - '.\Laravel\Nova\Nova::name())

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
    .tab input + label {
        border-left-width: 1px; /*.border-l*/
    }
    /* Label formatting when open */
    .tab input:checked + label{
        border-left-width: 1px;
        color: var(--90); /*.text-indigo*/
        font-weight: 600;
    }
    /* Label formatting when open */
    .tab input:checked + label{
        border-color: var(--80);
    }
    /* Label formatting when open */
    .tab input + label{
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
    .tab.success input + label {
        border-left-width: 1px;
        color: var(--primary-50); /*.text-indigo*/
        font-weight: 600;
    }
    /* p formatting when open */
    .tab.success input + label{
        border-color: var(--primary-50);
    }
    /* p formatting when open */
    .tab input + label{
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

    .tab.success input:hover + label {
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
        <a href="{{ route('setup.digitalocean', compact('instance')) }}" class="hover:underline text-primary">Digital Ocean</a>
    </div>

    @php($step2Complete = !!data_get($instance, 'server.droplet_id'))
    @php($step1Complete = $step2Complete || session()->get("instance-{$instance->id}.setup.digitalocean.token_validated", false))
    @component('nova::auth.partials.heading')
        {{ __('Setup Digital Ocean!') }}
    @endcomponent
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    <div class="tab w-full overflow-hidden @if($step1Complete) success @endif">
        <input class="absolute opacity-0" id="tab-single-one" type="radio" name="tabs2"@if (!$errors->any()) checked @endif>
        <label class="block p-4 leading-normal cursor-pointer border-60 flex" for="tab-single-one">
            <span class="mr-3">1</span>
            @if($step1Complete)
            <span class="primary-50 relative mr-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     data-vnc-online
                     class="fill-current" style="height: 20px;width: 20px;"
                     viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
            </span>
            @endif
            <span>Sign up on Digital Ocean</span>
        </label>
        <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
            <p class="p-4 pb-1">
                For your safety, Oryxbot software runs on an external server. Due to the low and transparent pricing,
                we have chosen Digital Ocean as our cloud service provider.
            </p>
            <p class="p-4 pt-0">
                To run Oryxbot, you will need to register an account with Digital Ocean.
            </p>

            <div class="p-4 pt-0">
                <a href="{{ route('setup.digitalocean.referral') }}" target="_blank" class="text-center w-1/2 btn btn-default btn-primary hover:bg-primary-dark">
                    {{ __('Sign me up') }}
                </a>
            </div>
        </div>
    </div>
    <div class="tab w-full overflow-hidden @if($step1Complete) success @endif">
        <input class="absolute opacity-0" id="tab-single-two" type="radio" name="tabs2">
        <label class="block p-4 leading-normal cursor-pointer border-60 flex" for="tab-single-two">
            <span class="mr-3">2</span>

            @if($step1Complete)
                <span class="primary-50 relative mr-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     data-vnc-online
                     class="fill-current" style="height: 20px;width: 20px;"
                     viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
            </span>
            @endif

            <span>Add Payment Method</span>
        </label>
        <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
            <p class="p-4 pb-0">
                To use Digital Ocean, you'll need to add a payment method.<br>
                Server costs will run you approximately <strong>$4 per month</strong>.<br>
            </p>
            <p class="m-4 p-4 px-8 bg-primary text-sm rounded flex">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-1/6 mr-2 fill-current"
                     viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                <span class="ml-2">
                If you registered through our
                <a href="{{ route('setup.digitalocean.referral') }}" class="no-underline text-90 hover:underline">
                    referral link</a>,
                you will have been given $200 in credit to your Digital Ocean account.
                </span>
            </p>

            <div class="p-4 pt-0">
                <a href="https://cloud.digitalocean.com/account/billing" target="_blank" class="text-center w-1/2 btn btn-default btn-primary hover:bg-primary-dark">
                    {{ __('Manage Billing Settings') }}
                </a>
            </div>
        </div>
    </div>
    <div class="tab w-full overflow-hidden @if($step1Complete) success @endif">
        <input class="absolute opacity-0" id="tab-single-three" type="radio" name="tabs2"@error('digitalocean') checked @endif>
        <label class="block p-4 leading-normal cursor-pointer border-60 flex" for="tab-single-three">
            <span class="mr-3">3</span>

            @if($step1Complete)
                <span class="primary-50 relative mr-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     data-vnc-online
                     class="fill-current" style="height: 20px;width: 20px;"
                     viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
            </span>
            @endif

            <span>Create Personal Access Token</span>
        </label>
        <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
            <p class="p-4">
                Oryxbot uses your personal access token to launch a server on your behalf.
                This server will be configured to run the Oryxbot software.
            </p>
            <p class="p-4 font-bold">
                On this step, Oryxbot will only validate your access token. No resources will be created.
                Store your token in a secure location.
            </p>

            <div class="p-4 pt-0 pb-1">
                <a href="https://cloud.digitalocean.com/account/api/tokens/new" target="_blank" class="text-center w-1/2 btn btn-default btn-primary hover:bg-primary-dark">
                    {{ __('Create New Token') }}
                </a>
            </div>

            <div class="p-4 {{ $errors->has('digitalocean') ? ' has-error' : '' }}">
                <label class="block font-bold mb-2" for="email">{{ __('Token') }}</label>
                <form class="flex" action="{{ route('setup.digitalocean.validate', compact('instance')) }}" method="POST">
                    @csrf
                    <input class="form-control form-input form-input-bordered w-full" id="digitalocean_token" type="text" name="digitalocean_token" required autofocus
                           placeholder="{{ __('Paste your access token here') }}">

                    <button type="submit" class="text-center btn btn-default btn-primary hover:bg-primary-dark ml-1 w-1/3">
                        {{ __('Validate') }}
                    </button>
                </form>
                @error('digitalocean')
                <p class="text-center font-semibold text-danger my-3">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <p class="m-4 p-4 px-8 bg-primary text-sm rounded flex">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="mr-2 fill-current w-1/6"
                     viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                <span class="ml-2 font-bold uppercase">
                        Your personal access token is never stored on Oryxbot servers
                    </span>
            </p>
        </div>
    </div>

    <div class="p-4 pt-0 flex justify-end mt-6 pt-4">
        <a href="{{ route('setup.deploy', compact('instance')) }}" class="text-center px-10 btn btn-default btn-primary hover:bg-primary-dark">
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
