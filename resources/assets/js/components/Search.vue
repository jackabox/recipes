<template>
<div>
    <h1 class="page-title">Search</h1>

    <form action="" class="form form--search" >
        <div class="search__box">
            <input type="search" role="search" @keyup.prevent="search"  v-model="term" placeholder="enter a search term">
            <button type="submit"><icon src="/img/zondicons/search.svg"/></button>
        </div>
    </form>

    <div class="search__results" v-if="results">
        <h2>Search Results</h2>
        <p v-for="result in results">
            {{ result.title }}

            <span :class="'tag ' + result.type">{{ result.type }}</span>
        </p>
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
        // this.fetchData();
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