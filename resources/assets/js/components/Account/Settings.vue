<template>
    <main>
        <div class="page-header">
            <h1 class="container">Settings</h1>
        </div>
        <div class="container">
            <tabs>
                <tab name="Details">
                    <h3>Account Details</h3>
                    <form action="POST" class="form" @submit.prevent="updateBasicDetails">
                        <div class="form-group">
                            <label>Select an image</label>
                            <input type="file" @change="previewImage" accept="image/*">

                            <div class="image-preview" v-if="imageData.length > 0">
                                <img class="preview" :src="imageData">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Name</label>                            
                            <input type="text" class="form-control" placeholder="John Doe" v-model="user.name">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" placeholder="fuzzycats" v-model="user.username">
                        </div>
        
                        <p><button type="submit" class="btn">Update</button></p>
                    </form>
                </tab>
                <tab name="Email">
                    <h3>Email Change</h3>
                    <form action="POST" class="form" @submit.prevent="updateEmail">
                        <p>Your current email is {{ user.email }}. To update this, please fill out the fields below.</p>   
                        <div class="form-group">
                            <label>New Email</label>    
                            <input type="text" class="form-control" placeholder="john@doe.com" v-model="email.email">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>                                
                            <input type="password" class="form-control" placeholder="password" v-model="email.password">
                        </div>
                        <p><button type="submit" class="btn">Update</button></p>
                    </form>
                </tab>
                <tab name="Password">
                    <h3>Password Change</h3>
                    <form action="POST" class="form" @submit.prevent="updatePassword">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" class="form-control" placeholder="fuzzycats" v-model="password.old">
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" placeholder="fuzzydogs" v-model="password.old">
                        </div>
                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" class="form-control" placeholder="fuzzydogs" v-model="password.old">
                        </div>
                        <p><button type="submit" class="btn">Update</button></p>
                    </form>
                </tab>
            </tabs>
        </div>
    </main>
</template>

<script>
import {Tabs, Tab} from 'vue-tabs-component';

export default {
    components: {
        Tabs,
        Tab
    },
    data() {
        return {
            message: {},
            imageData: '',
            image: '',
            user: [],
            password: {
                old: '',
                new: '',
                confirm: ''
            },
            email: {
                email: '',
                password: '',
            }
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            console.log('fetch user data')
            axios
                .get(route('settings'))
                .then(response => {
                    this.user = response.data
                });
        },
        updateBasicDetails() {
            var form = new FormData();

            form.append('image', this.image)
            form.append('username', this.user.username)
            form.append('name', this.user.name)

            console.log(form);

            axios
                .post(route('settings.update.basic'), form, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.$notify({
                        type: 'success',
                        title: 'Details Updated',
                        text: response.data.message,
                        duration: 6000
                    });
                }).catch(error => {
                    this.$notify({
                        type: 'error',
                        title: 'Error Updating Details',
                        text: error.response.data.message,
                        duration: 6000
                    });
                })
            
            
        },
        updateEmail() {
            axios
                .patch(route('settings.update.email'), this.email)
                .then(response => {
                    this.email = {
                        email: '',
                        password: ''
                    }

                    this.message = {
                        type: 'success',
                        message: response.message
                    }
                }).catch(error => {
                    console.log(error);
                });
        },
        updatePassword() {
            axios
                .patch(route('settings.update.password'), this.password)
                .then(response => {
                    this.password = {
                        old: '',
                        new: '',
                        confirm: ''
                    }

                    this.message = {
                        type: 'success',
                        message: response.message
                    }
                }).catch(error => {
                    console.log(error);
                });
        },
        previewImage: function(event) {
            // Reference to the DOM input element
            var input = event.target;
            // Ensure that you have a file before attempting to read it
            if (input.files && input.files[0]) {
                // add the image data to the recipe
                this.image = input.files[0];
                
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


</style>
