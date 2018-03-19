<template>
    <div>
        <h1 class="page-title">Categories</h1>

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

        <div v-if="categories" class="recipes">
            <div v-for="category in categories" class="recipes__item" :key="category.id">
                <router-link :to="{ name: 'category.show', params: { slug: category.slug }}">
                    <h3>{{ category.title }}</h3>
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
                slug: this.$route.params.slug,
                loading: false,
                categories: null,
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
                    .get(route('category'))
                    .then(response => {
                        console.log(response.data);

                        this.loading = false; // loading is done
                        this.categories = response.data;
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            }
        }
    }
</script>