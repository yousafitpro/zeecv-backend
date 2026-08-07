@if (config('myconfig.PLATFORM.ENV') !== 'local')
    <script>
        if (document.location.protocol !== 'https:') {
            document.location.protocol = 'https:';
        }
    </script>
@endif
