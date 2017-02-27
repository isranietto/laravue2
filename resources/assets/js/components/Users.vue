<template lang="html">
    <div>
        <form action="" @submit.prevent="createUser">
            <div v-bind:class="{ 'form-group': true, 'has-error': errors.username }">
                <label for="username">Username</label>
                <input v-model="user.username" type="text" class="form-control" id="username" placeholder="Username">
                <spam class="help-block" v-for="error in errors.username">{{ error }}</spam>
            </div>
            <div v-bind:class="{ 'form-group': true, 'has-error': errors.email }">
                <label for="email">Email address</label>
                <input v-model="user.email" type="email" class="form-control" id="email" placeholder="Email">
                <spam class="help-block" v-for="error in errors.email">{{ error }}</spam>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add User</button>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>

            </thead>
            <tbody>
                <User v-for="user in users" :user="user"
                      @delete-user="deleteUser"
                      @update-user="fetchUsers"
                ></User>
            </tbody>
        </table>
    </div>
</template>

<script>
    import User from './User.vue';
    export default{
        data(){
            return {
                users : [],
                errors: [],
                user: {
                    username: '',
                    email: ''
                },

            }
        },
        components: {
            User
        },
        created(){
            this.fetchUsers();
        },
        methods: {
            fetchUsers(){
                this.$http.get('/users').then( response => {
                    this.users= response.data.users;
                },response => {
                    console.log(response.data)
                });
            },
            createUser(){
                this.$http.post('users/', this.user).then( response => {
                    this.users.push(response.data.user);
                    this.user= {username: '',email: ''};
                    if (this.errors){
                        this.errors = [];
                    }
                }, response => {
                    this.errors = response.data;
                });
            },
            deleteUser(user){
                this.$http.delete('/users/' + user.id).then( response => {
                    let index = this.users.indexOf(user);
                    this.users.splice(index, 1);
                    console.log(response.data);
                });
            }

        }
    }
</script>
