<template>
    <main>
        <div class="page-header">
            <h1 class="container">Dashboard</h1>
        </div>

        <div class="container">
            <p>Get quick access to manage your account or add a new recipe to the site.</p>

            <div class="row">
                <div class="col">
                    <h3>Add Recipe</h3>
                    <p>Share your latest or greatest recipes with the community. Once submitted, we'll need to approve it.</p>
                    <p>
                        <router-link :to="{ name: 'dashboard.recipe.add' }" class="btn btn-primary">Add Recipe</router-link>
                    </p>
                </div>

                <!-- <div class="col-md-4">
                    <h3>Create Collection</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti sunt veritatis sequi nobis voluptatem ipsa!</p>
                    <p><a href="" class="btn btn-primary">Click</a></p>
                </div> -->

                <div class="col">
                    <h3>Account Settings</h3>
                    <p>Update your account details, manage your account settings or close your account.</p>
                    <p>
                        <router-link :to="{ name: 'me.settings' }" class="btn btn-primary">Manage Account</router-link>
                    </p>
                </div>
            </div>

            <!-- <div class="stats-graph">
                <h3>Stats</h3>
            </div> -->
        </div>
    </main>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>

.row {
    @media (min-width: 768px) {
        display: flex;
        justify-content: space-between;
    }
}

.col {
    margin-bottom: 20px;
    
    @media (min-width: 768px) {  
        width: 49%;
        margin-bottom: 0;
    }
}
</style>
