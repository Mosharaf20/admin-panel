require('./bootstrap');

window.Vue = require('vue');

//vue router set
import VueRouter from 'vue-router'
Vue.use(VueRouter);


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


//custom fire event
window.Fire = new  Vue();


//moment js
import moment from 'moment';


//filter
Vue.filter('myDate',function(created){
    return moment(created).format("MMM Do YY");
});

Vue.filter('capitalize',function (value) {
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1)
});

const routes = [
    { path: '/dashboard', component: require('./components/DashboardComponent.vue').default},
    { path: '/user', component: require('./components/UsersComponent.vue').default},
    { path: '/profile', component: require('./components/ProfileComponent.vue').default},
    { path: '/developer', component: require('./components/DeveloperComponent.vue').default},
];

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});

const app = new Vue({
    router,
    el: '#app',
});
