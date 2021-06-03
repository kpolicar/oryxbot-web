<aside id="download-notification" class="text-white pr-6 py-4 border-0 rounded-lg bg-black fixed bottom-0 left-0 right-0 top-0 mx-2 md:mx-auto m-auto text-center w-auto z-10 hidden" style="opacity: 0.85; height: fit-content; width: fit-content">
    <span class="inline-block align-middle mx-5 mr-8 font-bold">
        <i class="fas fa-lock mr-3 mx-1 text-lg"></i>
        @section('support_email')
            <a href="mailto:support@oryxbot.com" class="font-bold text-gray-500">support@oryxbot.com</a>
        @endsection

        {{ __('messages.download_locked') }}<br/>
        {!! __('messages.download_locked_contact', ['link' => View::getSection('support_email')]) !!}
  </span>
    <button id="download-notification-close" data-hide="#download-notification" class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
        <span>×</span>
    </button>
</aside>
