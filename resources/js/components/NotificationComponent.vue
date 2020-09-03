<template>
    <div>
        <a href="#" class="dropdown-item" v-for="notification of notifications">
            <i class="fas fa-envelope mr-2"></i>
            <b>{{notification.name}}</b>
            {{notification.data.message}}
            <span class="float-right text-muted text-sm">{{notification.created_at | myDate}}</span>
        </a>
    </div>
</template>

<script>
    export default {
        name: "NotificationComponent",

        props:['notify'],

        data(){
            return{
                oldNotifications: this.notify,
                notifications: null,
            }
        },

        methods:{
            getNotifications(){
                axios.get('api/users/notification/')
                    .then(response=>{
                        this.notifications = response.data;
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            },

        },

        mounted() {
            this.getNotifications();
        },

        computed:{

        }


    }
</script>

<style scoped>

</style>
