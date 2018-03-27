<template>
    <main>
        <div class="page-header">
            <h1 class="container">Account</h1>
        </div>
        
        <div class="container">
            <div class="loading" v-if="loading">
                loading...
            </div>
        </div>
    </main>
</template>

<script>
export default {
    data() {
        return {
            slug: this.$route.params.slug,
            profile: [],
            loading: false,
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.loading = true;

            axios
                .get(route('profile', this.slug))
                .then(response => {
                    this.loading = false;
                    this.profile = response.data;
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../../sass/variables';

</style>
