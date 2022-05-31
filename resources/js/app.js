require('./bootstrap');

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

import Swal from 'sweetalert2';


window.Alpine = Alpine;
window.Swal = Swal;

Alpine.plugin(collapse);
Alpine.start();


window.fireToast = ({ icon, message }) => {
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
