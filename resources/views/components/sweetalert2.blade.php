<!-- SweetAlert2 script -->
@if (session()->has('success'))
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script>
        fireToast({
            icon: 'success',
            message: {{ Js::from(session('success')) }},
        });
    </script>
@endif
