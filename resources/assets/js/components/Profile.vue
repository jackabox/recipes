<template>
    <main>
        <div class="page-header">
            <div class="container profile-banner">
                <div class="profile-image">
                    <img :src="user.profile_pic" alt="">
                </div>

                <h2>{{ user.name }}</h2>
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
    text-align: center;
    padding-top: 130px;

    @media (min-width: 600px) {
        padding-left: 160px;
        padding-top: 0;
        text-align: left;
    }

    @media (min-width: 768px) {
        padding-left: 190px;
    }

    p {
        padding: 0;
    }

}

.profile-image {
    position: absolute;        
    width: 140px;
    height: 140px;
    left: 50%;
    margin-left: -70px;
    top: 10px;

    @media (min-width: 600px) {
        left: 15px;
        margin-left: 0;
    }

    @media (min-width: 768px) {
        width: 160px;
        height: 160px;
    }    

    img {
        border-radius: 100%;
    }
}

h2 {
    // padding-top: 0;
    padding-bottom: 10px;
}


h3 {
    text-align: center;
    margin-bottom: 20px;
}
</style>
