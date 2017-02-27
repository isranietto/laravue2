<template>
    <tr>
        <td>
            <input type="text"
                v-model="editForm.username" v-if="edit"
            >
            <span v-else>{{ user.username }}</span>
        </td>
        <td>
            <input type="text"
                   v-model="editForm.email" v-if="edit"
            >
            <span v-else>{{ user.email }}</span>
        </td>
        <td>
            <button type="button"  class="btn btn-info"
                    @click.prevent="editUser"
                    v-if="!edit"
            >Edit</button>
            <button type="button"  class="btn btn-default"
                    @click.prevent="cancelEdit"
                    v-if="edit"
            >Cancel</button>
            <button type="button"  class="btn btn-primary"
                    @click.prevent="updateUser(user, editForm)"
                    v-if="edit"
            >Update</button>
            <button type="button" @click.prevent="$emit('delete-user', user)" class="btn btn-danger"
                    v-if="!edit"
            >Delete</button>
        </td>
    </tr>
</template>
<script>
    export default{
        props: ['user'],
        data() {
            return {
                edit: false,
                editForm:{
                    'username' : '',
                    'email' : ''
                }
            }
        },
        methods: {
            editUser(){
                this.edit =  true;
                this.editForm.username = this.user.username;
                this.editForm.email = this.user.email;

            },
            cancelEdit(){
                this.edit = false;
                this.editForm.username = '';
                this.editForm.email = '';
            },
            updateUser(oldUser, newUser){
                this.$http.patch('/users/' + oldUser.id, newUser).then( response => {
                    this.$emit('update-user');
                    this.cancelEdit();
                    console.log(response.data);
                });
            }
        }
    }
</script>
