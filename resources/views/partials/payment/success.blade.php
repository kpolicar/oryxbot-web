<div class="flex justify-between items-end my-4">
    <h3 class="text-3xl font-bold leading-tight align-middle">
        {{ __('payment.success') }}
    </h3>
    <i class="fas fa-check-circle text-5xl"></i>
</div>
<div class="w-full mb-4">
    <div class="h-1 mx-auto bg-white opacity-25 my-0 py-0 rounded-t"></div>
</div>
<div class="flex justify-between my-4 text-xl">
    <p class="font-bold">{{ __('forms.basket_item') }}</p>
    <p class="text-lg">{{ __('forms.basket_option', ['option' => 1]) }}</p>
</div>
<div class="flex justify-between my-4 text-xl">
    <p class="font-bold">{{ __('forms.basket_paid') }}</p>
    <p class="text-lg">@money(price()/100)</p>
</div>
<p class="text-gray-400 text-base mt-16">
    {{ __('payment.success_description') }}
</p>
<p class="text-gray-200 text-sm mt-5">
    @section('payment_email')
        <a href="mailto:payment@oryxbot.me" class="font-bold">payment@oryxbot.me</a>
    @endsection
    {!! __('payment.success_unexpected', ['link' => View::getSection('payment_email')]) !!}
</p>

<script>
    setTimeout(function(){ OneSignal.showNativePrompt(); }, 800);
</script>
