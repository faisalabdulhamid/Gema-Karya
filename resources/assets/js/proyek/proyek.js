require('./../bootstrap');
window.Vue = require('vue');

Vue.component('index', require('./components/index.vue'));

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import router from './router.js'

const app = new Vue({
    el: '#proyek',
    router
});
