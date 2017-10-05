<template>
    <div class="row">
        <div class="col-sm-8">
            <order-information v-if="current === 1"
                               :cart="cart"
                               :order="order">

            </order-information>
            <user-address v-if="current === 2"
                          :isForm="true"
                          :order_id="order.id">
            </user-address>
            <order-payment v-if="current === 3"
                           :cart="cart"
                           :order="order">

            </order-payment>
            <user-order v-if="current === 4"
                        :order_id="order.id">

            </user-order>
        </div><!-- /.col -->
        <div class="col-sm-4">
            <order-total-details :order="cart.information" v-if="!order.cost">

            </order-total-details>
            <order-total-details :order="order.cost" v-if="order.cost">

            </order-total-details>
        </div><!-- /.col -->
    </div><!-- /.row -->
</template>

<script>
    export default {
        props: ['current', 'cart', 'addresses', 'user_order'],

        data: function() {
            return {
                userPickedAddress : false,
                order : {
                    street_address : {},
                    id : false,
                    created : false,
                    arrival : '',
                    user : {
                        first_name : '',
                        last_name : '',
                        email : '',
                        username : ''
                    },
                    cost : null
                }
            }
        },

        mounted() {
            this.setOrder();
        },

        created() {
            Event.$on('user-pick-address',
                (response) =>  this.createOrder(response)
            );

            Event.$on('user-paid-for-order',
                (order) => this.order = order
            );
        },

        methods : {
            /**
             * If an order already exists then it will set the values below so the
             * can refresh the page and still retain the order information
             *
             * @return {void}
             */
            setOrder() {
                let order = JSON.parse(this.user_order);
                if(order !== false) {
                    this.order.address = order.address;
                    this.order.id = order.order_id;
                    this.order.user = order.user
                    this.order.created = true;
                    this.$emit('address-is-complete');
                }
            },

            /**
             * On a successful creation of  an order
             * update the order property to add an order id and update the steps property
             * @param response
             */
            createOrder(response) {
                this.order.created = true;
                this.order.id = response.order.order_id;
                this.order.address = response.order.address;
                this.order.user = response.order.user;
                this.$emit('address-is-complete', true);
                Event.$emit('update-user-message', response.message);
            }
        }
    }
</script>