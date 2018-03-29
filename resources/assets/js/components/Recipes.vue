<template>
<main>
    <div class="page-header">
        <h1 class="container">All Recipes</h1>
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

        <ul class="pagination">
            <li v-for="(page, index) in pageCount" :class="['page-item', {'active': page == pagination.current_page}]" :key="index">
                <a href="#" class="page-link" @click.prevent="changePage(page)">
                    {{ page }}
                </a>
            </li>
        </ul>

        <div class="pagination" v-show="showPagination">
            <button :disabled="! olderResults" @click.prevent="goToPage('prev')">Prev</button>
            {{ paginationCount }}
            <button :disabled="! newerResults" @click.prevent="goToPage('next')">Next</button>
        </div>
    </div>
</main>
</template>

<script>
    import RecipeItem from '../components/RecipeItem.vue'
    
    export default {
        components: {
            'recipe-item': RecipeItem
        },
        data() {
            return {
                loading: false,
                recipes: null,
                errors: null,  
                page: 1,
                meta: null,
            };
        },
        created() {
            this.fetchData();
        },
        computed: {
            newerResults() {
                if (! this.meta || this.meta.current_page === this.meta.last_page) {
                    return;
                }

                return this.meta.current_page + 1;
            },
            olderResults() {
                if (! this.meta || this.meta.current_page === 1) {
                    return;
                }

                return this.meta.current_page - 1;
            },
            showPagination() {
                if (! this.meta || this.meta.total <= this.meta.per_page) {
                    return;
                }

                return true;
            },
            paginationCount() {
                if (! this.meta) {
                    return;
                }

                const { current_page, last_page } = this.meta;

                return `${current_page} of ${last_page}`;
            },
        },
        methods: {
            fetchData() {            
                this.error = this.users = null;
                this.loading = true;
                axios
                    .get('v1/recipes?page=' + this.page)
                    .then(response => {
                        this.loading = false; // loading is done
                        this.recipes = response.data.data; // set the users from the response
                        this.meta = response.data.meta
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            },
            goToPage(type) {
                if (type === 'next') {
                    this.page = this.page + 1;
                } else {
                    this.page = this.page - 1;
                }

                window.scrollTo(0, 0);
                this.fetchData();
            },
        }
    }
</script>