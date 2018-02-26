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
            
                    <input type="number" name="qty" v-model="qty" min="1">

                    <button @click.prevent="saveShoppingList()">Save To Shopping List</button>
                    
                    <ul v-model="ingredients">
                        <li v-for="i in ingredients"><b>{{ i.amount }}{{ i.measurement }}</b> {{ i.name }}</li>
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
    export default {
        data() {
            return {
                slug: this.$route.params.id,
                loading: false,
                recipe: null,
                errors: null,
                qty: 1,
                newQty: 1,
                oldQty: 1,
                ingredients: {}
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.users = null;
                this.loading = true;
                axios
                    .get('v1/recipes/' + this.slug)
                    .then(response => {
                        console.log(response)
                        this.loading = false; // loading is done
                        this.recipe = response.data; // set the users from the response
                        this.ingredients = response.data.ingredients;
                        this.qty = this.recipe.id; // set this to servings field
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            },
            saveShoppingList() {
                let data = {
                    ingredients: this.ingredients,
                    recipe_id: this.recipe.id
                }

                this.$root.$emit('update-shopping-list', data)
            }
        },
        watch: {
            qty(newQty, oldQty) {
                if (newQty) {
                    this.newQty = newQty;
                }

                if (oldQty) {
                    this.oldQty = oldQty;
                }

                for(var i = 0; i <= this.ingredients.length; i++){
                    this.ingredients[i].amount = this.ingredients[i].amount / this.oldQty * this.newQty;
                }
            }
        }
    }
</script>