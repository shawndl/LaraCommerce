<template>
    <li>
        <a class="dropdown-toggle" href="#" @click="toggleDropdown">
            <span>{{ cart.information.total }}</span>
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            {{ getMessage() }}
        </a>
        <ul class="shopping-cart-drop"
            v-show="showDropdown">
            <div class="close-icon" @click="toggleDropdown">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
            <li class="dropdown-title">
                {{ getTotalMessage() }}
            </li>
            <li class="dropdown-item"
                v-for="product in cart.products">
                <img class="dropdown-item-image"
                     :src="product.image"
                     :alt="'Image of ' + product.title">
                <div class="dropdown-item-info">
                    <p><strong>{{ product.title }}</strong></p>
                    <p>Price: {{ product.total }}</p>
                </div>
                <div class="dropdown-quantity">
                    <select-cart-quantity :current="product.quantity"
                                          :product_id="product.id"
                                          @quantity="updateQuantity">

                    </select-cart-quantity>
                </div>
                <remove-item-icon :product_id="product.id"
                                  :product="product.title"
                                  :mainClass="'remove-item-icon'"
                                  :sizeClass="'fa fa-times'"
                                  @remove-item="removeItem">

                </remove-item-icon>

            </li>
            <li class="dropdown-button">
                <a class="btn btn-success" :href="order_url + '/select-address'">Check Out</a>
                <a class="btn btn-primary pull-right" :href="order_url + '/edit-order'">Edit Order</a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        props : [
           'cart', 'checkout_page'
        ],

        data : function () {
            return {
                showDropdown : false,
                order_url : ''
            }
        },

        mounted() {
            this.order_url = window.Laravel.urls.order_url;
        },

        methods: {
            /**
             * sets the message based on the number of items in the products array
             * @returns {string}
             */
            getMessage() {
                let count = 0;
                if(this.cart.products) {
                    count = this.cart.products.length;
                }
                if(count === 0) {
                    return "Empty";
                }
                if(count === 1) {
                    return "1 Item";
                }
                if(count > 1) {
                    return count + " Items";
                }
            },

            /**
             * toggles the show dropdown target
             * @return {void}
             */
            toggleDropdown() {
                this.showDropdown = !this.showDropdown;
            },

            /**
             * gets a message with the number of items and the subtotal
             * @return {string}
             */
            getTotalMessage() {
                let message = this.cart.information.count + ' Item';
                if(this.cart.information.count != 1) {
                    message += 's';
                }
                message += ' with Subtotal of $' + this.cart.information.subTotal;
                return message;
            },

            /**
             * emits an event to the parent class to remove an item from the cart
             * @param value
             * @return {void}
             */
            removeItem(value) {
                this.$emit('remove-item', value);
            },

            /**
             * emits an event to the parent class to update the quantity of a product
             * @param value
             * @return {void}
             */
            updateQuantity(value) {
                this.$emit('update-quantity', value);
            }
        }


    }
</script>