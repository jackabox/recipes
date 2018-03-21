<template>
    <section>
        <h1 class="page-title">Pantry</h1>

        <div class="pantry">
            <div class="pantry-group">
                <h4 class="pantry-group__title">Basics</h4>
                <ol class="pantry-group__items">
                    <li>Sea Salt <span>must have</span></li>
                    <li>Black Peppercorns <span>must have</span></li>
                    <li>Extra Virgin Olive Oil</li>
                    <li>Vegetable Oil</li>
                </ol>
            </div>

            <div class="pantry-group">
                <h4 class="pantry-group__title">Baking</h4>
                <ol class="pantry-group__items">
                    <li>Flour <span>must have</span></li>
                    <li>Baking Soda </li>
                    <li>Baking Powder</li>
                    <li>Cocoa powder</li>
                    <li>Vanilla Extract</li>
                </ol>
            </div>

             <div class="pantry-group">
                <h4 class="pantry-group__title">Name</h4>
                <ol class="pantry-group__items">
                    <li>Flour <span>must have</span></li>
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
    .pantry {
        display: flex;
        flex-wrap: row wrap;
        justify-content: space-between;
    }

    .pantry-group {
        // border: 3px solid black;
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);        
        
        background: #fff;
        padding: 0 20px 20px;
        margin-bottom: 20px;
        width: 32%;

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
            font-size: 1.2rem;
            float: right;
        }
    }
</style>
