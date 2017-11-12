require('./../bootstrap');
window.Vue = require('vue');

import App from './components/App'

const _http = axios.create({
  baseURL: 'http://localhost:8000/proyek',
});
Vue.prototype.$http = _http
Vue.config.productionTip = false

import VueRouter from 'vue-router'
Vue.use(VueRouter)
import router from './router.js'

import store from './store/store'

import swall from 'sweetalert'

const app = new Vue({
    el: '#root',
    template: '<app></app>',
    components: { App },
    router,
    store,
    created(){
      var local = {'name': "Faisal Abdul Hamid", 'status': "admin"};
      localStorage.setItem('user', JSON.stringify(local))
    },
    computed:{
      isUser(){
        let user = localStorage.getItem('user')
        let userObj = JSON.parse(user)
        return userObj.status;
      }
    }
});
