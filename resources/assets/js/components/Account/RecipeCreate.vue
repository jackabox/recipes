<template>
    <div>
        <h1>Add Recipe</h1>

        <!-- title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" placeholder="Enter a Title" autofocus v-model="recipe.title">
        </div>

        <div class="row">
            <!-- Ingredients -->
            <div class="col-md-4">
                <h4>Ingredients</h4>
                <div v-for="ing in recipe.ingredients" readonly>
                    {{ ing.amount }} {{ ing.measurement }} {{ ing.title }}
                </div>

                <form class="form" @submit.prevent="addIngredient()">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control" placeholder="amount" v-model="ingredient.amount">
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
                <h4>Method</h4>
                <div v-for="m in recipe.method" class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" v-model="m.description"></textarea>
                </div>

                <div>
                    <button type="submit" class="btn btn-submit" @click.prevent="addMethodStep()">Add</button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            recipe: {
                title: '',
                method: [
                    {
                        description: '',
                        order: 1
                    }
                ],
                ingredients: []
            },
            ingredient: {
                amount: null,
                measurement: '',
                title: ''
            }
        }
    },
    methods: {
        addIngredient() {
            this.recipe.ingredients.push(this.ingredient)

            this.ingredient = {
                amount: null,
                measurement: '',
                title: ''
            }
        },
        addMethodStep() {
            let methodData = {
                description: ''
            }

            this.recipe.method.push(methodData)
        }
    }
}
</script>

