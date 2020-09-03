<template>
    <div class="content-header">
        <div class="container-fluid" v-if="$gate.isAdmin()">
            <div ref="imageUpload" class="row d-flex justify-content-center">
                <div class="col-12 bg-dark w-100 text-center p-3 h3">Drop Image's Here</div>
            </div>
        </div>

        <div class="container-fluid row d-flex " >
            <div class="col-3 mb-3" v-for="image of images">
                <img class="w-100 img-fluid"  :src="image.image_thumbnail" alt="" data-toggle="modal" :data-target="'#show'+image.id">
                <button class="btn btn-danger btn-sm" @click="deleteImage(image.id)">Delete</button>


                <div class="modal fade " tabindex="-1" :id="'show'+image.id">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <img class="w-100 h-75 img-fluid"  :src="image.image" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "GalleryComponent.vue",

        data(){
            return{
                dropzone: null,
                images: null,
                show: false
            }
        },

        methods:{
            getImages(){
                axios.get('api/images')
                    .then(response=>{
                        this.images = response.data;
                    })
                    .catch(error=>{
                        console.log(error);
                    })
            },

            deleteImage(id){
                axios.delete('/api/images/'+id)
                    .then(response=>{
                        Fire.$emit('refreshImage');
                        console.log(response.data)
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            }

        },

        mounted() {
            this.dropzone = new Dropzone(this.$refs.imageUpload,{
                url:'api/images',
            });

            this.getImages();

            Fire.$on('refreshImage',()=>{
                this.getImages();
            })
        }
    }
</script>

<style scoped>

</style>
