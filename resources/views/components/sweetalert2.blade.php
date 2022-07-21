@if (session()->has('success') || session()->has('error') || session()->has('warning'))
    <!-- Toast -->
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            console.log('fireToast');
            @if (session()->has('success'))
                fireToast({
                    icon: 'success',
                    message: @js(session('success')),
                });
            @endif
            @if (session()->has('success'))
                fireToast({
                    icon: 'success',
                    message: @js(session('success')),
                });
            @endif
            @if (session()->has('error'))
                fireToast({
                    icon: 'error',
                    message: @js(session('error')),
                });
            @endif

            @if (session()->has('warning'))
                fireToast({
                    icon: 'warning',
                    message: @js(session('warning')),
                });
            @endif
        });
    </script>
@endif
