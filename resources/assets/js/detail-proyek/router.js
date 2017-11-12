import VueRouter from 'vue-router';

export default new VueRouter({
    routes: [
        {path: '/', component: require('./components/index.vue'), name: 'index'},
        // {path: '/create', component: require('./components/create.vue'), name: 'proyek-create'},
        // {path: '/show/:proyekId', component: require('./components/show.vue'), name: 'proyek-show', props: {loading: false}},
        // {path: '/edit/:proyekId', component: require('./components/edit.vue'), name: 'proyek-edit', meta: {mode: 'edit'}},
        // {path: '/destroy/:proyekId', component: require('./components/destroy.vue'), name: 'proyek-destroy'}
    ]
});
