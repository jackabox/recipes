<template>
<main>
    <div class="lead-area">
        <div class="container">
            <p class="home home--lead">Mmmm, tasty.</p>
            <p class="home home--sub">Browse or start collecting your perfect recipes for <vue-typer :text="strings"></vue-typer>.</p>
            <p><router-link :to="{ name: 'recipes.index' }" :class="'btn'">Browse Recipes</router-link></p>
        </div>
    </div>

    <div class="top-recipes">
        <div class="container">
            <h3>Top Recipes</h3>
            <div v-if="recipes" class="recipes">
                <recipe-item v-for="recipe in recipes" :key="recipe.id"  :recipe="recipe"></recipe-item>
            </div>
        </div>
    </div>
</main>
</template>

<script>
import RecipeItem from '../components/RecipeItem.vue'
import { VueTyper } from 'vue-typer'

export default {
    components: {
        RecipeItem,
        VueTyper
    },
    data() {
        return {
            recipes: null,
            strings: [
                'an indian fakeaway',
                'a romantic night in',
                'the perfect sunday roast',
                'little fluffy cupcakes'
            ]
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            axios
                .get(route('recipes.top'), {
                    count: 3
                }).then(response => {
                    this.recipes = response.data
                }).catch(error => { });
        }
    }
}
</script>

<style lang="scss" scoped>
.lead-area {
    height: 60vh;
    min-height: 400px;
    position: relative;
    background: url('/img/main-bg.jpg') 50% 0% no-repeat;
    background-size: cover;

    .container {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }
}

.home {
    max-width: 560px;

    &--lead {
        font-size: 5rem;
        font-weight: bold;
        line-height: 1;
    }

    &--sub {
        font-size: 3rem;
        margin-bottom: 20px;
        color:  rgba(36, 33, 54, 0.3);
        font-weight: 400;
    }
}

.top-recipes {
    background-color: rgba(120, 108, 198, 0.04);
    padding: 80px 0;
    margin-bottom: -80px;

    h3 {
        padding-top: 0;
        margin-bottom: 20px;
        text-align: center;
    }
}

</style>
