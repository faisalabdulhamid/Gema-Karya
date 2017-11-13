require('./../bootstrap')
window.Vue = require('vue')

const url = window.location.pathname
const id = url.split('/')

const _http = axios.create({
  baseURL: 'http://localhost:8000/detail/'+id[2],
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
  created(){
    axios.get('/user').then(res => {
        localStorage.setItem('user', JSON.stringify(res.data))
    });
  }
})
