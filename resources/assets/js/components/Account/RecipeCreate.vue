<template>
    <div>
        <h1 class="page-title">Add Recipe</h1>

        <form @submit.prevent="saveRecipe()" class="form">
        <!-- title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" placeholder="Enter a Title" autofocus v-model="recipe.title">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" v-model="recipe.description"></textarea>
        </div>

        <div class="form-group">
            <label for="title">Cook Time</label>
            <input type="number" class="form-control" v-model="recipe.cook_time">
        </div>

        <div class="form-group">
            <label for="title">Prep Time</label>
            <input type="number" class="form-control" v-model="recipe.prep_time">
        </div>

        <div class="form-group">
            <label for="title">Serves</label>
            <input type="number" class="form-control" v-model="recipe.serves">
        </div>

        <div class="row">
            <!-- Ingredients -->
            <div class="col-md-4">
                <h3>Ingredients</h3>
                <div v-for="ing in recipe.ingredients" readonly>
                    {{ ing.quantity }} {{ ing.measurement }} {{ ing.title }}
                </div>

                <form class="form" @submit.prevent="addIngredient()">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control" placeholder="amount" v-model="ingredient.quantity">
                    </div>

                    <div class="form-group">
                        <label>Measurement</label>
                        <select class="form-control" v-model="ingredient.measurement">
                            <option value="">None</option>
                            <option value="g">Grams</option>
                            <option value="kg">Killograms</option>
                            <option value="oz">Ounce</option>
                            <option value="ml">Millilitre</option>
                            <option value="ml">Centilitre</option>
                            <option value="l">Litre</option>
                            <option value="cups">Cups</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" placeholder="ingredient name" v-model="ingredient.title">
                    </div>

                    <button type="submit" class="btn btn-submit">Add</button>
                </form>
            </div>

            <!-- Steps -->
            <div class="col-md-8">
                <h3>Method</h3>
                <div v-for="m in recipe.method" class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" v-model="m.description"></textarea>
                </div>

                <div>
                    <button type="submit" class="btn btn-submit" @click.prevent="addMethodStep()">Add</button>
                </div>
            </div>
        </div>

        <p><button type="submit" class="btn">Lets Go</button></p>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            recipe: {
                title: '',
                description: '',
                cook_time: '',
                prep_time: '',
                serves: '',
                method: [
                    {
                        description: '',
                    }
                ],
                ingredients: []
            },
            ingredient: {
                quantity: null,
                measurement: '',
                title: ''
            }
        }
    },
    methods: {
        addIngredient() {
            this.recipe.ingredients.push(this.ingredient)

            this.ingredient = {
                quantity: null,
                measurement: '',
                title: ''
            }
        },
        addMethodStep() {
            let methodData = {
                description: ''
            }

            this.recipe.method.push(methodData)
        },
        saveRecipe() {
            console.log('starting save');
            
            axios
                .post('v1/recipes/create', { 
                    title: this.recipe.title, 
                    description: this.recipe.description, 
                    cook_time: this.recipe.cook_time, 
                    prep_time: this.recipe.prep_time, 
                    serves: this.recipe.serves, 
                    method: this.recipe.method, 
                    ingredients: this.recipe.ingredients, 
                }).then(response => {
                    console.log(response.data)
                }).catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

