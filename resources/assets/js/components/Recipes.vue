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
            <recipe-item v-for="recipe in recipes" :key="recipe.id"  :recipe="recipe"></recipe-item>
        </div>
    </div>
</template>

<script>
    import RecipeItem from '../components/RecipeItem.vue'
    
    export default {
        components: {
            'recipe-item': RecipeItem,
        },
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