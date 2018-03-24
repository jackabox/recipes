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
            <li v-for="item in list" :key="item.index">
                <b>{{ item.qty }}{{ item.measurement }}</b> {{ item.ingredient }}

                <div class="actions">
                    <icon src="/img/zondicons/checkmark.svg" class="actions__tick" @click="changeIngredientStatus(item)" />
                    <icon src="/img/zondicons/close.svg" class="actions__cross" @click="removeIngredient(item)" />
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
        changeIngredientStatus(data) {
            console.log('ok')
        },
        removeIngredient(data) {
            console.log('ok')
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
            
            &.checked {
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