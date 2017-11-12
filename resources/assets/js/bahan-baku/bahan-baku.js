require('./../bootstrap');
window.Vue = require('vue');

const _http = axios.create({
  baseURL: 'http://localhost:8000/bahan-baku',
});
Vue.prototype.$http = _http
Vue.config.productionTip = false

import App from './components/App'

import VueRouter from 'vue-router'
Vue.use(VueRouter)
import router from './router.js'

import store from './store/store'

import swal from 'sweetalert'

const app = new Vue({
    el: '#root',
    template: '<app></app>',
    components: { App },
    router,
    store,
})
