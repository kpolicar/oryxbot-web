@if (count(\Laravel\Nova\Nova::resourcesForNavigation(request())))
    <h3 class="flex items-center font-normal text-white mb-6 text-base no-underline">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill="var(--sidebar-icon)" d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"
            />
        </svg>
        <span class="sidebar-label">{{ __('Resources') }}</span>
    </h3>

    @foreach($navigation as $group => $resources)
        @if (count($groups) > 1)
            <h4 class="ml-8 mb-4 text-xs text-white-50% uppercase tracking-wide">{{ $group }}</h4>
        @endif

        <ul class="list-reset mb-8">
            @foreach($resources as $resource)
                <li class="leading-tight mb-4 ml-8 text-sm">
                    <router-link :to="{
                        name: 'index',
                        params: {
                            resourceName: '{{ $resource::uriKey() }}'
                        }
                    }" class="text-white text-justify no-underline dim" dusk="{{ $resource::uriKey() }}-resource-link">
                        {{ $resource::label() }}
                    </router-link>
                </li>
            @endforeach
        </ul>
    @endforeach
@endif

<h3 class="flex items-center font-normal text-white mb-6 text-base no-underline">
    <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path fill="var(--sidebar-icon)" d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"
        />
    </svg>
    <span class="sidebar-label">{{ __('Instances') }}</span>
</h3>

<ul class="list-reset mb-8">
@foreach(['Bot #1', 'Bot #2', 'Bot #3'] as $i => $resource)
    <li class="leading-tight mb-4 ml-8 text-sm">
        <router-link :to="{
            name: 'index',
            params: {
            resourceName: '{{ '/' }}'
            }
            }" class="text-white text-justify no-underline dim" dusk="example-resource-link">

            <svg aria-hidden="true"
                 focusable="false"
                 data-prefix="fas"
                 data-icon="circle"
                 style="margin-left: -32px; margin-right: 16px; border-width: 1px; border-color: --var(black); border-radius: 50%"
                 height="16"
                 width="16"
                 role="img" xmlns="http://www.w3.org/2000/svg"
                 class="{{ $i == 0 ? 'text-primary' : 'text-60' }}"
                 viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
            </svg>

            {{ $resource }}
        </router-link>
    </li>
@endforeach
</ul>

<router-link exact tag="h3"
             :to="{
        name: 'dashboard.custom',
        params: {
            name: 'main'
        }
    }"
             class="cursor-pointer flex items-center font-normal dim text-white mb-8 text-base no-underline">

    <svg aria-hidden="true"
         focusable="false"
         data-prefix="far"
         data-icon="file-alt"
         class="sidebar-icon"
         role="img"
         xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 384 512"><path fill="currentColor" d="M288 248v28c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-28c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm-12 72H108c-6.6 0-12 5.4-12 12v28c0 6.6 5.4 12 12 12h168c6.6 0 12-5.4 12-12v-28c0-6.6-5.4-12-12-12zm108-188.1V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V48C0 21.5 21.5 0 48 0h204.1C264.8 0 277 5.1 286 14.1L369.9 98c9 8.9 14.1 21.2 14.1 33.9zm-128-80V128h76.1L256 51.9zM336 464V176H232c-13.3 0-24-10.7-24-24V48H48v416h288z"></path>
    </svg>

    <span class="text-white sidebar-label">{{ __('Logs') }}</span>
</router-link>

<router-link exact tag="h3"
             :to="{
        name: 'dashboard.custom',
        params: {
            name: 'main'
        }
    }"
             class="cursor-pointer flex items-center font-normal dim text-white mb-8 text-base no-underline">
    <svg aria-hidden="true"
         focusable="false"
         data-prefix="fas"
         data-icon="chart-line"
         class="sidebar-icon"
         role="img"
         xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 512 512"><path fill="currentColor" d="M496 384H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16zM464 96H345.94c-21.38 0-32.09 25.85-16.97 40.97l32.4 32.4L288 242.75l-73.37-73.37c-12.5-12.5-32.76-12.5-45.25 0l-68.69 68.69c-6.25 6.25-6.25 16.38 0 22.63l22.62 22.62c6.25 6.25 16.38 6.25 22.63 0L192 237.25l73.37 73.37c12.5 12.5 32.76 12.5 45.25 0l96-96 32.4 32.4c15.12 15.12 40.97 4.41 40.97-16.97V112c.01-8.84-7.15-16-15.99-16z"></path>
    </svg>
    <span class="text-white sidebar-label">{{ __('Insights') }}</span>
</router-link>
