import './bootstrap';

import { createApp } from 'vue';
import router from './router/router.js'
import App from './App.vue'
import store from './store'
import VueSweetalert2 from 'vue-sweetalert2';
import VueApexCharts from "vue3-apexcharts";
import 'sweetalert2/dist/sweetalert2.min.css';


createApp(App)
    .use(router)
    .use(store)
    .use(VueSweetalert2)
    .use(VueApexCharts)
    .mount("#app")

