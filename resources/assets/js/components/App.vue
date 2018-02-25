<template>
    <div class="container">
        <h1>Recipes</h1>
        <nav>
            <ul class="list-inline">
                <li><router-link :to="{ name: 'home' }">Home</router-link></li>
                <li><router-link :to="{ name: 'recipes.index' }">Recipes</router-link></li>
                <li v-if="!$auth.check()" class="pull-right">
                            <router-link :to="{ name: 'login' }">Login</router-link>
                </li>
                <li v-if="!$auth.check()" class="pull-right">
                    <router-link :to="{ name: 'register' }">Register</router-link>
                </li>
                <li v-if="$auth.check()" class="pull-right">
                    <a href="#" @click.prevent="$auth.logout()">Logout</a>
                </li>
            </ul>
        </nav>

        <router-view></router-view>
    </div>
</template>

<script>
    export default {}
</script>