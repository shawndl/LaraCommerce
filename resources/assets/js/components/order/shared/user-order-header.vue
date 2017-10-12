<template>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3>Order Details</h3>
        </div><!-- /.panel-heading -->
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <user-details :user="order.user">

                    </user-details>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <shipping-address :address="order.address">

                    </shipping-address>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="well">
                        <h3>Payment</h3>
                        <strong>Paid:
                            <span v-if="order.paid_for" class="text-success">Yes</span>
                            <span v-else class="text-danger">No</span>
                        </strong>
                        <br />
                        <strong>Shipped:
                            <span v-if="order.shipped" class="text-success">Yes</span>
                            <span v-else class="text-danger">No</span>
                        </strong>
                        <br>
                        <strong v-if="order.shipped">
                            Ship Date: {{ order.ship_date }}
                        </strong>
                    </div><!-- /.well -->
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.panel-body -->
    </div><!-- /.panel -->
</template>

<script>
    export default {
        props: ['order']
    }
</script>

