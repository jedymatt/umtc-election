@if (session()->has('success'))
    <!-- SweetAlert2 script -->
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script>
        fireToast({
            icon: 'success',
            message: {{ Js::from(session('success')) }},
        });
    </script>
@endif
