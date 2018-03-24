<template>
<div>
    <div class="page-header">
        <h1 class="container">Search</h1>
    </div>

    <div class="container">
        <form action="#" class="form form--search" @submit.prevent="search">
            <div class="search__box">
                <input type="search" role="search" @keyup.prevent="search"  v-model="term" placeholder="enter a search term">
                <button type="submit"><icon src="/img/zondicons/search.svg"/></button>
            </div>
        </form>

        <div class="search__results" v-if="results">
            <h2>Search Results</h2>
            <p v-for="(result, index) in results" :key="index">
                <router-link v-if="result.type === 'recipe'" :to="{ name: 'recipes.single', params: { slug: result.slug }}">
                    {{ result.title }}
                </router-link>
                <router-link v-else-if="result.type === 'tag'" :to="{ name: 'tag.show', params: { slug: result.slug }}">
                    {{ result.title }}
                </router-link>                    
                <router-link v-else :to="{ name: 'home' }">
                    {{ result.title }}                
                </router-link>
                
                <span :class="'tag ' + result.type">{{ result.type }}</span>
            </p>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            results: false, // []
            term: null
        };
    },
    created() {
        this.search();
    },
    methods: {
        search() {
            let data = {
                term: this.term
            }

            console.log(this.term);

            axios
                .post(route('search'), data)
                .then(response => {
                    this.results = response.data;
                    console.log(response.data);
                });
        }
    }
}
</script>