require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

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
        title: message,
    });
};
