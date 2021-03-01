<div>
    @subscribed
    @else
        <button @if($class != "")class="{{ $class }}@endif" data-checkout="{{ route('create-checkout-session') }}">
            {{ __('profile.subscribed_purchase') }}
        </button>
        <a href="{{ route('billing') }}" @if($class != "")class="inline-block {{ $class }}@endif">
            {{ __('profile.subscribed_manage') }}
        </a>
    @endsubscribed

    <script>
    </script>
</div>
