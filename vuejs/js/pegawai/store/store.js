import Vue from 'vue'
import Vuex from 'vuex'
import moduleTable from './modules/moduleTable'

Vue.use(Vuex)
const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules:{
        // loading: moduleLoading,
        table: moduleTable,
    },
    strict: debug
});
