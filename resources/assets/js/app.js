require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'

// set up to use router
Vue.use(VueRouter)
Vue.use(VueAxios, axios)

Vue.axios.defaults.baseURL = '/api/';

// Utilities
import Icon from './components/Utilities/Icon'

// components to utilise
import App from './components/App'

// Auth
import Register from './components/Auth/Register'
import Login from './components/Auth/Login'

import Home from './components/Home'
import Recipes from './components/Recipes'
import RecipesSingle from './components/RecipesSingle'
import Categories from './components/Categories'
import Category from './components/Category'
import Pantry from './components/Pantry'
import NotFound from './components/NotFound'
import ShoppingList from './components/ShoppingList' 
import Dashboard from './components/Account/Dashboard' 
import RecipeCreate from './components/Account/RecipeCreate' 
import Settings from './components/Account/Settings' 
import Search from './components/Search' 

// routes
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        }, {
            path: '/login',
            name: 'login',
            component: Login
        },{
            path: '/search',
            name: 'search',
            component: Search
        },{
            path: '/recipes',
            name: 'recipes.index',
            component: Recipes
        },{
            path: '/recipe/:slug',
            name: 'recipes.single',
            component: RecipesSingle
        },{
            path: '/categories/',
            name: 'categories',
            component: Categories
        },{
            path: '/category/:slug',
            name: 'category.show',
            component: Category
        },{
            path: '/pantry',
            name: 'pantry',
            component: Pantry
        },{
            path: '/shopping-list',
            name: 'shopping-list',
            component: ShoppingList,
            meta: {
                auth: true
            }
        },{
            path: '/me/settings',
            name: 'me.settings',
            component: Settings,
            meta: {
                auth: true
            }
        },{
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            meta: {
                auth: true
            }
        }, {
            path: '/dashboard/recipes/add',
            name: 'dashboard.recipe.add',
            component: RecipeCreate,
            meta: {
                auth: true
            }
        }, {
            path: '*',
            name: '404',
            component: NotFound
        }
    ]
});

Vue.router = router
App.router = Vue.router

// Vue.component('shopping-list', ShoppingList)
Vue.component('icon', Icon)

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
 });

// make the app
new Vue(App).$mount('#app');