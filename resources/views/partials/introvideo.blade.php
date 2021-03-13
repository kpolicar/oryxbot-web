<div class="anchor" id="presentation"></div>
<section class="bg-gray-100 py-8 pb-12 border-t-4 border-b-4 border-gray-500">
    <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
        {{ __('presentation.header') }}
    </h2>
    <div class="w-full mb-4">
        <div class="h-1 mx-auto gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
    </div>
    <p class="w-full my-2 text-xl leading-tight text-center text-gray-800">
        {{ __('presentation.description') }}<br>
        {{ __('presentation.engage') }}
    </p>

    <video title="{{ __('presentation.video_alt') }}"
           poster="{{ asset('images/oryxbot_intro_poster.png') }}"
           class="mx-auto mt-8 my-6 mb-3 rounded bg-gray-900 shadow-lg"
           height="1920"
           width="1080"
           preload="metadata"
           controls
           loop
           controlslist="nodownload"
           disablePictureInPicture>
        <source src="{{ storage_path('videos/oryxbot_intro.mp4') }}" type="video/mp4" />
    </video>
</section>
