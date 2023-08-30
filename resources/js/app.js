import './bootstrap';

import { createApp } from 'vue';

import router from './routes'
import VueSweetalert2 from 'vue-sweetalert2';

createApp({})
    .use(router)
    .use(VueSweetalert2)
    .mount('#app')
