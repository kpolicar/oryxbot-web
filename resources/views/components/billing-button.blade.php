<div>
    @if (Auth::user()->subscribedToTradeMissionBot())
        <a href="{{ route('billing') }}" @if($class != "")class="inline-block {{ $class }}@endif">
            {{ $slot != '' ? $slot : __('common.manage') }}
        </a>
    @elseif($trial)
        @php($freeTrialNotPossible = Auth::user()->subscriptions()->exists())
        @php($class = $freeTrialNotPossible ? "cursor-not-allowed hover:no-underline ".$class : $class)
        <button @if($class != "")class="{{ $class }}"@endif data-checkout="{{ route('create-checkout-session-trial') }}"
                @if(Auth::user()->subscriptions()->exists()) disabled @endif
                @if($freeTrialNotPossible) title="{{ __('common.free_trial_ineligible') }}" @endif>
            {{ $slot != '' ? $slot : __('common.activate') }}
        </button>
    @else
        <button @if($class != "")class="{{ $class }}"@endif data-checkout="{{ route('create-checkout-session') }}">
            {{ $slot != '' ? $slot : __('common.purchase') }}
        </button>
    @endif

    <script>
    </script>
</div>
