<template>
    <main>
        <div class="page-header">
            <h1 class="container">Settings</h1>
        </div>
        <div class="container">        
            <div class="col-md-3">
                <h3>Sidebar Options</h3>
                <ul>
                    <li>Account Settings</li>
                    <li>Password</li>
                </ul>
            </div>

            <div class="col-md-9">
                <h3>Settings Panel</h3>

                <h6>Account</h6>
                <form action="POST" class="form" @submit.prevent="updateBasicDetails">
                    <div class="form-group">
                        <label>Select an image</label>
                        <input type="file" @change="previewImage" accept="image/*">

                        <div class="image-preview" v-if="imageData.length > 0">
                            <img class="preview" :src="imageData">
                        </div>
                    </div>
                    <p><input type="text" class="form-control" placeholder="name" v-model="user.name"></p>
                    <p><input type="text" class="form-control" placeholder="name" v-model="user.username"></p>
       
                    <p><button type="submit" class="btn">Save</button></p>
                </form>

                <form action="POST" class="form" @submit.prevent="updateEmail">
                    <h6>Email</h6>
                    
                    <p><input type="text" class="form-control" placeholder="email" v-model="email.email"></p>
                    <p><input type="password" class="form-control" placeholder="confirm password" v-model="email.password"></p>
                    <p><button type="submit" class="btn">Save</button></p>                   
                </form>

                <h6>Password</h6>
                
                <form action="POST" class="form" @submit.prevent="updatePassword">
                    <p><input type="password" class="form-control" placeholder="old password" v-model="password.old"></p>
                    <p><input type="password" class="form-control" placeholder="new password" v-model="password.new"></p>
                    <p><input type="password" class="form-control" placeholder="confirm new password" v-model="password.confirm"></p>
                    <p><button type="submit" class="btn">Save</button></p>
                </form>
            </div>
        </div>
    </main>
</template>

<script>
export default {
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
                    console.log(response.data)
                    this.user = response.data
                });
        },
        updateBasicDetails() {
            var form = new FormData();

            if (this.image) {
                form.append('image', this.image)
            }

            form.append('username', this.user.username)
            form.append('name', this.user.name)

            axios
                .patch(route('settings.update.basic'), form, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    console.log(response.data)
                }).catch(error => {
                    console.log(error)
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

