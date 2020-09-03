<template>
    <div class="content-header">
        <div class="container-fluid" v-if="$gate.isAdmin()">
            <div class="alert alert-success" v-show="success">Profile Details Create Successfully</div>
            <form @submit.prevent="createProfile" method="post" class="col-6">
                <div class="form-group">
                    <label for="country">Country</label>
                    <select name="country" v-model="form.country" id="country" class="form-control">
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="India">India</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Nepal">Nepal</option>
                    </select>
                    <span class="text-danger" v-if="errors && errors.description" >{{errors.description[0] }}</span>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control"  v-model="form.description" name="description" id="description" cols="" rows="5"></textarea>
                    <span class="text-danger" v-if="errors && errors.country" >{{errors.country[0] }}</span>
                </div>

                <div class="form-group">
                    <label for="experience">Experience</label>
                    <input type="text" id ="experience" v-model="form.experience" name="experience" class="form-control">
                    <span class="text-danger" v-if="errors && errors.experience" >{{errors.experience[0] }}</span>
                </div>

                <button class="btn btn-info btn-sm">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FormComponent.vue",

        data(){
            return {
                form: {},
                errors: {},
                success: ''
            }
        },

        methods:{
            createProfile(){
                axios.post('api/profiles',this.form)
                    .then(response=>{
                        this.success = true;
                        this.form = {};
                        console.log(response.data)
                    })
                    .catch(error=>{
                        if(error.response.status===422){
                            this.success = false;
                            this.errors = error.response.data.errors;
                        }

                        console.log(error)
                    })
            }
        }
    }
</script>

<style scoped>

</style>
