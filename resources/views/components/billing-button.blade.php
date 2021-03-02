<div>
    @subscribed
        <a href="{{ route('billing') }}" @if($class != "")class="inline-block {{ $class }}@endif">
            {{ $slot != '' ? $slot : __('common.manage') }}
        </a>
    @else
        <button @if($class != "")class="{{ $class }}@endif" data-checkout="{{ route('create-checkout-session') }}">
            {{ $slot != '' ? $slot : __('common.purchase') }}
        </button>
    @endsubscribed

    <script>
    </script>
</div>
