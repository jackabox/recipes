<template>
<div>
    <header class="site-header">
        <div class="container">
            <h1><img src="/img/logo.svg"></h1>

            <div class="site-header__search">
                <form action="" class="form form--search">
                    <input type="search" placeholder="enter a recipe name">
                    <button type="submit"><icon src="/img/zondicons/search.svg" /></button>
                </form>
            </div>

            <nav class="site-navigation">
                <ul>
                    <li><a href="#"><icon src="/img/zondicons/shopping-cart.svg" /></a></li>
                    <li><router-link :to="{ name: 'recipes.index' }">Recipes</router-link></li>
                    <li v-if="$auth.check()">
                        <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
                    </li>
                    <li v-if="!$auth.check()">
                        <router-link :to="{ name: 'login' }">Login</router-link>
                    </li>
                    <li v-if="$auth.check()">
                        <a href="#" @click.prevent="$auth.logout()">Logout</a>
                    </li>
                </ul>

                <shopping-list v-if="$auth.check()"></shopping-list>                        
            </nav>
        </div>
    </header>

    <div class="container">    

        <router-view></router-view>
    </div>
</div>
</template>

<script>
    export default {
        created() {
            // this.$auth.fetch({url: '/api/user', method: 'get'});
        },
    }
</script>