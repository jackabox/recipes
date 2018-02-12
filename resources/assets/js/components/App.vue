<template>
    <div class="container">
        <h1>Recipes</h1>
        <p>
            <router-link :to="{ name: 'home' }">Home</router-link>
            <router-link :to="{ name: 'recipes.index' }">Recipes</router-link>
        </p>

        <router-view></router-view>
    </div>
</template>

<script>
    export default {}
</script>