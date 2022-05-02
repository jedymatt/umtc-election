<!-- SweetAlert2 script -->
@if(session()->has('success'))
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            showCloseButton: true,
        });

        Toast.fire({
            icon: 'success',
            title: {{ Js::from(session('success'))}},
        });
    </script>
@endif
