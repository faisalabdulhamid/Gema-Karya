require('./../bootstrap');
window.Vue = require('vue');

import {base_url} from './../config/env'
import VueRouter from 'vue-router'
import router from './router.js'
import App from './components/App'

Vue.use(VueRouter)

const swal = require('sweetalert2')
const swalPlugin = {}
swalPlugin.install = function(Vue){
	Vue.prototype.$swal = swal
}
Vue.use(swalPlugin)

let _http = axios.create({
  baseURL: `${base_url}/proyek`,
})
_http.interceptors.response.use((response) => {
    return response;
}, function (error) {
    console.log(error)
    // Do something with response error
    if (error.response.status === 422) {
    	let contentHtml = '';
        Object.keys(error.response.data.errors).forEach((key) => {
          contentHtml +=  '<p class="text-danger">'+error.response.data.errors[key][0]+'</p>'
        })
        
        swal({
          title: error.response.data.message,
          html: contentHtml,
          type: 'error',
          timer: 5000,
        })
    }else if(error.response.status === 419 || error.response.statusText === 'unknown status'){
      swal('Opps', 'Anda Harus Login kembali', "error", 5000)
      window.location.href = `${base_url}/login`
    }else{
      swal(error.response.statusText, error.response.data.message, "error")
    }
    return Promise.reject(error.response);
})
Vue.prototype.$http = _http
Vue.config.productionTip = false

const app = new Vue({
    el: '#root',
    template: '<app></app>',
    components: { App },
    router,
    created(){
      _http.get(base_url+'/user').then(res => {
        localStorage.setItem('user', JSON.stringify(res.data))
      })
    }
});
