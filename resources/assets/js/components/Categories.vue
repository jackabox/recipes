<template>
<main>
    <div class="page-header">
        <h1 class="container">Categories</h1>
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

        <div v-if="categories" class="categories">
            <div v-for="category in categories" class="category" :key="category.id">
                <router-link :to="{ name: 'category.show', params: { slug: category.slug }}">
                    <img v-if="category.picture" :src="category.picture" :alt="category.title">
                    <img v-else src="/img/example-image.jpg" alt="">
                    <div class="overlay"></div>
                    <h3>{{ category.title }}</h3>
                </router-link>
            </div>
        </div>
        
        <pagination :meta="meta"></pagination>  
    </div>
</main>
</template>

<script>
    import axios from 'axios';
    import Pagination from '../components/Utilities/Pagination.vue'
    
    export default {
        components: {
            Pagination
        },
        data() {
            return {
                slug: this.$route.params.slug,
                loading: false,
                categories: null,
                errors: null,
                meta: null,
                page: 1                
            };
        },
        created() {
            this.$on('paginate', this.updatePage)                                    
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.users = null;
                this.loading = true;
                
                axios
                    .get('v1/category?page=' + this.page)
                    .then(response => {
                        this.loading = false; // loading is done
                        this.categories = response.data.data;
                        this.meta = response.data.meta                        
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

<style lang="scss" scoped>
@import '../../sass/variables';

.categories {
    @media (min-width: 560px) {
        display: grid;
        grid-gap: 25px;
        grid-template-columns: repeat(auto-fill, minmax(calc(50% - 13px), 1fr));
        grid-auto-rows: minmax(120px, auto);
        grid-auto-flow: dense;
    }
}

.category {
    box-shadow: $box-shadow;
    position: relative;
    font-size: 0;
    margin-bottom: 25px;
    transition: .3s all ease-in-out;
    
    @media (min-width: 560px) {
        margin-bottom: 0;
    }


    &:hover,
    &:focus {
       box-shadow: $box-shadow-hover;
    }

    h3 {
        position: absolute;
        bottom: 20px;
        left: 20px;
        color: white;
        padding: 0;
        font-size: 3rem;
        text-shadow: 0px 1px 3px rgba(0, 0, 0, 0.25);
        z-index: 12;
    }
}

.overlay {
    background: rgba(0,0,0,0.2);
    top: 0; 
    left: 0;
    right: 0;
    bottom: 0;
    position: absolute;
    z-index: 10;
}
</style>
