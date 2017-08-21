<template>
    <div class="shopping-cart-form">
        <div class="shopping-cart-form">
            <button class="btn btn-primary" @click="addToCart">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>Add to Cart
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props : [
            'cart_url', 'product_id'
        ],

        methods: {
            /**
             * sends an object to the main component to add to the cart
             */
            addToCart() {
                this.$emit('add-to-cart', {product : this.product_id, quantity : 1});
            },
        }


    }
</script>