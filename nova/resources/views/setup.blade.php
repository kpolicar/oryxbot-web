@extends('nova::layout_basic')


@section('title', 'Setup - '.\Laravel\Nova\Nova::name())

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
</style>

<div
    class="bg-white shadow rounded-lg p-8 mx-auto"
    style="max-width: 35rem"
>
    @component('nova::auth.partials.heading')
        {{ __('Get Started!') }}
    @endcomponent

    <p class="px-4 pb-8">
        Before you can begin botting, you need to complete this setup process.
    </p>

    <div class="tab w-full overflow-hidden">
        <input class="absolute opacity-0" id="tab-single-one" type="radio" name="tabs2" checked>
        <label class="block p-4 leading-normal cursor-pointer border-60" for="tab-single-one">
            <span class="mr-3">1</span>Sign up on Digital Ocean
        </label>
        <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
            <p class="p-4 pb-1">
                For your safety, Oryxbot runs on an external server. Due to the low price and ease of use,
                we have chosen Digital Ocean as our cloud service provider.
            </p>
            <p class="p-4 pt-0">
                To run Oryxbot, you will need to register an account with Digital Ocean.
            </p>

            <div class="p-4 pt-0">
                <a href="{{ route('setup.digitalocean') }}" target="_blank" class="text-center w-1/2 btn btn-default btn-primary hover:bg-primary-dark">
                    {{ __('Sign me up') }}
                </a>
            </div>
        </div>
    </div>
    <div class="tab w-full overflow-hidden">
        <input class="absolute opacity-0" id="tab-single-two" type="radio" name="tabs2">
        <label class="block p-4 leading-normal cursor-pointer border-60" for="tab-single-two">
            <span class="mr-3">2</span>Add Payment Method
        </label>
        <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
            <p class="p-4 pb-0">
                To use Digital Ocean you'll need to add a payment method.<br>
                Server costs will run you approximately <strong>$5 per month</strong>.<br>
            </p>
            <p class="p-4 text-80 italic">
                If you registered through our
                <a href="{{ route('setup.digitalocean') }}" class="no-underline text-primary hover:primary-dark hover:underline">
                    referral link</a>,
                you will have been given $100 in credit to your Digital Ocean account.
            </p>

            <div class="p-4 pt-0">
                <a href="https://cloud.digitalocean.com/account/billing" target="_blank" class="text-center w-1/2 btn btn-default btn-primary hover:bg-primary-dark">
                    {{ __('Manage Billing Settings') }}
                </a>
            </div>
        </div>
    </div>
    <div class="tab w-full overflow-hidden">
        <input class="absolute opacity-0" id="tab-single-three" type="radio" name="tabs2">
        <label class="block p-4 leading-normal cursor-pointer border-60" for="tab-single-three">
            <span class="mr-3">3</span>Create Personal Access Token
        </label>
        <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
            <p class="p-4">
                Oryxbot will use your personal access token to launch a server on your behalf
                running the Oryxbot software. Once up and running, you will be able to connect
                to your server and begin running trade missions.
            </p>

            <div class="p-4 mb-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="block font-bold mb-2" for="email">{{ __('Token') }}</label>
                <div class="flex">
                    <input class="form-control form-input form-input-bordered w-full" id="digitalocean_token" type="text" name="digitalocean_token" value="{{ old('email') }}" required autofocus
                           placeholder="{{ __('Paste your token here') }}">

                    <a href="https://cloud.digitalocean.com/account/billing" target="_blank" class="text-center btn btn-default btn-primary hover:bg-primary-dark ml-1">
                        {{ __('Save') }}
                    </a>
                </div>
            </div>
            <div class="p-4 pt-0 pb-1">
                <a href="https://cloud.digitalocean.com/account/api/tokens/new" target="_blank" class="text-center w-1/2 btn btn-default btn-primary hover:bg-primary-dark">
                    {{ __('Create New Token') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="mx-auto py-8 max-w-sm text-center text-90">
    <div class="text-primary flex items-center justify-center mx-auto" style="width: 200px">
        @include('nova::partials.digitalocean_logo')
    </div>
</div>


@endsection
