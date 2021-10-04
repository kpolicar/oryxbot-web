<h3 class="flex items-center font-normal text-white mb-6 text-base no-underline">
    <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="var(--sidebar-icon)" d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"/></svg>
    <span class="sidebar-label">
        Instances
    </span>
</h3>

<ul class="list-reset mb-8">
    @foreach(['Bot #1', 'Bot #2', 'Bot #3'] as $i => $resource)
        <li class="leading-tight mb-4 ml-8 pl-8 text-sm">
            <router-link tag="h4" id="nav_oryxbot-instance-{{ $i }}" :to="{
                name: 'oryxbot-instance',
                }" class="cursor-pointer flex items-center font-normal dim text-white mb-4 text-base no-underline">

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

                <span class="sidebar-label">
                    <span class="text-sm">
                        {{ $resource }}
                    </span>
                </span>
            </router-link>
        </li>
    @endforeach
</ul>
