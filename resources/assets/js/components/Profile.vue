<template>
    <main>
        <div class="page-header">
            <div class="container profile-banner">
                <div class="profile-image">
                    <img :src="user.profile_pic" alt="">
                </div>

                <h1>{{ user.name }}</h1>
                <p v-if="profile.description">{{ profile.description }}</p>
            </div>
        </div>
        
        <div class="container">
            <div class="loading" v-if="loading">
                loading...
            </div>

            <h3>User Recipes</h3>
            <div v-if="recipes" class="recipes">
                <recipe-item v-for="recipe in recipes" :key="recipe.id"  :recipe="recipe"></recipe-item>
            </div>
            <div v-else>
                No recipes
            </div>
        </div>
    </main>
</template>

<script>
import RecipeItem from '../components/RecipeItem.vue'

export default {
    components: {
        'recipe-item': RecipeItem,
    },
    data() {
        return {
            slug: this.$route.params.slug,
            user: [],
            profile: [],
            recipes: [],
            loading: false,
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.loading = true;

            axios
                .get(route('profile', this.slug))
                .then(response => {
                    this.loading = false;
                    this.user = response.data.user;
                    this.profile = response.data.profile;
                    this.recipes = response.data.recipes;
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../../sass/variables';

.profile-banner {
    position: relative;
    padding-left: 180px;
}

.profile-image {
    position: absolute;
    width: 160px;
    height: 160px;
    left: 0;
    top: 40px;

    img {
        border-radius: 100%;
    }
}

h3 {
    text-align: center;
    margin-bottom: 20px;
}
</style>
