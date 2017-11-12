import VueRouter from 'vue-router';

export default new VueRouter({
    routes: [
        {path: '/', component: require('./components/index.vue'), name: 'index'},
        {path: '/create', component: require('./components/create.vue'), name: 'create'},
        {path: '/show/:id', component: require('./components/show.vue'), name: 'show'},
        {path: '/edit/:id', component: require('./components/edit.vue'), name: 'edit'},
    ]
});
