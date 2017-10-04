<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Payment Options</h4>
        </div><!-- /.panel-heading -->
        <div class="panel-body">
            <button class="btn btn-success" @click="beforeSubmit">
                Credit Card  <i class="fa fa-credit-card" aria-hidden="true"></i>
            </button>
        </div><!-- /.panel-body -->
    </div><!-- /.panel -->
</template>

<script>
    export default {
        props: ['cart', 'order'],

        data: function() {
            return {
                stripe : {},
                post_url : '',
                formData : {
                    stripeEmail: '',
                    stripeToken: '',
                    order_id: ''
                },
                total : 0
            }
        },

        mounted() {
            this.formData.order_id = this.order.id;
            this.post_url = window.Laravel.urls.billing_url;
            this.total = this.cart.information.total * 100;

            let self = this;
            this.stripe = StripeCheckout.configure({
                key: window.Laravel.stripeKey,
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                email: this.order.user.email,
                token: function(token) {
                    self.formData.stripeEmail = token.email;
                    self.formData.stripeToken = token.id;
                    axios.post( window.Laravel.urls.billing_url, self.formData)
                        .then(
                            (response) => self.emitSuccess(response.data)
                        )
                        .catch(
                            (error) => self.emitError(error.response.data)
                        );
                }
            });
        },

        methods: {

            /**
             * opens the stripe window to get the stripe token for payment
             * @return void
             */
            beforeSubmit() {
                this.stripe.open({
                    name: "Complete my orders",
                    description : "total items from your cart",
                    zipCode: true,
                    amount: this.total
                });
            },

            /**
             * if the payment was processed successfully
             * @param response
             * @return void
             */
            emitSuccess(response) {
                Event.$emit('user-paid-for-order', response.data.order)
                Event.$emit('reset-users-cart', true);
                Event.$emit('update-user-message', response.status)
            },

            /**
             * if there is an error with the process
             * @param error
             * @return void
             */
            emitError(error) {
                Event.$emit('update-user-error', error.status);
            }
        }

    }
</script>

<style>

</style>