<template>
        <div class="content-header">
            <div class="container-fluid" v-if="$gate.isAdmin()">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Developer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Developer</li>
                        </ol>
                    </div>
                </div>
            </div>
            <section class="content">
                <section class="container-fluid">
                    <passport-clients></passport-clients>
                    <passport-authorized-clients></passport-authorized-clients>
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                </section>
            </section>
        </div>
</template>

<script>
    export default {
        name: "DeveloperComponent.vue"
    }
</script>

<style scoped>

</style>
