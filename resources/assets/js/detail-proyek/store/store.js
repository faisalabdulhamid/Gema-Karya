import Vue from 'vue'
import Vuex from 'vuex'
import moduleAuth from './modules/auth'

Vue.use(Vuex)
const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules:{
        // loading: moduleLoading,
        table: moduleAuth,
    },
    strict: debug
});
