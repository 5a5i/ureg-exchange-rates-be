import './bootstrap.js'; // Bootstrap initialization
import { createApp } from 'vue'; // Vue 3 initialization
import App from './App.vue';
import { createRouter, createWebHistory } from 'vue-router'; // Vue Router 4
import { routes } from './routes.js';
import axios from 'axios';
// import moment from 'moment';

// Create the Vue app instance
const app = createApp(App);

// Create and configure the router
const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Add global properties and plugins
app.config.globalProperties.axios = axios; // Global axios
app.provide('axios', axios); // Optional, for dependency injection

// app.config.globalProperties.$filters = {
//     formatDate(value) {
//         if (value) {
//             return moment(String(value)).format('DD/MM/YYYY hh:mm');
//         }
//     },
// };

// Add a global navigation guard
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !window.Laravel.isLoggedin) {
        next({ name: 'login' });
    } else {
        next();
    }
});

// Use plugins and mount the app
app.use(router);
app.mount('#app');
