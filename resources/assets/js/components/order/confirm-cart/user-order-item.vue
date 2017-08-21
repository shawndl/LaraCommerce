<template>
    <div class="order-row">
        <div class="order-image">
            <img :src="item.image" alt="image of the product">
        </div><!-- /.order-image -->
        <div class="order-description">
            <h4>{{ item.title }}</h4>
        </div><!-- /.order-description -->
        <div class="order-quantity">
            <div class="form-group">
                <select-cart-quantity v-if="isForm"
                                      :current="item.quantity"
                                      :product_id="item.id"
                                      :showLabel="true"
                                      @quantity="updateCart">

                </select-cart-quantity>
                <div v-if="!isForm">
                    <strong>Quantity: </strong>{{ item.quantity }}
                </div>
            </div><!-- /.form-group -->
        </div><!-- /.order-quantity -->
        <div class="order-total">
            <p><strong>Total: {{ item.total}} </strong></p>
        </div><!-- /.order-total -->
        <remove-item-icon v-if="isForm"
                          :product_id="item.id"
                          :product="item.title"
                          :mainClass="'pull-right'"
                          :sizeClass="'fa fa-times fa-2'"
                          @remove-item="removeItem">

        </remove-item-icon>
    </div><!-- /.order-row -->
</template>

<script>
    export default {
        props : [
            'item', 'isForm'
        ],

        methods: {
            /**
             * updates the cart in the parent class with the quantity and product id
             * @param value
             * @return void
             */
            updateCart(value) {
                Event.$emit('update-user-cart', value);
            },

            /**
             * removes an item in the parent class with the product id
             * @param value
             */
            removeItem(value) {
                Event.$emit('remove-item-cart', value);
            },
        }
    }
</script>