<div class="mx-auto flex flex-col w-full lg:w-2/5 p-6">
    <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-200">Limitations</h2>
    <div class="w-full mb-4">
        <div class="h-1 gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
    </div>

    @if(in_array('administrator', $restrictions))
    <h2 class="text-gray-300 text-xl font-bold"><i class="fas fa-shield-alt text-3xl mr-3 text-gray-200"></i> Administrator mode</h2>
    <p class="text-gray-500 my-3">
        The bot must be run in administrator mode.<br>
        <small class="text-sm italic">
            Windows does not allow simulating mouse clicks in standard mode.
        </small>
    </p>
    @endif

    @if(in_array('in_foreground', $restrictions))
    <h2 class="text-gray-300 text-xl font-bold"><i class="fas fa-mouse-pointer text-3xl mr-3 text-gray-200"></i> Runs in foreground</h2>
    <p class="text-gray-500 my-3">
        Oryxbot does not inject keyboard and mouse events directly into the Albion client application.<br>
        Instead, it takes complete control of your cursor and keyboard, meaning you cannot do anything else with your computer while it is running.
    </p>
    @endif

    @if(in_array('full_screen', $restrictions))
        <h2 class="text-gray-300 text-xl font-bold"><i class="fas fa-expand text-3xl mr-3 text-gray-200"></i> Fullscreen</h2>
        <p class="text-gray-500 my-3">
            Your Albion Online client must be running in full-screen mode for Oryxbot to work properly.
            Oryxbot retrieves your screen resolution and calculates where it needs to click
            based on that.
        </p>
    @endif

    @if(in_array('lymhurst_only', $restrictions))
    <h2 class="text-gray-300 text-xl font-bold"><i class="fas fa-lock text-3xl mr-3 text-gray-200"></i> Limited to Lymhurst</h2>
    <p class="text-gray-500 my-3">
        Oryxbot is only configured to run the Lymhurst trade mission in this version.
        Other cities and custom routes will be made available soon.
    </p>
    @endif

    @if(in_array('needs_assistance', $restrictions))
    <h2 class="text-gray-300 text-xl font-bold"><i class="fas fa-wheelchair text-3xl mr-3 text-gray-200"></i> In need of assistance</h2>
    <p class="text-gray-500 my-3">
        This is an early release, so the bot might need your help sometimes. The character might get stuck or
        it can have trouble interacting with the quest NPCs.
    </p>
    @endif
</div>
