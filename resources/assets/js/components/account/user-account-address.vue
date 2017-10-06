<template>
    <div>
        <add-new-address :refresh="refreshAddress">

        </add-new-address>
        <div class="row" v-for="row in addresses">
            <div class="col-sm-6" v-for="address in row">
                <address-box :address="address"
                             :refreshDB="refreshAddress">

                </address-box>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</template>

<script>
    export default {
        props: ['addresses', 'refreshAddress']
    }
</script>