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

        <div class="form-group">

            <h2>Select an image</h2>
            <input type="file" @change="previewImage" accept="image/*">

            <div class="image-preview" v-if="imageData.length > 0">
                <img class="preview" :src="imageData">
            </div>
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
            imageData: '',
            recipe: {
                image: '',
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

            var form = new FormData();
            form.append('image', this.recipe.image)
            form.append('title', this.recipe.title)
            form.append('description', this.recipe.description)
            form.append('cook_time', this.recipe.cook_time)
            form.append('prep_time', this.recipe.prep_time)
            form.append('serves', this.recipe.serves)
            form.append('method', JSON.stringify(this.recipe.method))
            form.append('ingredients', JSON.stringify(this.recipe.ingredients))

            axios
                .post('v1/recipes/create', form, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    console.log(response.data)
                }).catch(error => {
                    console.log(error)
                })
        },
        previewImage: function(event) {
            // Reference to the DOM input element
            var input = event.target;
            // Ensure that you have a file before attempting to read it
            if (input.files && input.files[0]) {
                // add the image data to the recipe
                this.recipe.image = input.files[0];
                
                // create a new FileReader to read this image and convert to base64 format
                var reader = new FileReader();
                // Define a callback function to run, when FileReader finishes its job
                reader.onload = (e) => {
                    // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
                    // Read image as base64 and set to imageData
                    this.imageData = e.target.result;
                }
                // Start the reader job - read file as a data url (base64 format)
                reader.readAsDataURL(input.files[0]);
            }
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

