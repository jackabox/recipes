require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

// set up to use router
Vue.use(VueRouter)

// components to utilise
import App from './components/App'
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
            path: '/recipes',
            name: 'recipes.index',
            component: Recipes
        }, {
            path: '/recipes/:id',
            name: 'recipes.single',
            component: RecipesSingle
        }, {
            path: '*',
            name: '404',
            component: NotFound
        }
    ]
});

// make the app
const app = new Vue({
    el: '#app',
    components: { App },
    router
});
