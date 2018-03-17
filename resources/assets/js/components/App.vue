<template>
<div>
    <header class="site-header">
        <div class="container">
            <h1><router-link :to="{ name: 'home' }"><img src="/img/logo.svg"></router-link></h1>

            <nav class="site-navigation">
                <ul>
                    <li><router-link :to="{ name: 'recipes.index' }">Recipes</router-link></li>
                    <li><a href="#">Pantry</a></li>
                    <li class="divider"></li>                    
                    <li><a href="#"><icon src="/img/zondicons/search.svg" /></a>
                    <li class="divider"></li>                    
                    <li><a href="#"><icon src="/img/zondicons/shopping-cart.svg" /></a></li>
                    <li class="divider"></li>
                    <li class="account" v-if="$auth.check()">
                        <img class="profile-pic" src="https://placehold.it/40" alt="">
                        <a href="#">Jack</a>
                        <ul>
                            <li><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                            <li><a href="#" @click.prevent="$auth.logout()">Logout</a></li>
                        </ul>
                    </li>
                    <li v-if="!$auth.check()">
                        <router-link :to="{ name: 'login' }">Login</router-link>
                    </li>
                </ul>

                <shopping-list v-if="$auth.check()"></shopping-list>                        
            </nav>
        </div>
    </header>

    <div class="container">    

        <router-view></router-view>
    </div>

    <footer>
        <div class="container">
            &copy; Made By Lune
        </div>
    </footer>
</div>
</template>

<script>
    export default {
        created() {
            // this.$auth.fetch({url: '/api/user', method: 'get'});
        },
    }
</script>