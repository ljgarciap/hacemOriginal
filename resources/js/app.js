/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuesax from 'vuesax';

import 'vuesax/dist/vuesax.css'; //Vuesax styles

import 'material-icons/iconfont/material-icons.css';

window.Vue.use(Vuesax, {
    // options here
  });

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
Vue.component('bienvenida', require('./components/Bienvenida.vue').default);
Vue.component('admin', require('./components/Admin.vue').default);
Vue.component('empresa', require('./components/Empresa.vue').default);
Vue.component('areas', require('./components/Areas.vue').default);
Vue.component('procesos', require('./components/Procesos.vue').default);
Vue.component('perfiles', require('./components/Perfiles.vue').default);
Vue.component('unidades', require('./components/Unidades.vue').default);
Vue.component('materias', require('./components/Materias.vue').default);
Vue.component('gestionmaterias', require('./components/GestionMaterias.vue').default);
Vue.component('materiaprima', require('./components/MateriaPrimaProductos.vue').default);
Vue.component('roles', require('./components/Roles.vue').default);
Vue.component('hojas', require('./components/Hojas.vue').default);
Vue.component('usuarios', require('./components/Usuarios.vue').default);
Vue.component('colecciones', require('./components/Colecciones.vue').default);
Vue.component('productos', require('./components/Productos.vue').default);
Vue.component('conceptos', require('./components/Conceptos.vue').default);
Vue.component('ninguno', require('./components/Ninguno.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data :{
        menu : 0
    }
});
