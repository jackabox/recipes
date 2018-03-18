<template>
    <div>
        <h1 class="page-title">All Recipes</h1>

        <div class="loading" v-if="loading">
            loading...
        </div>

        <div class="error" v-if="error">
            {{ error }}

            <p>
                <button @click.prevent="fetchData">
                    Try Again
                </button>
            </p>
        </div>

        <div v-if="recipes" class="recipes">
            <div v-for="recipe in recipes" class="recipes__item" :key="recipe.id">
                <router-link :to="{ name: 'recipes.single', params: { slug: recipe.slug }}">
                    <div class="recipes__img"><img src="https://source.unsplash.com/400x280/?food" alt=""></div>
                    <h3>{{ recipe.title }}</h3>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    
    export default {
        data() {
            return {
                loading: false,
                recipes: null,
                errors: null,
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.users = null;
                this.loading = true;
                axios
                    .get('v1/recipes')
                    .then(response => {
                        console.log(response.data);

                        this.loading = false; // loading is done
                        this.recipes = response.data.data; // set the users from the response
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            }
        }
    }
</script>