<template>
    <main>
        <div class="page-header">
            <h1 class="container">Add Recipe</h1>
        </div>

        <form @submit.prevent="saveRecipe()" class="form container">
        <!-- title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" placeholder="Enter a Title" autofocus v-model="recipe.title" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" v-model="recipe.description"></textarea>
        </div>

        <div class="mini-fields">
            <div class="form-group">
                <label for="title">Cook Time</label>
                <input type="number" class="form-control" required v-model="recipe.cook_time">
            </div>

            <div class="form-group">
                <label for="title">Prep Time</label>
                <input type="number" class="form-control" required v-model="recipe.prep_time">
            </div>

            <div class="form-group">
                <label for="title">Serves</label>
                <input type="number" class="form-control" required v-model="recipe.serves">
            </div>
        </div>

        <div class="details">
            <!-- Ingredients -->
    
            <h3>Ingredients</h3>
            <div class="ingredients" v-if="recipe.ingredients.length > 0">
                <div class="ingredients__item" v-for="(ing, index) in recipe.ingredients" :key="index" readonly>
                    <b>{{ ing.quantity }}{{ ing.measurement }}</b> {{ ing.title }} <span>remove</span>
                </div>
            </div>

            <form class="form ingredients-add" @submit.prevent="addIngredient()">
                <div class="form-group quantity">
                    <label>Quantity</label>
                    <input type="number" required class="form-control" placeholder="amount" v-model="ingredient.quantity">
                </div>

                <div class="form-group measurement">
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

                <div class="form-group ingredient">
                    <label>Name</label>
                    <input class="form-control" type="text" placeholder="ingredient name" v-model="ingredient.title" required>
                </div>

                <button type="submit" class="btn btn-submit">Add</button>
            </form>
        </div>

        <!-- Steps -->
        <div class="method">
            <h3>Method</h3>
            <draggable :list="recipe.method" class="dragArea">
                <div v-for="(m, index) in recipe.method" :key="index" class="form-group">
                    <label>Step {{ index + 1 }}</label>
                    <textarea class="form-control" v-model="m.description"></textarea>
                </div>
            </draggable>

            <div>
                <button type="submit" class="btn btn-submit" @click.prevent="addMethodStep()">Add Step</button>
            </div>
        </div>

        <p>All done? Click the save button below to add your recipe and await modification.</p>
        <p><button type="submit" class="btn">Save Recipe</button></p>
        </form>
    </main>
</template>

<script>
import draggable from 'vuedraggable'

export default {
    components: {
        draggable
    },
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

<style lang="scss" scoped>
.mini-fields {
    display: flex;
    justify-content: space-between;

    .form-group {
        width: 32%;
    }
}

.ingredients {
    padding: 15px;    
    background: #F3F2F7;
    margin-top: 10px;
    margin-bottom: 10px;    

    span {
        float: right;
    }

    &__item {
        margin-bottom: 10px;
    }
}

.ingredients-add {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;

    .btn {
        width: 120px;
    }

    .form-group {
        width: calc((96% - 120px) / 3);
        margin-bottom: 0;
    }
}

.method {
    margin-bottom: 20px;
}
</style>

