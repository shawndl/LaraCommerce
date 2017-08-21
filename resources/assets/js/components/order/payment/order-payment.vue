<template>
    <div>
        <div class="row">
            <user-order-header :address="order.address"
                               :user="order.user">

            </user-order-header>
        </div><!-- /.row -->
        <div class="row">
            <billing-form :cart="cart"
                          :order="order">

            </billing-form>
        </div><!-- /.row -->
    </div>
</template>

<script>
    export default {
        props : ['cart', 'order']
    }
</script>