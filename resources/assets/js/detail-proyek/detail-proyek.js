require('./../bootstrap')
window.Vue = require('vue')

const url = window.location.pathname
const id = url.split('/')

const swal = require('sweetalert2')
const swalPlugin = {}
swalPlugin.install = function(Vue){
  Vue.prototype.$swal = swal
}
Vue.use(swalPlugin)

var _http = axios.create({
  baseURL: 'http://localhost:8000/api/detail/'+id[2],
  headers:{
    'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQwZjE3YzE0MDYwMjZhN2EyNGViZjUwNGU5OWFlMTAwYjQ5MDYwM2FhNTgzNmFjMzg2OWQyODFhMDFiNGI4YWJjOGI0MDQxMzcwMTgwNmViIn0.eyJhdWQiOiIyIiwianRpIjoiZDBmMTdjMTQwNjAyNmE3YTI0ZWJmNTA0ZTk5YWUxMDBiNDkwNjAzYWE1ODM2YWMzODY5ZDI4MWEwMWI0YjhhYmM4YjQwNDEzNzAxODA2ZWIiLCJpYXQiOjE1MTIzOTgxMjcsIm5iZiI6MTUxMjM5ODEyNywiZXhwIjoxNTQzOTM0MTI3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.adOKgxQbRgUMuUQaqualJYaHd0loHEsPo3xLPjnZ9xs2BU_9PYGm0sm2vdTKmzRA3bdWBCK2iPRgRf3amxcAqxrQKkHVLTIjDYDPJznw0LQ6LKoIutazglpagDvEIbzR5Lu00r_Fg5FQcJIlAQsfZbnog2OeMVy9OqUQYy7F5v1fNRHF1wIFnDzLV35m8haNil4ghcqKJA0H80GoisyVwJxzb0AhL4rz0Z_4DmPP9QUy9ngfoEa5rSCliEq1x3ou5qm8Mt9VPWHSiHjQFCJ2g4ZSAbrhey610WXhlBpcdeYjx8QJp-4K9jlzdvg6nbm97SRmoPH8QqywNqTKwmnGKUtfwJqa1td6gNIVgyWzzCAKHHk2i-Dot3-kl8JFF0Pgva5Ni5g-gtapdIBddHZUnj72fQ0lRHe6lDwoYXVjXHKErL7gBgYQr1ag8Z8kmOr_jkqXWWB9Pf9dgQXJh1gC49n10NS11hvqGBaoH8Qq9QJfEp-BQYpS2-LtQzjKCE4qE99cCsUR-JpbyPIwcYve5KnzBUHnNRPzjhjhxnY3ocVRezoz7v-DjO-E-jbWuhMbkQLyRdA82WdyOSnNydZ0eVihTrFQ_qxAqkakzA0zQMF6oXvChVtBmQc9L0zbsA1OGkiWZgdCJc4hW-2FECWpagASwI1XiJclzhx_gcWa8DU',
    'proyek_id': id[2]
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
  created(){
    axios.get('/user').then(res => {
        localStorage.setItem('user', JSON.stringify(res.data))
    });
  }
})
