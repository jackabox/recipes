<template>
    <div class="shopping-list">
        <h5>Shopping List</h5>
        <div class="loading" v-if="loading">
            loading...
        </div>

        <ul>
            <li v-for="item in list">{{ item.qty }}{{ item.measurement }} {{ item.ingredient }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: true,
            list: null
        };
    },
    created() {
        console.log('mounted');

        this.$root.$on('update-shopping-list', this.saveShoppingList)

        this.getShoppingList();
    },
    methods: {
        getShoppingList() {
            axios
                .get(route('shopping-list'))
                .then(response => {
                    this.loading = false,
                    this.list = response.data
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
        },
        saveShoppingList(data) {
            axios
                .post(route('shopping-list.update'), data)
                .then(response => {
                    console.log(response)
                    this.list = response.data
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });

        }
    }
}
</script>

