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
                    <img v-if="recipe.media_url" :src="recipe.media_url" :alt="recipe.title">
                    <img v-else src="/img/example-image.jpg" alt="">
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

                    <div class="recipe-single__servings">
                        <form action="#" class="form">
                            <label>Serves</label>
                            <input type="number" name="qty" v-model="qty" min="1">
                            <button @click.prevent="saveShoppingList()" class="btn" v-if="$auth.check()">Add To Shopping List</button>
                        </form>                 
                    </div>
                    
                    <h3>Ingredients</h3>
                    <div class="recipe-single__ingredients">
                        <ul>
                            <li v-for="(ingredient, index) in ingredients" :key="index"><b>{{ ingredient.quantity }} {{ ingredient.measurement }}</b> {{ ingredient.title }}</li>
                        </ul>
                    </div>  

                    
                </div>

                <div class="recipe-single-body">
                    <div class="recipe-single__introduction">
                        <h3>Introduction</h3>
                        <p>{{ recipe.description }}</p>
                    </div>

                    <div class="recipe-single__method">
                        <h3>Method</h3>
                        <ol class="method-list">
                            <li v-for="(method, index) in steps" :key="index" v-bind:class="methodIsDone(method)" @click="markMethodDone(method, index)">{{ method.description }}</li>
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
                steps: {},
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
                        this.steps = response.data.method;
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
            },
            methodIsDone(method) {
                return (method.status === 'done' ? 'done' : '')
            },
            markMethodDone(method, index) {
                this.steps[index].status = (method.status === '' ? 'done' : '');
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

<style lang="scss" scoped>
.method-list li {
    transition: all 0.2s ease;

    &:hover {
        cursor: pointer;
    }

    &:before {
        content: "\2713";
        font-size: 13px;
        color: #e0e0e0;
        transition: all 0.2s ease;
        position: absolute;
        text-align: center;
        display: block;
        left: -40px;
        top: 6px;
        width: 20px;
        height: 20px;
        background: #e0e0e0;
        border-radius: 4px;
    }
    
    &.done {
        text-decoration: line-through;

        &:before {
            color: #fff;
            background-color: #796EC6;
        }
    }
}
</style>
