<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="font-weight-bolder">Users List</h3>
                        <button v-if="$gate.isAdminOrSUbAdmin()"  class="btn btn-success ml-auto  btn-sm" @click="addUserModel">Add User<i class="ml-2 fas fa-plus-square"></i></button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Type</th>
                                <th scope="col">Created_at</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user  in users.data" :key="user.id" >
                                <th scope="row">{{user.id}}</th>
                                <td><router-link to="/profile">{{user.name | capitalize}}</router-link></td>
                                <td>{{user.email}}</td>
                                <td>{{user.type | capitalize}}</td>
                                <td>{{user.created_at | myDate}}</td>
                                <td>
                                    <a href="javascript:" v-if="$gate.isAdminOrSUbAdmin()" @click="updateUserModel(user)"><i class="fas fa-edit"></i></a>
                                    <a href="javascript:" v-if="$gate.isAdmin()" @click.prevent="deleteUser"><i class="text-danger fas fa-trash"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <br>
                        <pagination :data="users" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>

            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="show" >Add User</h5>
                        <h5 v-show="!show" >Update User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form @submit.prevent="(show===true) ? addUser() : updateUser()" @keydown="form.onKeydown($event)">
                            <div class="form-group">
                                <label>Username</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="email" name="email"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" v-model="form.type" id="" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="admin">Admin</option>
                                    <option value="sub-admin">Sub-Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>


                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <button v-show="show"  :disabled="form.busy" type="submit" class="btn btn-success">Add User</button>
                            <button v-show="!show"  :disabled="form.busy" type="submit" class="btn btn-success">Update User</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UsersComponent.vue",

        data(){
            return{
                // Create a new form instance
                form: new Form({
                    id  :     '',
                    name:     '',
                    email:    '',
                    type:     '',
                    password: '',
                    remember: true
                }),

                users:{},

                'show':true
            }
        },

        methods:{

            getResults(page = 1) {
                axios.get('api/users?page=' + page)
                    .then(response => {
                        this.users = response.data;
                    });
            },

            allUser()
            {
                axios.get('api/users')
                    .then(response=>{
                    this.users = response.data;
                }).catch(error=>{

                })
            },



            addUserModel()
            {
                $('#addUser').modal('show');
                this.show = true;
                this.form.clear ()
            },


            addUser ()
            {
                this.$Progress.start();
                // Submit the form via a POST request
                this.form.post('api/users')
                    .then(({ data }) => {
                        Toast.fire({
                            icon: 'success',
                            title: 'User is Created successfully'
                        });

                        Fire.$emit('loadUsers');

                        $('#addUser').modal('hide');

                        this.form.reset();

                        console.log(data)
                    })
                    .catch(error=>{
                        console.log(error);
                        this.$Progress.fail()
                    });

                this.$Progress.finish()
            },


            updateUserModel(data)
            {


                $('#addUser').modal('show');

                this.show = false;

                this.form.fill(data);

            },


            updateUser()
            {
               this.$Progress.start();

               this.form.patch('api/users/'+this.form.id)
                   .then(response=>{
                       if(response.data === 'success'){
                           Fire.$emit('loadUsers');

                           $('#addUser').modal('hide');

                           this.form.reset();

                           Toast.fire({
                               icon: 'success',
                               title: 'User is Updated successfully'
                           });

                           console.log(response.data)
                       }else{
                           alert('Your are not authorized person')
                       }

                   })
                   .catch(error=>{
                       console.log(error);
                       this.$Progress.fail();
                   });

                this.$Progress.finish();
            },


            deleteUser(id)
            {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('api/users/'+id)
                            .then(response=>{
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );

                                Fire.$emit('loadUsers');
                                console.log(response.data);
                            })
                            .catch(error=>{
                                console.log(error);
                            })

                    }
                });


            }
        },

        mounted() {
            this.allUser();

            this.getResults();

            Fire.$on('loadUsers',()=>{
                this.allUser();
            });

            Fire.$on('searching',()=>{
                const query = this.$parent.keyword;
                axios.post('api/users/search?q='+query)
                    .then(response=>{
                        this.users = response.data;
                        console.log(response.data)
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            })
        }
    }
</script>

<style scoped>

</style>
