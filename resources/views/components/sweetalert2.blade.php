<script>
    <!-- SweetAlert2 script -->
    @if(session('success'))
    document.addEventListener('DOMContentLoaded', function () {
        toast({
            icon: 'success',
            message: {{ Js::from(session('success')) }}
        });
    });
    @endif
</script>
