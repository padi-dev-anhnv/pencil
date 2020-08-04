/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
import Paginate from 'vuejs-paginate'
Vue.component('paginate', Paginate)

Vue.component('list-user', require('./components/user/list/ListUser.vue').default);
Vue.component('form-user', require('./components/user/FormUser.vue').default);
Vue.component('list-file', require('./components/file/ListFile.vue').default);
Vue.component('list-file', require('./components/file/ListFile.vue').default);
Vue.component('add-file', require('./components/file/AddFile.vue').default);
Vue.component('edit-file', require('./components/file/EditFile.vue').default);

Vue.component('create-guide', require('./components/guide/CreateGuide.vue').default);
Vue.component('edit-guide', require('./components/guide/EditGuide.vue').default);
Vue.component('guide-block', require('./components/guide/partials/GuideBlock.vue').default);
Vue.component('delivery-block', require('./components/guide/partials/DeliveryBlock.vue').default);
Vue.component('packaging-block', require('./components/guide/partials/PackagingBlock.vue').default);
Vue.component('procedure-block', require('./components/guide/partials/ProcedureBlock.vue').default);
Vue.component('product-block', require('./components/guide/partials/ProductBlock.vue').default);

Vue.component('list-guide', require('./components/guide/ListGuide.vue').default);
Vue.component('sort-form', require('./components/guide/components/SortForm.vue').default);
Vue.component('search-form', require('./components/guide/components/SearchForm.vue').default);
Vue.component('list-result', require('./components/guide/components/ListResult.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#wrapper',
});
