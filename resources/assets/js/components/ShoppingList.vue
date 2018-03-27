<template>
<main>
    <div class="page-header">
        <h1 class="container">Shopping List</h1>
    </div>

    <div class="container">
        <div class="loading" v-if="loading">
            loading...
        </div>

        <ul class="shopping-list">
            <li v-for="(item, index) in list" :key="index" v-bind:class="isBought(item)">
                <b>{{ item.qty }}{{ item.measurement }}</b> {{ item.ingredient }}
                
                <div class="actions">
                    <a href="#" @click="changeIngredientStatus(item, index)"><icon src="/img/zondicons/checkmark.svg" class="actions__tick" /></a>

                    <a href="#" @click="removeIngredient(item, index)" ><icon src="/img/zondicons/close.svg" class="actions__cross" /></a>
                </div>
            </li>
        </ul>
    </div>
</main>
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
        },
        changeIngredientStatus(data, index) {
            let status = (data.bought === 1 ? 0 : 1)

            let params = {
                status: status,
                ingredient: data.ingredient
            }

            axios
                .patch(route('shopping-list.item.update'), params)
                .then(response => {
                    console.log(response)
                    this.list[index].bought = status;
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
        },
        isBought(item) {
            return (item.bought === 1 ? 'bought' : '')
        },
        removeIngredient(data, index) {
            // @todo: add a confirmation here
            axios
                .delete(route('shopping-list.item.delete'), {data})
                .then(response => {
                    console.log(response.data)
                    this.list.splice(index, 1)
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
        }
    }
}
</script>


<style lang="scss" scoped>
    .shopping-list {
        list-style: none;
        margin: 0;
        padding: 0;

        li {
            border-bottom: 1px solid hsla(0,0,0,0.04);
            font-size: 1.8rem;
            padding: 1.2rem 0;
            position: relative;
            transition: .2s all ease-in-out;
            
            &.bought {
                text-decoration: line-through;
            }
        }

        .actions {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);

            .icon {
                margin-left: 20px;
                width: 18px;
                transition: .3s all ease-in-out;
                fill: hsla(0,0,0,0.3);
                cursor: pointer;
            }

            &__tick:hover {
                fill: #6FCF97;
            }

            &__cross:hover {
                fill: #CC5353;
            }
        }
    }
</style>