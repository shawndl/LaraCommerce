<template>
    <div v-if="order">
        <div class="panel panel-default">
            <div class="panel-heading">
                Payment Details
            </div><!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <order-total-details :order="order.cost">

                        </order-total-details>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ship-order :order="order">

                        </ship-order>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->


        <user-order-header :address="order.address"
                           :user="order.user">

        </user-order-header>
        <h3>Your Order</h3>
        <ul class="list-group">
            <user-order-item v-for="product in order.products"
                             :key="product.id"
                             :item="product">

            </user-order-item>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['order_id'],

        data: function() {
            return {
                order : null
            }
        },

        mounted() {
            this.getOrder();
            if(this.need_total) {
                this.showTotal = this.need_total;
            }
        },

        methods: {
            /**
             * performs an ajax request to get the user order
             *
             * @return void
             */
            getOrder() {
                let self = this;
                axios.get(window.Laravel.urls.order_url + '/' + this.order_id)
                    .then(function (response) {
                        self.order = response.data.details.order;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            }
        }
    }
</script>