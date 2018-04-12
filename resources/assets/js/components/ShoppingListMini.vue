<template>
    <router-link :to="{ name: 'shopping-list' }">
        <icon src="/img/zondicons/shopping-cart.svg" />
        <span class="count" v-if="count">{{ count }}</span>   
    </router-link>
</template>

<script>
export default {
    data() {
        return {
            count: null
        };
    },
    created() {
        this.$root.$on('update-shopping-list', this.saveShoppingList)
        this.getShoppingList();
        
    },
    methods: {
        getShoppingList() {
            axios
                .get(route('shopping-list'))
                .then(response => {
                    this.loading = false,
                    this.count = response.data.length
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
        },
        saveShoppingList(data) {
            axios
                .post(route('shopping-list.update'), data)
                .then(response => {
                    this.count = response.data.length
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
        }
    }
}
</script>

<style lang="scss" scoped>
    .count {
        font-size: 1.3rem;
        color: white;
        font-weight: bold;
        background: #5749b8;
        display: inline-block;
        padding: 0 5px;
        margin-left: 6px;
        width: 24px;
        height: 24px;
        line-height: 24px;
        border-radius: 100%;
    }
</style>