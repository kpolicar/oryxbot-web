@extends('nova::layout_basic')


@section('title', 'Reset Instance - Setup - '.\Laravel\Nova\Nova::name())

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
        <a href="{{ route('setup.reset', compact('instance')) }}" class="hover:underline text-primary">Reset Instance</a>
    </div>
    @php($step2Complete = !!data_get($instance, 'server.droplet_id'))

    @component('nova::auth.partials.heading')
        {{ __('Reset this Instance!') }}
    @endcomponent
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

            <p class="p-4 pb-2 mb-8">
                Oryxbot will delete any existing deployments associated with this instance from your
                Digital Ocean.
            </p>

            <div class="p-4 pt-0 {{ $errors->has('digitalocean_token') ? ' has-error' : '' }}">
                <form action="{{ route('setup.reset.submit', compact('instance')) }}" method="POST">
                    @csrf

                    <div class="text-90">
                        <input type="checkbox" id="terms" name="terms">
                        <label for="terms" class="border-none">
                            I understand that by submitting this form I am authorizing Oryxbot to <strong>delete</strong>
                            resources on my Digital Ocean account.
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

                        <button type="submit" class="text-center btn btn-default btn-primary hover:bg-primary-dark ml-1 w-2/3">
                            {{ __('Delete resources') }}
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

<div class="mx-auto py-8 max-w-sm text-center text-90">
    <div class="text-primary flex items-center justify-center mx-auto" style="width: 200px">
        @include('nova::partials.digitalocean_logo')
    </div>
</div>


@endsection
