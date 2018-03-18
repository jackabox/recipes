<template>
<div>
    <h1 class="page-title">Search</h1>

    <form action="" class="form form--search">
        <div class="search__box">
            <input type="search" role="search" name="search" placeholder="enter a search term">
            <button type="submit"><icon src="/img/zondicons/search.svg"/></button>
        </div>
    </form>

    <div class="search__results" v-if="results">
        <h2>Search Results</h2>
        <p>Breakfast <span class="tag recipe">Categories</span></p>
        <p>Chocolate Cake <span class="tag recipe">Recipe</span></p>
        <p>Brunch <span class="tag recipe">Categories</span></p>
        <p>Chocolate Heaven Pudding <span class="tag recipe">Recipe</span></p>
        <p>Chocolate Brioche <span class="tag recipe">Recipe</span></p>
        <p>Pudding <span class="tag recipe">Categories</span></p>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            results: true, // []
        };
    },
    created() {
        this.fetchData();
    },
    methods: {

    }
}
</script>