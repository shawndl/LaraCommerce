<template>
    <div class="well">
        <h4><u>Shipping Address: </u></h4>
        <p>
            {{ address.street_address }} <br />
            {{ address.city }}, {{ address.state }} {{ address.postal_code }}
        </p>
    </div><!-- /.well -->
</template>

<script>
    export default {
        props: ['address']
    }
</script>