<template>
<div>
    <header class="site-header" v-bind:class="scrollTop">
        <div class="container">
            <h1><router-link :to="{ name: 'home' }"><img src="/img/logo.svg"></router-link></h1>

            <nav class="site-navigation">
                <ul>
                    <li><router-link :to="{ name: 'recipes.index' }">Recipes</router-link></li>
                    <li><router-link :to="{ name: 'categories' }">Categories</router-link></li>                   
                    <li><router-link :to="{ name: 'pantry' }">Pantry</router-link></li>
                    <li class="divider" v-if="$auth.check()"></li>                    
                    <li v-if="$auth.check()"><router-link :to="{ name: 'search' }"><icon src="/img/zondicons/search.svg" /></router-link></li>
                    <li class="divider" v-if="$auth.check()"></li>                    
                    <li v-if="$auth.check()"><a href="#"><icon src="/img/zondicons/shopping-cart.svg" /></a></li>
                    <li class="divider" v-if="$auth.check()"></li>
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

    <footer class="footer">
        <!-- <div class="footer container">
            <div class="footer-col">
                Recipes
            </div>
        </div> -->
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
        <p class="footer__copy">&copy; 2018 Recipes.<br>
            Site <a href="https://madebylune.co">Made By Lune</a>.</p>
    </footer>
</div>
</template>

<script>
    export default {
        data () {
            return {
                scrolled: false
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
        },
    }
</script>