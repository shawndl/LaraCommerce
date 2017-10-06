<template>
    <div class="address-box" v-if="address">
        <div class="address-details">
            <p>{{ address.street_address }}  </p>
            <p>{{ address.city }}, {{ address.state }}, {{ address.postal_code }}</p>
        </div><!-- /.address-details -->
        <div class="address-box-footer">
            <div class="address-edit-button">
                <edit-address :address="address"
                              :refresh="refreshDB">

                </edit-address>
            </div><!-- /.address-edit -->
            <div class="address-delete-button">
                <delete-address :address="address"
                                :refresh="refreshDB">

                </delete-address>
            </div><!-- /.address-edit -->
        </div><!-- /.address-footer-box -->
    </div><!-- /.address-box -->
</template>

<script>
    export default {
        props: ['address', 'refreshDB']
    }
</script>