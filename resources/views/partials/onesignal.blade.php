<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
        OneSignal.init({
            appId: "{{ config('onesignal.app_id') }}",
        });


        @auth

        @if(\Session::get('logged_in'))
        OneSignal.isPushNotificationsEnabled(function(isEnabled) {
            if (!isEnabled) return;

            OneSignal.push(function () {
                OneSignal.setExternalUserId({{ Auth::user()->id }});
            });
        });
        @endif

        OneSignal.on('subscriptionChange', function(isSubscribed) {
            if (!isSubscribed) return;

            OneSignal.push(function () {
                OneSignal.setExternalUserId({{ Auth::user()->id }});
            });
        });
        @endauth
    });
</script>

