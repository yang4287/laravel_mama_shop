/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');
 import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'



 import { BootstrapVue, BootstrapVueIcons  } from 'bootstrap-vue'
 //import { UploadMedia, UpdateMedia } from 'vue-media-upload';
 
 // Import Bootstrap and BootstrapVue CSS files (order is important)
 import 'bootstrap/dist/css/bootstrap.css'
 import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueAxios, axios)
 // Make BootstrapVue available throughout your project
 Vue.use(BootstrapVue)
 // Optionally install the BootstrapVue icon components plugin
 Vue.use(BootstrapVueIcons)

window.Vue = require('axios').default;

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app'
// });
