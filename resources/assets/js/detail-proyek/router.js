import VueRouter from 'vue-router';

export default new VueRouter({
    routes: [
        {path: '/', component: require('./components/index.vue'), name: 'index'},

        {path: '/pekerjaan', component: require('./components/pekerjaan/index.vue'), name: 'pekerjaan-index'},
        {path: '/pekerjaan/create', component: require('./components/pekerjaan/create.vue'), name: 'pekerjaan-create'},

        {path: '/resiko', component: require('./components/resiko/index.vue'), name: 'resiko-index'},
        {path: '/resiko/:id', component: require('./components/resiko/show.vue'), name: 'resiko-show', props: true},
        {path: '/resiko/create', component: require('./components/resiko/create.vue'), name: 'resiko-create'},

        {path: '/bahan', component: require('./components/bahan/index.vue'), name: 'bahan-index'},
        {path: '/bahan/create', component: require('./components/bahan/create.vue'), name: 'bahan-create'},

        {path: '/pegawai', component: require('./components/pegawai/index.vue'), name: 'pegawai-index'},
        {path: '/pegawai/create', component: require('./components/pegawai/create.vue'), name: 'pegawai-create'},
    ]
});
