@if (Auth::user()->subscribedToTradeMissionBot())
    <a href="{{ route('billing') }}" @if($class != "")class="inline-block {{ $class }}@endif">
        {{ $slot != '' ? $slot : __('common.manage') }}
    </a>
@elseif($trial)
    @php($freeTrialNotPossible = !Auth::user()->eligibleForFreeTrial())

    @php($class = $freeTrialNotPossible ? "cursor-not-allowed hover:no-underline ".$class : $class)
    <button @if($class != "")class="{{ $class }}"@endif data-checkout="{{ route('create-checkout-session-trial') }}"
            @if($freeTrialNotPossible) disabled title="{{ !Auth::user()->hasVerifiedEmail() ? __('common.free_trial_notverified') : __('common.free_trial_ineligible') }}" @endif>
        {{ $slot != '' ? $slot : __('common.activate') }}
    </button>
@else
    @php($purchaseNotPossible = !Auth::user()->hasVerifiedEmail())
    @php($class = $purchaseNotPossible ? "cursor-not-allowed hover:no-underline ".$class : $class)

    <a @if($class != "")class="{{ $class }}"@endif
        href="{{ route('subscribe') }}"
        @if($purchaseNotPossible) disabled title="{{ __('common.purchase_notverified') }}" @endif>
        {{ $slot != '' ? $slot : __('common.purchase') }}
    </a>
@endif
