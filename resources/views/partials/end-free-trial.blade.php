<template id="my-template">
    <swal-title>
        {{ __('profile.free_trial_end_begin_subscription_warning_title') }}
    </swal-title>
    <swal-html>
        {!! __('profile.free_trial_end_begin_subscription_warning') !!}
    </swal-html>
    <swal-icon type="question"></swal-icon>
    <swal-button type="confirm">
        {{ __('profile.free_trial_end_begin_subscription_confirm') }}
    </swal-button>
    <swal-button type="cancel">
        {{ __('common.cancel') }}
    </swal-button>
</template>
