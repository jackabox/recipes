<template>
<main>
    <div class="page-header">
        <h1 class="container">Category: {{ category }}</h1>
    </div>

    <div class="container">
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
            RecipeItem,
        },
        data() {
            return {
                slug: this.$route.params.slug,
                loading: false,
                recipes: null,
                errors: null,
                category: null
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
                    .get(route('category.show', this.slug))
                    .then(response => {
                        console.log(response.data);

                        this.loading = false; // loading is done
                        this.category = response.data.name;
                        this.recipes = response.data.recipes.data; // set the users from the response
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            }
        }
    }
</script>