<template>
    <div class="users">
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

        <div v-if="recipes">
            <div v-for="recipe in recipes">
                <h1>{{ recipe.name }}</h1>
                <p>{{ recipe.description }}</p>
                <p>
                    <b>Cook Time:</b> {{ recipe.cook_time }}min | 
                    <b>Prep Time:</b> {{ recipe.prep_time }}min
                </p>

                <div class="ingredients">
                    <h3>Ingredients</h3>
                    <ul>
                        <li v-for="i in recipe.ingredients"><b>{{ i.amount }}</b> {{ i.name }}</li>
                    </ul>
                </div>

                <div class="method">
                    <h3>Method</h3>
                    <ol>
                        <li v-for="method in recipe.method">{{ method }}</li>
                    </ol>
                </div>
                <router-link :to="{ name: 'recipes.single', params: { slug: recipe.slug }}">View Item</router-link>
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