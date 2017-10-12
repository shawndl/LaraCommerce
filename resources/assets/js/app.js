
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

Vue.use(VeeValidate);


/**
 * Add vue components to the project.
 */
Vue.component('main-page', require('./components/main-page.vue'));
Vue.component('main-shopping-cart', require('./components/main-shopping-cart.vue'))


//Auth Pages
Vue.component('registration-form', require('./components/auth/registration-form.vue'));
Vue.component('login-form', require('./components/auth/login-form.vue'));

//Shopping Cart Pages
Vue.component('add-cart-icon', require('./components/shopping-cart/add-cart-icon.vue'));
Vue.component('remove-item-icon', require('./components/shopping-cart/remove-item-icon.vue'));


//Functionality
Vue.component('confirm-modal', require('./components/functionality/modal/confirm-modal.vue'));
Vue.component('form-modal', require('./components/functionality/modal/form-modal.vue'));
Vue.component('message-modal', require('./components/functionality/modal/message-modal.vue'));
Vue.component('review-stars', require('./components/functionality/review-stars.vue'));
Vue.component('select-cart-quantity', require('./components/functionality/select-cart-quantity.vue'))
Vue.component('view-message', require('./components/functionality/view-message.vue'));
Vue.component('step-progress-bar', require('./components/order/step-progress-bar.vue'));
Vue.component('full-screen', require('./components/functionality/screen/full-screen.vue'));

// Animation
Vue.component('fade-out-animation', require('./components/functionality/animations/fade-out-animation.vue'));
Vue.component('slide-out-animation', require('./components/functionality/animations/slide-in-animation.vue'));

// Messages
Vue.component('success-message', require('./components/functionality/messages/success-message.vue'));
Vue.component('error-message', require('./components/functionality/messages/error-message.vue'));


//Navbar
Vue.component('navbar-cart', require('./components/navbar/navbar-cart.vue'));
Vue.component('search-products', require('./components/navbar/search-products.vue'));
Vue.component('search-products-screen', require('./components/navbar/search-products-screen.vue'));
Vue.component('categories-navbar', require('./components/navbar/categories-navbar.vue'));


//User Account
Vue.component('user-account', require('./components/account/user-account.vue'));
Vue.component('user-account-header', require('./components/account/user-account-header.vue'));
Vue.component('user-account-address', require('./components/account/user-account-address.vue'));
Vue.component('user-account-order', require('./components/account/user-account-order.vue'));

//orders Page
Vue.component('order-total-details', require('./components/order/shared/order-total-details.vue'));
Vue.component('order-page', require('./components/order/order-page.vue'));
Vue.component('order-details', require('./components/order/order-details.vue'));
Vue.component('order-information', require('./components/order/confirm-cart/order-information.vue'));
Vue.component('user-address', require('./components/shared-information/address/user-address.vue'));
Vue.component('select-user-address', require('./components/order/address/select-user-address.vue'));
Vue.component('user-address-form', require('./components/shared-information/address/user-address-form.vue'));
Vue.component('order-payment', require('./components/order/payment/order-payment.vue'));
Vue.component('billing-form', require('./components/order/payment/billing-form.vue'));
Vue.component('add-new-address', require('./components/shared-information/address/add-new-address.vue'));
Vue.component('user-order', require('./components/order/invoice/user-order.vue'));
Vue.component('user-order-item', require('./components/order/confirm-cart/user-order-item.vue'));
Vue.component('user-order-header', require('./components/order/shared/user-order-header.vue'));

// Shared Information
Vue.component('shipping-address', require('./components/shared-information/address/shipping-address.vue'));
Vue.component('user-details', require('./components/shared-information/user-details.vue'));
Vue.component('address-box', require('./components/account/address-box.vue'));
Vue.component('edit-address', require('./components/shared-information/address/edit-address.vue'));
Vue.component('delete-address', require('./components/shared-information/address/delete-address.vue'));
Vue.component('order-list-item', require('./components/shared-information/order/order-list-item.vue'));

const app = new Vue({
    el: '#app'
});