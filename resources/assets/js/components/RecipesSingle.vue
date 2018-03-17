<template>
    <div>
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

        <div v-if="recipe" class="recipe-single">
            <div class="recipe-single__header">
                <div class="breadcrumb">
                    <a href="#">Recipes</a> 
                    <a href="#">Desserts</a>
                </div>

                <h1 class="page-title">{{ recipe.title }}</h1>
            </div>

            <div class="recipe-single-lead">
                <div class="recipe-single-lead__info">
                    <p class="prep-time">
                        <span>{{ recipe.prep_time }}</span> Prep Time
                    </p>
                    <p class="cook-time">
                        <span>{{ recipe.cook_time }}</span> Cook Time
                    </p>

                    <h3>Introduction</h3>
                    <p>{{ recipe.description }}</p>

                    <div class="recipe-single-lead__actions">
                        <a href="#" class="btn"><icon src="/img/zondicons/heart.svg" /></a>
                        <a href="#" class="btn btn--grey"><icon src="/img/zondicons/printer.svg"/></a>
                    </div>
                </div>

                <div class="recipe-single-lead__image">
                    <div class="inner-image">
                        <img src="https://images.unsplash.com/photo-1465014925804-7b9ede58d0d7?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&s=7b65345dde1da9bc81241c54a4f7ce2d" alt="">
                    </div>
                </div>  
            </div>    

            <div class="recipe-single-body">
                <div class="recipe-single-ingredients">
                    <h3>Ingredients</h3>
            
                    <form action="#" class="form">
                        <label class="inline-label">Serves <input type="number" name="qty" v-model="qty" min="1"></label>
                    </form>

                    <ul v-model="ingredients">
                        <li v-for="i in ingredients"><b>{{ i.amount }} {{ i.measurement }}</b> {{ i.title }}</li>
                    </ul>

                    <p><a class="btn" @click.prevent="saveShoppingList()">Add To Shopping List</a></p>                    
                </div>

                <div class="recipe-single-method">
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
                        
                        // this.qty = this.recipe.serves; // set this to servings field
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