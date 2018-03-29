<template>
<div class="recipes__item">
    <router-link :to="{ name: 'recipes.single', params: { slug: this.recipe.slug }}">
        <div class="recipes__img">
            <img v-if="recipe.media_url" :src="recipe.media_url" :alt="recipe.title">
            <img v-else src="/img/example-image.jpg" alt="">
        </div>
        <div class="recipes__desc">
            <h3>{{ this.recipe.title }}</h3>
           
        </div>
        <div class="recipes__meta">
            <icon src="/img/zondicons/time.svg"></icon> {{ this.recipe.prep_time + this.recipe.cook_time }} mins

            <span v-if="this.recipe.user"><em>by</em> <router-link :to="{ name: 'profile', params: { slug: this.recipe.user.username }}">{{ this.recipe.user.username }}</router-link></span>
        </div>
    </router-link>
</div>
</template>

<script>
export default {
    props: ['recipe'],
    data() {
        return {
            loading: true
        };
    }
}
</script>

<style lang="scss" scoped>
.recipes__desc {
    margin-bottom: 10px;
}
.recipes__meta {
    span {
        margin-left: 20px;
    }

    .icon {
        margin-left: 0;
    }
}
</style>
