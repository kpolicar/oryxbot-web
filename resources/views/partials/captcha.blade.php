@production
    @push('head')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onFormSubmit(token) {
                document.getElementById("{{ $formElementId }}").submit();
            }
        </script>
    @endpush
@endproduction
