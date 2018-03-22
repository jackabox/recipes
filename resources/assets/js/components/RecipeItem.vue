<template>
<div class="recipes__item">
    <router-link :to="{ name: 'recipes.single', params: { slug: this.recipe.slug }}">
        <div class="recipes__img">
            <img src="/img/example-image.jpg" alt="">
        </div>
        <div class="recipes__desc">
            <h3>{{ this.recipe.title }}</h3>
            <p><em>by</em> <a href="#">Jack Whiting</a></p>
        </div>
        <div class="recipes__meta">
            <icon src="/img/zondicons/time.svg"></icon> {{ this.recipe.prep_time + this.recipe.cook_time }} mins
        </div>
    </router-link>
</div>
</template>

<script>
    export default {
        props: ['recipe'],

        created() {

        }
    }
</script>