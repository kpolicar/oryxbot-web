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
            <a href="{{ route('setup', compact('instance')) }}" class="hover:underline text-primary">Setup</a>
            /
            <a href="{{ route('setup.digitalocean', compact('instance')) }}" class="hover:underline text-primary">VPN</a>
        </div>

        @component('nova::auth.partials.heading')
            {{ __('Setup VPN Connection!') }}
        @endcomponent
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <p class="p-4 pb-1">
            You'll now configure a VPN connection to the Oryxbot server. This will allow Oryxbot to collect information
            from your Albion client and take control of your mouse and keyboard.
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
                <div class="m-4 p-4 px-8 bg-primary rounded">
                    <div class="flex justify-center">
                        <p class="font-bold mb-2 text-center px-4 pb-2">Add a VPN connection</p>
                    </div>

                    <div class="flex text-sm">
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
                                {{ $instance->name }}
                            </li>
                            <li>
                                {{ $instance->server->ip_address }}
                            </li>
                            <li>
                                Automatic
                            </li>
                            <li>
                                User name and password
                            </li>
                            <li>
                                {{ $instance->server->vpn_username }}
                            </li>
                            <li>
                                {{ $instance->server->vpn_password }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab w-full overflow-hidden">
            <input class="absolute opacity-0" id="tab-single-two" type="radio" name="tabs2">
            <label class="block p-4 leading-normal cursor-pointer border-60" for="tab-single-two">
                <span class="mr-3">2</span>Verify the connection
            </label>

            <div class="tab-content overflow-hidden border-l bg-gray-100 border-60 leading-normal">
                <p class="p-4">
                    Your browser will now attempt to discover whether you are connected to the VPN.
                </p>

                <div class="flex justify-center items-center">
                    <script>var vpn_status = 'Offline';</script>
                    <span class="mx-2">VPN status:</span>
                    <svg
                        data-vpn-offline
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="ban"
                        class="w-8 text-danger mx-2"
                        style="overflow: visible"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.034 8 8 119.033 8 256s111.034 248 248 248 248-111.034 248-248S392.967 8 256 8zm130.108 117.892c65.448 65.448 70 165.481 20.677 235.637L150.47 105.216c70.204-49.356 170.226-44.735 235.638 20.676zM125.892 386.108c-65.448-65.448-70-165.481-20.677-235.637L361.53 406.784c-70.203 49.356-170.226 44.736-235.638-20.676z"></path>
                    </svg>
                    <svg
                        data-vpn-online
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="far"
                        data-icon="check-circle"
                        class="w-8 text-success mx-2 my-4"
                        style="overflow: visible; display: none;"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512">
                        <path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"></path>
                    </svg>
                </div>

                <div
                    data-vpn-offline>
                    <p class="m-4 p-4 px-8 bg-primary text-sm rounded flex">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="mr-2 fill-current w-1/6"
                             viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                        <span class="ml-2">
                    This status is unrealiable and might not successfully discover the server
                    depending on your browser and system settings.
                </span>

                    </p>
                </div>

                <script>
                    function timeout() {
                        setTimeout( () => {
                            refreshVpnServiceStatus();
                            timeout();
                        }, 5000);
                    }
                    let refreshVpnServiceStatus =
                        () => fetch("http://127.0.0.1:5558", { mode: 'no-cors'})
                            .then(r => {
                                if (vpn_status !== 'Online') {
                                    console.log('Successfully pinged VPN discoverability server');
                                }
                                vpn_status = 'Online'
                                document.querySelectorAll('[data-vpn-online]').forEach(el => el.style.display = 'block');
                                document.querySelectorAll('[data-vpn-offline]').forEach(el => el.style.display = 'none');
                            })
                            .catch(reason => {
                                vpn_status = 'Unknown';
                                console.log('Failed to ping VPN discoverability server');
                                document.querySelectorAll('[data-vpn-online]').forEach(el => el.style.display = 'none');
                                document.querySelectorAll('[data-vpn-offline]').forEach(el => el.style.display = 'block');
                            });
                    timeout();
                    refreshVpnServiceStatus();
                </script>
        </div>
        </div>
    </div>

    <div class="mx-auto py-8 max-w-sm text-center text-90">
        <div class="text-primary flex items-center justify-center mx-auto" style="width: 200px">
            @include('nova::partials.digitalocean_logo')
        </div>
    </div>


@endsection
