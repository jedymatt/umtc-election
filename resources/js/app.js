import './bootstrap';
import Swal from 'sweetalert2';

window.Swal = Swal;

window.fireToast = ({icon, message}) => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        showCloseButton: true,
        padding: '1rem',
    });

    Toast.fire({
        icon: icon,
        titleText: message,
    });
};

window.addEventListener('toast-alert', function (event) {
    fireToast({
        icon: event.detail.type,
        message: event.detail.message,
    });
});
