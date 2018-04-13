<template>
<main>
    <div class="page-header">
        <h1 class="container">Ingredient: {{ meta.ingredient }}</h1>
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

        <pagination :meta="meta"></pagination>
        
    </div>
</main>
</template>

<script>
    import RecipeItem from '../components/RecipeItem.vue'
    import Pagination from '../components/Utilities/Pagination.vue'
    
    export default {
        components: {
            RecipeItem,
            Pagination            
        },
        data() {
            return {
                slug: this.$route.params.slug,
                loading: false,
                recipes: null,
                errors: null,
                meta: null,
                page: 1
            };
        },
        
        created() {
            this.fetchData();
            this.$on('paginate', this.updatePage)            
        },
        methods: {
            fetchData() {
                this.error = this.users = null;
                this.loading = true;
                
                axios
                    .get(route('ingredients.show', { ingredient: this.slug, page: this.page}))
                    .then(response => {
                        console.log(response.data);
                        this.loading = false; // loading is done
                        this.meta = response.data.meta                        
                        this.recipes = response.data.data; // set the users from the response
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            },
            updatePage(data) {
                this.page = data;
                this.fetchData();
            }
        }
    }
</script>