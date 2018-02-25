require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'

// set up to use router
Vue.use(VueRouter)
Vue.use(VueAxios, axios)

Vue.axios.defaults.baseURL = '/api';

// components to utilise
import App from './components/App'
// Auth
import Register from './components/Auth/Register'
import Login from './components/Auth/Login'

import Home from './components/Home'
import Recipes from './components/Recipes'
import RecipesSingle from './components/RecipesSingle'
import NotFound from './components/NotFound'

// routes
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        }, {
            path: '/register',
            name: 'register',
            component: Register,
            meta: {
                auth: false
            }
        }, {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                auth: false
            }
        }, {
            path: '/recipes',
            name: 'recipes.index',
            component: Recipes,
            meta: {
                auth: true
            }
        }, {
            path: '/recipes/:id',
            name: 'recipes.single',
            component: RecipesSingle,
            meta: {
                auth: true
            }
        }, {
            path: '*',
            name: '404',
            component: NotFound,
            meta: {
                auth: false
            }
        }
    ]
});

Vue.router = router
App.router = Vue.router

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
 });

// make the app
new Vue(App).$mount('#app');