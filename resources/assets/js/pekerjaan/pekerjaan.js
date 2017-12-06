require('./../bootstrap');
window.Vue = require('vue');


const swal = require('sweetalert2')
const swalPlugin = {}
swalPlugin.install = function(Vue){
	Vue.prototype.$swal = swal
}
Vue.use(swalPlugin)

var _http = axios.create({
  baseURL: 'http://localhost:8000/api/pekerjaan',
  headers:{
  	'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjIxMjNiYzUzNjAwNDhmNGI2NmFhODY0NTBmZGYwMDAzN2ViOWE2ZGI5MTJkMWI4NzZkZjRkMmRjNjJlZmYwOTVhOTVmOWUyNzkyOGJiOWI0In0.eyJhdWQiOiIyIiwianRpIjoiMjEyM2JjNTM2MDA0OGY0YjY2YWE4NjQ1MGZkZjAwMDM3ZWI5YTZkYjkxMmQxYjg3NmRmNGQyZGM2MmVmZjA5NWE5NWY5ZTI3OTI4YmI5YjQiLCJpYXQiOjE1MTI0NzEyNTYsIm5iZiI6MTUxMjQ3MTI1NiwiZXhwIjoxNTQ0MDA3MjU2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.0Py2G71LWWRHKkqm2Ji35CkcV01nTKmpsl3YYu8c0qljXHon1fKCsQahl7a2M6Ph5wLiecF4JglcHPyB6ONXcZWxtX9KrXebfXFWWoPO7Psd4AV3aKdFWGq3t9ZYtywj7SdivkLOZhLm46-heQWt9-RHIR0J_0plgAKhwIqRGMgCIOjWdXPca2p9304XsocuDTngan8JVHRHSWJT8icmpZpMSUysX8il2Tx-jfH1U9l7nOyDWSREVUwOnz59jkMr_CQ4ubEHe3aBF8UXvj03KJNFo105a4WaKKFeCZ03q51SjMd7vj563rsff2_fVDrbgRkLMlkbZjfHnb580ZYM9aRmeYF1UvtDgJ3pXMmJqQ3FR0AgjW3EDazhpqwM7yckKTixxEiwz8o6g3BYdE3z5WuXCJmegRnjQ_as_1rCaMXkpriHwr_kRwFAZCMysetu5t7W71gYzarADR44NB-o6xwGuiD2yGbwwUo5uH0nrW_Yc2rWLcll8ZheS5XxANdRyipJF8s6Bd62VEujbkF4idVO03zxyaxKiDEmDC6DNKiXdpvJ5bZbiEsulgLLDzkQI2NaytXaSsTYnyCAbTHBiCd-jsAn5SwRJAaRFecGU5glCKon2m-MZL1H6tHNqherlOm4i7vKwj4HCAz0GbzWqMussxPiYWASDTGSDDI3M0g'
  }
})
_http.interceptors.response.use((response) => {
    return response;
}, function (error) {
    // Do something with response error
    if (error.response.status === 401 || error.response.status === 500) {
    	swal(error.response.statusText, error.response.data.message, "error")
    }
    if (error.response.status === 422) {
    	var contentHtml = '';
        Object.keys(error.response.data.errors).forEach((key) => {
          contentHtml +=  '<p class="text-danger">'+error.response.data.errors[key][0]+'</p>'
        })
        
        swal({
          title: error.response.data.message,
          html: contentHtml,
          type: 'error',
          timer: 5000,
        })	
    }
    return Promise.reject(error.response);
})
Vue.prototype.$http = _http
Vue.config.productionTip = false

import App from './components/App'

import VueRouter from 'vue-router'
Vue.use(VueRouter)
import router from './router.js'

import store from './store/store'

const app = new Vue({
    el: '#root',
    template: '<app></app>',
    components: { App },
    router,
    store,
})
