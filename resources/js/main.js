import { createApp } from 'vue';
import './bootstrap';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

window.Swal = Swal;
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timeProgressBar: true,

});

window.toast = toast;

// Main route and main application view
import mainRouter from './mainView/router';
import MainView from "./mainView/components/App.vue";

createApp(MainView).use(mainRouter).mount('#main-view');