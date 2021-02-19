<div class="mx-auto flex flex-col w-full lg:w-2/5 p-6">
    <h2 class="w-full my-2 text-5xl font-bold leading-tight text-gray-800">Limitations</h2>
    <div class="w-full mb-4">
        <div class="h-1 gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
    </div>

    @if(in_array('1920x1080', $restrictions))
    <h3 class="text-black text-xl font-bold"><i class="fas fa-vector-square text-3xl mr-3"></i> 1920x1080</h3>
    <p class="text-black my-3">
        You can use this version of Oryxbot in 1920x1080 resolution maximized window mode.<br>
        <small class="text-sm italic">
            If you have a screen with <strong>lower</strong> resolution, you will not be able to run the bot.<br>
            If your screen has a <strong>higher</strong> resolution, refer to
            <a href="#ocr-bounds" class="font-bold text-gray-600">fitting OCR bounds</a>.<br>
        </small>
        This process will be improved in the near future.
    </p>
    @endif

    @if(in_array('administrator', $restrictions))
    <h2 class="text-black text-xl font-bold"><i class="fas fa-shield-alt text-3xl mr-3"></i> Administrator mode</h2>
    <p class="text-black my-3">
        The bot must be run in administrator mode.<br>
        <small class="text-sm italic">
            Windows does not allow simulating mouse clicks in standard mode.
        </small>
    </p>
    @endif

    @if(in_array('in_background', $restrictions))
    <h2 class="text-black text-xl font-bold"><i class="fas fa-mouse-pointer text-3xl mr-3"></i> Run in background</h2>
    <p class="text-black my-3">
        You must not hover your mouse over the Dofus client while maging.<br>
        You can have other windows over Oryxbot, however Oryxbot must not be minimized.<br>
    </p>
    @endif

    @if(in_array('minimized', $restrictions))
    <h2 class="text-black text-xl font-bold"><i class="fas fa-window-maximize text-3xl mr-3"></i> Do not minimize</h2>
    <p class="text-black my-3">
        You can run Oryxbot under other applications, however it must not be minimized.
    </p>
    @endif

    @if(in_array('stable_connection', $restrictions))
    <h2 class="text-black text-xl font-bold"><i class="fas fa-wifi text-3xl mr-3"></i> Stable internet connection</h2>
    <p class="text-black my-3">
        You should use Oryxbot with a stable internet connection to avoid unexpected issues.
    </p>
    @endif
</div>
