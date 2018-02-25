<template>
    <div class="users">
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

        <div v-if="recipe">
            <div>
                <h1>{{ recipe.name }}</h1>
                <p>{{ recipe.description }}</p>
                <p>
                    <b>Cook Time:</b> {{ recipe.cook_time }}min | 
                    <b>Prep Time:</b> {{ recipe.prep_time }}min
                </p>

                <div class="ingredients">
                    <h3>Ingredients</h3>
            
                    <input type="number" name="qty" v-model.lazy="qty" min="1">
                    <button @click.prevent="saveShoppingList()">Save To Shopping List</button>
                    
                    <ul v-model="ingredients">
                        <li v-for="i in ingredients"><b>{{ i.amount }}</b> {{ i.type }}</li>
                    </ul>
                </div>

                <div class="method">
                    <h3>Method</h3>
                    <ol>
                        <li v-for="method in recipe.method">{{ method }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    
    export default {
        data() {
            return {
                loading: false,
                recipe: null,
                errors: null,
                qty: 1,
                ingredients: {}
            };
        },
        created() {
            this.fetchData();
            this.getShoppingList();
        },
        methods: {
            getShoppingList() {
                axios
                    .get('shopping-list')
                    .then(response => {
                       console.log(response.data);
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            },
            fetchData() {
                this.error = this.users = null;
                this.loading = true;
                axios
                    .get('recipe/${id}')
                    .then(response => {
                        this.loading = false; // loading is done
                        this.recipe = response.data; // set the users from the response
                        this.ingredients = response.data.ingredients;
                        this.qty = this.recipe.id; // set this to servings field
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            },
            updateIngredientsList(newQty) {
                axios
                    .get('recipe/' + this.recipe.id + '/ingredients', {
                        qty: newQty
                    }).then(response => {
                        this.ingredients = response.data;
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            },
            saveShoppingList() {
                axios
                    .post('shopping-list/update', {
                        ingredients: this.ingredients,
                        recipe_id: this.recipe.id
                    }).then(response => {
                        console.log(response)
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });

            }
        },
        watch: {
            qty(newQty, oldQty) {
                this.updateIngredientsList(newQty);
            }
        }
    }
</script>