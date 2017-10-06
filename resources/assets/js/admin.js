
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue';
import VeeValidate from 'vee-validate';
window._ = require('lodash');

import datePicker from 'vue-bootstrap-datetimepicker';
Vue.use(datePicker);

Vue.use(VeeValidate);


/**
 * Add vue components to the project.
 */
Vue.component('admin-main-page', require('./components/admin-main-page.vue'));

// Products
Vue.component('product-table', require('./components/admin/products/product-table.vue'));
Vue.component('product-row', require('./components/admin/products/product-row.vue'));
Vue.component('delete-product-form', require('./components/admin/products/delete-product-form.vue'));
Vue.component('product-form', require('./components/admin/products/product-form.vue'));
Vue.component('view-product', require('./components/admin/products/view-product.vue'));

// Sales
Vue.component('sale-form', require('./components/admin/sales/sale-form.vue'));
Vue.component('view-sale-details', require('./components/admin/sales/view-sale-details.vue'));

// Functionality
Vue.component('form-modal', require('./components/functionality/modal/form-modal.vue'));
Vue.component('view-message', require('./components/functionality/view-message.vue'));
Vue.component('message-modal', require('./components/functionality/modal/message-modal.vue'));
Vue.component('confirm-modal', require('./components/functionality/modal/confirm-modal.vue'));
Vue.component('view-details-modal', require('./components/functionality/modal/view-details-modal.vue'));
Vue.component('paginate-items', require('./components/functionality/paginate-items.vue'));
Vue.component('input-date', require('./components/functionality/form/input-date.vue'));
Vue.component('success-message', require('./components/functionality/messages/success-message.vue'))
Vue.component('error-message', require('./components/functionality/messages/error-message.vue'));
Vue.component('full-screen', require('./components/functionality/screen/full-screen.vue'));

// Animation
Vue.component('fade-out-animation', require('./components/functionality/animations/fade-out-animation.vue'));
Vue.component('slide-out-animation', require('./components/functionality/animations/slide-in-animation.vue'));


// Orders
Vue.component('view-order', require('./components/admin/orders/view-order.vue'));
Vue.component('ship-order', require('./components/admin/orders/ship-order.vue'));
Vue.component('user-order-item', require('./components/order/confirm-cart/user-order-item.vue'));
Vue.component('user-order-header', require('./components/order/shared/user-order-header.vue'));
Vue.component('order-total-details', require('./components/order/shared/order-total-details.vue'));
Vue.component('shipping-address', require('./components/shared-information/address/shipping-address.vue'));
Vue.component('user-details', require('./components/shared-information/user-details.vue'));

// Categories
Vue.component('categories-table', require('./components/admin/categories/categories-table.vue'));
Vue.component('category-row', require('./components/admin/categories/category-row.vue'));
Vue.component('category-form', require('./components/admin/categories/category-form.vue'));
Vue.component('edit-category-button', require('./components/admin/categories/edit-category-button.vue'));
Vue.component('delete-category-button', require('./components/admin/categories/delete-category-button.vue'));

// Taxes
Vue.component('tax-table', require('./components/admin/taxes/tax-table.vue'));
Vue.component('tax-row', require('./components/admin/taxes/tax-row.vue'));
Vue.component('tax-form', require('./components/admin/taxes/tax-form.vue'));
Vue.component('delete-tax-button', require('./components/admin/taxes/delete-tax-button.vue'));

const app = new Vue({
    el: '#app'
});