<template>
    <section>
        <h1 class="page-title">Pantry</h1>
        <p class="intro-message">Whenever you are cooking food, you are going to need a few basics. Whether that's a simple thing as salt (which you'll find in most recipes) or maybe flour if your a baker at heart. Below is a list of our personal recommendations for your pantry, along with the top ingredients in our recipes.</p>

        <div class="pantry">
            <div class="pantry-group box-shadow">
                <h4 class="pantry-group__title">Basics</h4>
                <ol class="pantry-group__items">
                    <li>Sea Salt <span>must have</span></li>
                    <li>Black Peppercorns <span>must have</span></li>
                    <li>Extra Virgin Olive Oil</li>
                    <li>Vegetable Oil</li>
                </ol>
            </div>

            <div class="pantry-group box-shadow">
                <h4 class="pantry-group__title">Baking</h4>
                <ol class="pantry-group__items">
                    <li>Flour <span>must have</span></li>
                    <li>Baking Soda </li>
                    <li>Baking Powder</li>
                    <li>Cocoa powder</li>
                    <li>Vanilla Extract</li>
                </ol>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            loading: true
        }
    },
    created() {

    },
    methods: {

    }
}
</script>

<style lang="scss" scoped>
    .intro-message {
        max-width: 800px;
        font-size: 1.8rem;
        margin-bottom: 60px;
    }

    .pantry-group {
        background: #fff;
        padding: 0 20px 20px;
        margin-bottom: 20px;

        h4 {
            margin-bottom: 2rem;
        }
    }

    .pantry-group__items {
        list-style: none;
        margin: 0;
        padding: 0;

        span {
            color: #796EC6;
            text-transform: uppercase;
            font-size: 1.4rem;
            float: right;
        }
    }
</style>
