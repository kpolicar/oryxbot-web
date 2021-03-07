<div class="mx-auto flex flex-col w-full lg:w-2/5 p-6">
    <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-200">Limitations</h2>
    <div class="w-full mb-4">
        <div class="h-1 gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
    </div>

    @if(in_array('administrator', $restrictions))
    <h2 class="text-gray-400 text-xl font-bold"><i class="fas fa-shield-alt text-3xl mr-3"></i> Administrator mode</h2>
    <p class="text-gray-400 my-3">
        The bot must be run in administrator mode.<br>
        <small class="text-sm italic">
            Windows does not allow simulating mouse clicks in standard mode.
        </small>
    </p>
    @endif

    @if(in_array('in_foreground', $restrictions))
    <h2 class="text-gray-400 text-xl font-bold"><i class="fas fa-mouse-pointer text-3xl mr-3"></i> Runs in foreground</h2>
    <p class="text-gray-400 my-3">
        Oryxbot <strong>does not</strong> inject keyboard and mouse events directly into the Albion client application.<br>
        Instead, it takes complete control of your cursor and keyboard, meaning you cannot do anything else with your computer while it is running.
    </p>
    @endif

    @if(in_array('stable_connection', $restrictions))
    <h2 class="text-gray-400 text-xl font-bold"><i class="fas fa-wifi text-3xl mr-3"></i> Stable internet connection</h2>
    <p class="text-gray-400 my-3">
        You should use Oryxbot with a stable internet connection to avoid unexpected issues.
    </p>
    @endif
</div>
