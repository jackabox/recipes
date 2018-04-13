<template>
<div class="app">
    <header class="site-header" v-bind:class="scrollTop">
        <div class="container">
            <h1><router-link @click.native="menuopen = false" :to="{ name: 'home' }"><img src="/img/logo.svg"></router-link></h1>

            <input id="burger" type="checkbox" v-model="menuopen">

            <label for="burger">
                <span></span>
                <span></span>
                <span></span>
            </label>

            <nav class="site-navigation">
                <ul>
                    <li><router-link @click.native="menuopen = false" :to="{ name: 'recipes.index' }">Recipes</router-link></li>
                    <li><router-link @click.native="menuopen = false" :to="{ name: 'categories' }">Categories</router-link></li>                   
                    <li><router-link @click.native="menuopen = false" :to="{ name: 'pantry' }">Pantry</router-link></li>
                    <li class="divider"></li>                    
                    <li><router-link @click.native="menuopen = false" :to="{ name: 'search' }">
                        <icon src="/img/zondicons/search.svg" />
                        <span class="icon-text">Search</span>
                        
                    </router-link></li>

                    <li class="divider"></li>                    
                    <li v-if="$auth.check()">
                        <shopping-list-mini @click.native="menuopen = false" />
                    </li>

                    <li class="divider" v-if="$auth.check()"></li>
                    <li class="account" v-if="$auth.check()">
                        <router-link :to="{ name: 'profile', params: { slug: $auth.user().username }}" @click.native="menuopen = false"><img class="profile-pic" :src="$auth.user().profile_pic" alt=""> Jack <icon src="/img/zondicons/cheveron-down.svg" class="chevron" /></router-link>
                        <ul>
                            <li><router-link @click.native="menuopen = false"  :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                            <li><a @click.native="menuopen = false" href="#" @click.prevent="$auth.logout()">Logout</a></li>
                        </ul>
                    </li>
                    <li v-if="!$auth.check()">
                        <router-link @click.native="menuopen = false" :to="{ name: 'login' }">Login</router-link>
                    </li>
                </ul>      
            </nav>
        </div>
    </header>

    <router-view></router-view>

    <notifications position="70px center" width="100%" classes="my-notification" />

    <footer class="footer">
        <div class="container">
            <p class="footer__copy">
                <b><a href="https://madebylune.co">Made By Lune</a>.</b><br>
                &copy; Copyright 2018+. All rights reserved.
            </p>
            <p class="footer__links">
                <span v-if="!$auth.check()">
                    <router-link :to="{ name: 'login' }">Login</router-link>
                </span>
                <span v-if="$auth.check()">
                    <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
                </span>
                •
                Privacy Policy
                • 
                Terms of Use
            </p>
           
        </div>
    </footer>
</div>
</template>

<script>
export default {
    data () {
        return {
            scrolled: false,
            menuopen: false
        }
    },
    created () {
        window.addEventListener('scroll', this.handleScroll);
    },
    destroyed () {
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        handleScroll () {
            let el = this.$el.getElementsByClassName('site-header')[0]                
            this.scrolled = window.scrollY;
        }
    },
    computed: {
        scrollTop() {
            if (this.scrolled >= 80) {
                return 'fixed'
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.chevron {
    color: rgba(0,0,0,.5);
    margin-top: -2px;
}

h1 {
    z-index: 10;
    margin-left: 15px;
    margin-top: 0;
}
</style>
