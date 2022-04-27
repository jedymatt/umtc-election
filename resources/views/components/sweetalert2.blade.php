<!-- SweetAlert2 script -->
<script>
    @if(session()->has('success'))
    document.addEventListener('DOMContentLoaded', function () {
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
    });
    @endif
</script>
