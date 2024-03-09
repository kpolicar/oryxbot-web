@extends('nova::layout_basic')


@section('title', 'Setup - '.\Laravel\Nova\Nova::name())

@section('content')

@include('nova::auth.partials.header')


<style>
    /* :hover - resize to full height */
    .tab:hover ~ .tab-content {
        max-height: 100vh;
        border-color: var(--80);
    }
    a.tab {
        text-decoration:none;
    }
    /* p formatting when open */
    .tab p {
        border-left-width: 1px; /*.border-l*/
    }
    /* p formatting when open */
    .tab:hover p{
        border-left-width: 1px;
        color: var(--90); /*.text-indigo*/
        font-weight: 600;
    }
    /* p formatting when open */
    .tab:hover p{
        border-color: var(--80);
    }

    /* p formatting when open */
    .tab.success p{
        border-left-width: 1px;
        color: var(--primary-50); /*.text-indigo*/
        font-weight: 600;
    }
    /* p formatting when open */
    .tab.success p{
        border-color: var(--primary-50);
    }
    /* p formatting when open */
    .tab p{
        color: var(--60); /*.text-indigo*/
    }
    /* Icon */
    .tab p::after {
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
    <script>var vnc_status = 'Offline';</script>

    @component('nova::auth.partials.heading')
        {{ __('Get Started!') }}
    @endcomponent

    <p class="px-4 pb-8">
        Oryxbot uses an unconventional method of bypassing anticheat.
    </p>
    <p class="px-4 pb-8">
        Before you begin botting, you must complete this setup process.
    </p>

    @php($step1Complete = session()->get('setup.digitalocean.token_validated', false))
    <a href="{{ route('setup.digitalocean')  }}" class="tab w-full overflow-hidden @if($step1Complete) success @endif">
        <p class="block p-4 leading-normal cursor-pointer border-60 flex" for="tab-single-one">
            <span class="mr-3">1</span>
            @if($step1Complete)
                <span class="primary-50 relative mr-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="fill-current" style="height: 20px;width: 20px;"
                     viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
            </span>
            @endif
            <span>Setup your Digital Ocean</span>
        </p>
    </a>

    @php($step2Complete = Auth::user()->subscription()->instances->first()->server->droplet_id)
    <a href="{{ route('setup.deploy') }}" class="tab w-full overflow-hidden @if($step2Complete) success @endif">
        <p class="block p-4 leading-normal cursor-pointer border-60 flex" for="tab-single-two">
            <span class="mr-3">2</span>
            @if($step2Complete)
                <span class="primary-50 relative mr-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="fill-current" style="height: 20px;width: 20px;"
                     viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
            </span>
            @endif
            <span>Deploy an Oryxbot Server</span>
        </p>
    </a>
    <a href="{{ route('setup.vncserver.tightvnc') }}" class="tab w-full overflow-hidden" data-online-success>
        <p class="block p-4 leading-normal cursor-pointer border-60 flex" for="tab-single-three">
            <span class="mr-3">3</span>
            <span class="primary-50 relative mr-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     data-vnc-online
                     class="fill-current" style="height: 20px;width: 20px;display:none"
                     viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
            </span>
            <span>
            Setup TightVNC server
            </span>
        </p>
    </a>
    <a href="{{ route('setup.vpn') }}" class="tab w-full overflow-hidden">
        <p class="block p-4 leading-normal cursor-pointer border-60 flex" for="tab-single-three">
            <span class="mr-3">4</span>Setup VPN connection
        </p>
    </a>
    <a href="#" class="tab w-full overflow-hidden">
        <p class="block p-4 leading-normal cursor-pointer border-60 flex" for="tab-single-three">
            <span class="mr-3">5</span>Establish connection to the Oryxbot Service
        </p>
    </a>


        <script>
            let refreshVncServiceStatus =
                () => fetch("http://127.0.0.1:5801", { mode: 'no-cors'})
                    .then(r => {
                        if (vnc_status !== 'Online') {
                            console.log('Successfully pinged local TightVNC server');
                        }
                        vnc_status = 'Online'
                        document.querySelectorAll('[data-vnc-online]').forEach(el => el.style.display = 'block');
                        document.querySelectorAll('[data-vnc-offline]').forEach(el => el.style.display = 'none');
                        document.querySelectorAll('[data-online-success]').forEach(el => el.classList.add('success'));
                    })
                    .catch(reason => {
                        vnc_status = 'Unknown';
                        console.log('Failed to ping local TightVNC server');
                        document.querySelectorAll('[data-vnc-online]').forEach(el => el.style.display = 'none');
                        document.querySelectorAll('[data-vnc-offline]').forEach(el => el.style.display = 'block');
                        document.querySelectorAll('[data-online-success]').forEach(el => el.classList.remove('success'));
                    });
            refreshVncServiceStatus();
        </script>
</div>

<div class="mx-auto py-8 max-w-sm text-center text-90">
    <div class="text-primary flex items-center justify-center mx-auto" style="width: 200px">
        @include('nova::partials.digitalocean_logo')
    </div>
</div>


@endsection
