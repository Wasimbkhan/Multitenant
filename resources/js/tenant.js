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

// tenant Route and tenent application view
import tenantRouter from './tenantView/router';
import TenantView from "./tenantView/components/App.vue";

createApp(TenantView).use(tenantRouter).mount('#tenant-view');