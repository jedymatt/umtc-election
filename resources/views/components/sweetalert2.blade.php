@if(session()->has('success') || session()->has('error') || session()->has('warning'))
    <!-- SweetAlert2 script -->
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
@endif
<!-- Toast -->
@if (session()->has('success'))
    <script>
        fireToast({
            icon: 'success',
            message: @js(session('success')),
        });
    </script>
@endif
@if (session()->has('error'))
    <script>
        fireToast({
            icon: 'error',
            message: @js(session('error')),
        });
    </script>
@endif

@if (session()->has('warning'))
    <script>
        fireToast({
            icon: 'warning',
            message: @js(session('warning')),
        });
    </script>
@endif

