<template>
    <div class="well">
        <p class="order-summary">
            <strong>Summary</strong>
        </p>
        <p>
            <strong>Subtotal:</strong>
            <span class="pull-right">${{ order.sub_total }} </span>
        </p>
        <p>
            <strong>Taxes</strong>
            <span class="pull-right">${{ order.taxes }} </span>
        </p>
        <p class="order-main-total">
            <strong>Total:</strong>
            <span class="pull-right">${{ order.total }} </span>
        </p>

    </div><!-- /.well -->
</template>

<script>
    export default {
        props: ['order']
    }
</script>