<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{users.length}}</h3>
                                <p>Total Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{adminCount()}}</h3>
                                <p>Total Admin</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{subAdminCount()}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Sub-Admin</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{userCount()}}</h3>
                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
</template>

<script>
    export default {
        name: "DashboardComponent.vue",
        data(){
            return{
                users: null,
            }
        },

        methods:{

            allUser()
            {
                axios.get('api/all-users')
                    .then(response=>{
                        this.users = response.data;
                    }).catch(error=>{

                })
            },

            adminCount(){
                var totalAdmin = 0;

                this.users.forEach(function(user){
                    if(user.type == 'admin'){
                        totalAdmin += 1;
                    }
                });

                return totalAdmin;
            },

            subAdminCount(){
                var totalSubAdmin = 0;

                this.users.forEach(function(user){
                    if(user.type == 'sub-admin'){
                        totalSubAdmin += 1;
                    }
                });

                return totalSubAdmin;
            },

            userCount(){
                var totalUser = 0;

                this.users.forEach(function(user){
                    if(user.type == 'user'){
                        totalUser += 1;
                    }
                });

                return totalUser;
            },

        },

        mounted() {
            this.allUser();

        }
    }
</script>

<style scoped>

</style>
