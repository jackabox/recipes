<template>
    <main>
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

        <div class="page-header">
            <h1 class="container">{{ recipe.title }}</h1>
        </div>

        <div v-if="recipe" class="container recipe-single">

            <div class="recipe-single__image">
                <div class="inner-image">
                    <img src="https://images.unsplash.com/photo-1465014925804-7b9ede58d0d7?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&s=7b65345dde1da9bc81241c54a4f7ce2d" alt="">
                </div>
            </div>  

            <div class="recipe-single__inner">
                <div class="recipe-single-sidebar">
                    <div class="recipe-single__prep-cook">
                        <p class="prep-time">
                            <span>{{ recipe.prep_time }}</span> Prep Time
                        </p>
                        <p class="cook-time">
                            <span>{{ recipe.cook_time }}</span> Cook Time
                        </p>
                    </div>
                    <h3>Ingredients</h3>
                    <div class="recipe-single__ingredients">
                        <ul>
                            <li v-for="(ingredient, index) in ingredients" :key="index"><b>{{ ingredient.quantity }} {{ ingredient.measurement }}</b> {{ ingredient.title }}</li>
                        </ul>
                    </div>  

                    <div class="recipe-single__servings">
                        <form action="#" class="form">
                            <label>Serves</label>
                            <input type="number" name="qty" v-model="qty" min="1">
                            <button @click.prevent="saveShoppingList()" class="btn">Add To Shopping List</button>
                        </form>                 
                    </div>
                </div>

                <div class="recipe-single-body">
                    <div class="recipe-single__introduction">
                        <h3>Introduction</h3>
                        <p>{{ recipe.description }}</p>
                    </div>

                    <div class="recipe-single__method">
                        <h3>Method</h3>
                        <ol>
                            <li v-for="method in recipe.method" :key="method.id">{{ method }}</li>
                        </ol>
                    </div>

                    <!-- <a href="#" class="btn"><icon src="/img/zondicons/heart.svg" /></a> -->
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        data() {
            return {
                slug: this.$route.params.slug,
                loading: false,
                recipe: null,
                errors: null,
                qty: null,
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
                    .get(route('recipe.single', this.slug))
                    .then(response => {
                        console.log(response)
                        this.loading = false; // loading is done
                        this.recipe = response.data; // set the users from the response
                        this.ingredients = response.data.ingredients;
                        this.oldQty = this.recipe.serves;
                        this.qty = this.recipe.serves;

                        console.log(this.ingredients)
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
                    this.ingredients[i].quantity = this.ingredients[i].quantity / this.oldQty * this.newQty;
                }
            }
        }
    }
</script>