<template>
    <div class="address-box" v-if="(address && states)">
        <div class="address-details">
            <p>{{ address.street_address }}  </p>
            <p>{{ address.city }}, {{ address.state }}, {{ address.postal_code }}</p>
        </div><!-- /.address-details -->
        <div class="address-box-footer">
            <div class="address-edit-button">
                <edit-address v-if="states"
                              :address="address"
                              :states="states">

                </edit-address>
            </div><!-- /.address-edit -->
            <div class="address-delete-button">
                <delete-address :address="address">

                </delete-address>
            </div><!-- /.address-edit -->
        </div><!-- /.address-footer-box -->
    </div><!-- /.address-box -->
</template>

<script>
    export default {
        props: ['address', 'states']
    }
</script>