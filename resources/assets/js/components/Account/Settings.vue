<template>
    <div class="row">
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
            <form action="POST" @submit.prevent="updateAccount">
                <p><input type="text" class="form-control" placeholder="name"></p>
                <p><input type="text" class="form-control" placeholder="email"></p>
                <p><button type="submit" class="btn">Save</button></p>
            </form>

            <h6>Password</h6>
            <form action="POST" @submit.prevent="passwordChange">
                <p><input type="password" class="form-control" placeholder="old password"></p>
                <p><input type="password" class="form-control" placeholder="new password"></p>
                <p><button type="submit" class="btn">Save</button></p>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            
        }
    },
    created() {

    },
    methods: {
        updateAccount() {
            console.log('account update')

        },
        passwordChange() {
            console.log('password update')
        }
    }
}
</script>

