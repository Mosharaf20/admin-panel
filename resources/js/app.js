require('./bootstrap');

window.Vue = require('vue');

//vue router set
import VueRouter from 'vue-router'
Vue.use(VueRouter);


//import gate
import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);


//v-form
import Vue from 'vue'
import { Form, HasError, AlertError } from 'vform'

window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);


//sweetAlert2
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast;


//vue progress bar
import VueProgressBar from 'vue-progressbar'

const options = {
    color: '#86e531',
    failedColor: 'red',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
};

Vue.use(VueProgressBar, options);

//passport component
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);


//custom fire event
window.Fire = new  Vue();


//moment js
import moment from 'moment';

//vue pagination
Vue.component('pagination', require('laravel-vue-pagination'));

//filter
Vue.filter('myDate',function(created){
    return moment(created).format("MMM Do YY");
});

Vue.filter('capitalize',function (value) {
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1)
});


//DropZone
import dropzone from 'dropzone';
window.Dropzone = dropzone;

const routes = [
    { path: '/dashboard', component: require('./components/DashboardComponent.vue').default},
    { path: '/users', component: require('./components/UsersComponent.vue').default},
    { path: '/profiles', component: require('./components/ProfileComponent.vue').default},
    { path: '/developer', component: require('./components/DeveloperComponent.vue').default},
    { path: '/test', component: require('./components/GalleryComponent.vue').default},
    { path: '/form', component: require('./components/FormComponent.vue').default},
    { path: '*', component: require('./components/ComponentPageNotFound.vue').default},
];

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('notification-component', require('./components/NotificationComponent.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});

const app = new Vue({
    router,
    el: '#app',

    data:{
        keyword: '',
    },

    methods:{
        searchContent: _.debounce(()=>{
            Fire.$emit('searching')
        },1500),

    }
});
