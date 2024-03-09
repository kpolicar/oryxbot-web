@extends('nova::layout_basic')


@section('title', 'VPN - Setup - '.\Laravel\Nova\Nova::name())

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
        .tab {
            text-decoration: none;
        }
        /* :hover - resize to full height */
        .tab:hover ~ .tab-content {
            max-height: 100vh;
            border-color: var(--80);
        }
        .item.tab {
            text-decoration:none;
        }
        /* p formatting when open */
        .tab .item {
            border-left-width: 1px; /*.border-l*/
        }
        /* p formatting when open */
        .tab:hover .item{
            border-left-width: 1px;
            color: var(--90); /*.text-indigo*/
            font-weight: 600;
        }
        /* p formatting when open */
        .tab:hover .item{
            border-color: var(--80);
        }

        /* p formatting when open */
        .tab.success .item{
            border-left-width: 1px;
            color: var(--primary-50); /*.text-indigo*/
            font-weight: 600;
        }
        /* p formatting when open */
        .tab.success .item{
            border-color: var(--primary-50);
        }
        /* p formatting when open */
        .tab .item{
            color: var(--60); /*.text-indigo*/
        }
        /* Icon */
        .tab .item::after {
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

        ul li {
            border-bottom: 1px solid var(--primary-30);
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 0 5px;
        }
        ul li:last-child {
            border: none;
        }
    </style>

    <div
        class="bg-white shadow rounded-lg p-8 mx-auto"
        style="max-width: 35rem"
    >
        <div class="mb-4 bookmarks">
            <a href="{{ route('setup') }}" class="hover:underline text-primary">Setup</a>
            /
            <a href="{{ route('setup.digitalocean') }}" class="hover:underline text-primary">VPN</a>
        </div>

        @component('nova::auth.partials.heading')
            {{ __('Setup VPN Connection!') }}
        @endcomponent
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <p class="p-4 pb-1">
            You'll now configure a VPN connection to the Oryxbot server. This will allow Oryxbot to parse
            Albion's network packets as well as establish a connection to your VNC server.
        </p>

        <div class="tab w-full overflow-hidden">
            <input class="absolute opacity-0" id="tab-single-one" type="radio" name="tabs2" checked>
            <label class="block p-4 leading-normal cursor-pointer border-60" for="tab-single-one">
                <span class="mr-3">1</span>Add Windows built-in VPN connection
            </label>
            <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
                <p class="p-4 pb-0">
                    Follow the instructions to
                    <a
                        target="_blank"
                        href="https://support.microsoft.com/en-us/windows/connect-to-a-vpn-in-windows-3d29aeb1-f497-f6b7-7633-115722c1009c">
                        setup a VPN connection in Windows</a>.
                    Use the following settings to configure the connection:
                </p>
                <div class="flex m-4 p-4 px-8 bg-primary text-sm rounded">
                    <ul style="list-style: none; line-height: 2rem" class="p-0 w-full">
                        <li style="border-bottom: 1px solid var(--primary-30)">
                            VPN Provider:
                        </li>
                        <li>
                            Connection name:
                        </li>
                        <li>
                            Server name or address:
                        </li>
                        <li>
                            VPN type:
                        </li>
                        <li>
                            Type of sign-in info:
                        </li>
                        <li>
                            User name:
                        </li>
                        <li>
                            Password:
                        </li>
                    </ul>
                    <ul style="list-style: none; text-align: right; line-height: 2rem" class="font-bold p-0 w-full">
                        <li style="border-bottom: 1px solid var(--primary-30)">
                            Windows Built-in
                        </li>
                        <li>
                            Oryxbot
                        </li>
                        <li>
                            {{ Auth::user()->subscription()->instances->first()->server->ip_address }}
                        </li>
                        <li>
                            Automatic
                        </li>
                        <li>
                            User name and password
                        </li>
                        <li>
                            {{ Auth::user()->subscription()->instances->first()->server->vpn_username }}
                        </li>
                        <li>
                            {{ Auth::user()->subscription()->instances->first()->server->vpn_password }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab w-full overflow-hidden">
            <input class="absolute opacity-0" id="tab-single-two" type="radio" name="tabs2">
            <label class="block p-4 leading-normal cursor-pointer border-60" for="tab-single-two">
                <span class="mr-3">2</span>Configure TightVNC Server
            </label>
            <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
                <p class="p-4 pb-0">
                    After starting the VNC service, you may find the TightVNC options menu in the system tray.
                    The following configuration options need to be assigned.
                </p>
                <span class="flex justify-center my-4">
                    <img src="{{ asset('images/install/vpn_settings.png') }}" class="w-3/4" alt="">
                </span>
            </div>
        </div>
        <div class="tab w-full overflow-hidden">
            <input class="absolute opacity-0" id="tab-single-three" type="radio" name="tabs2"@error('digitalocean') checked @endif>
            <label class="block p-4 leading-normal cursor-pointer border-60" for="tab-single-three">
                <span class="mr-3">3</span>Verify the connection
            </label>
            <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
                <p class="p-4">
                    blabla
                </p>
            </div>
        </div>
    </div>

    <div class="mx-auto py-8 max-w-sm text-center text-90">
        <div class="text-primary flex items-center justify-center mx-auto" style="width: 200px">
            @include('nova::partials.digitalocean_logo')
        </div>
    </div>


@endsection
