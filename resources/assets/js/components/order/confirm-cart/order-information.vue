<template>
    <div>
        <user-order-item v-for="item in cart.products"
                         :key="item.id"
                         :item="item"
                         :isForm="true">

        </user-order-item>
    </div>
</template>

<script>
    export default {
        props : [
            'cart'
        ]
    }
</script>