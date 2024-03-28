import './bootstrap';
import Swal from 'sweetalert2';

window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    showCloseButton: true,
    padding: '1rem',
});

const fireToast = ({icon, message}) => Toast.fire({icon: icon, titleText: message});

window.fireToast = fireToast;

window.addEventListener('toast-alert', (event) => {
    fireToast({icon: 'error', message: 'test'});
    window.fireToast({
        icon: event.detail.type, message: event.detail.message,
    });
});
