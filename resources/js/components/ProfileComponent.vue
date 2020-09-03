<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <form @submit.prevent="updateProfilePicture" @keydown="form.onKeydown($event)">
                                    <input type="file" style="display: none" ref="profileImageInput" @change="inputProfilePicture"  name="image" >
                                    <has-error :form="form" field="image"></has-error>
                                    <button :disabled="form.busy" type="submit" class="btn btn-primary">Update</button>
                                </form>
                                <div class="text-center" >

                                    <img class="profile-user-img img-fluid img-circle"
                                         :src="getProfileImage()"
                                         alt="User profile picture"><br>

                                    <button class="btn btn-success btn-sm" @click="$refs.profileImageInput.click()">Upload Image</button>
                                </div>

                                <h3 class="profile-username text-center">{{form.name}}</h3>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Type</b> <a class="float-right">{{form.type}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Rules</b> <a class="float-right">Everything</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                                Activity
                                    </div>

                                    <div class="tab-pane" id="timeline">
                                        <div class="timeline timeline-inverse">
                                            Timeline
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="settings">
                                        <form @submit.prevent="updateProfile(profile.id)" @keydown="form.onKeydown($event)">

                                            <div class="form-group">
                                                <label>Username</label>
                                                <input v-model="form.name" type="text" name="name"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <has-error :form="form" field="name"></has-error>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input v-model="form.email" type="text" name="email"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                                <has-error :form="form" field="email"></has-error>
                                            </div>

                                            <div class="form-group">
                                                <label>Update Password</label>
                                                <input v-model="form.password" type="password" name="password"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                                <has-error :form="form" field="password"></has-error>
                                            </div>

                                            <button :disabled="form.busy" type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "ProfileComponent.vue",

        data () {
            return {
                // Create a new form instance
                form: new Form({
                    id          : '',
                    name        : '',
                    email       : '',
                    type        : '',
                    password    : '',
                    remember    : false,
                    image       : '',
                }),

                previewImage: '',

            }
        },

        methods:{
            getProfileImage(){
                var prefix = (this.form.image.length>200) ? '' : '/images/admin/profiles/';
                return prefix + this.form.image;
            },

            userProfile(){
                axios.get('api/profiles')
                    .then(response=>{
                        this.form.fill(response.data);
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            },

            updateProfile(id){
                this.form.post('api/profiles/'+id)
                    .then(response=>{
                        Toast.fire({
                            icon: 'success',
                            title: 'profile updated successfully'
                        });

                        console.log(response.data)
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            },

            inputProfilePicture(e){
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = e =>{
                    this.form.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            updateProfilePicture(){
               this.form.post('api/profiles/image')
                    .then(response=>{
                        console.log(response.data)
                    })
                    .catch(error=>{
                        console.log(error);
                    })
            }

        },

        mounted() {
            this.userProfile();

        },


    }
</script>

<style scoped>

</style>
