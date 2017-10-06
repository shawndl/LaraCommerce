<template>
    <div v-if="accountDetails">
        <div class="page-header">
            <h1>Account Details</h1>
        </div>
        <user-account-header>

        </user-account-header>
        <div class="panel panel-primary" v-show="showAddress">
            <div class="panel-heading">
                <h4>
                    User's Addresses
                    <i class="fa fa-times close-modal pull-right"
                       aria-hidden="true" @click="toggleAddress"></i>
                </h4>
            </div><!-- /.panel-heading -->
            <div class="panel-body">
                <user-address :isForm="false">

                </user-address>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
        <div class="panel panel-default" v-show="showOrder">
            <div class="panel-heading">
                <h4>
                    User's Orders
                    <i class="fa fa-times close-modal pull-right"
                       aria-hidden="true" @click="toggleOrder"></i>
                </h4>
            </div><!-- /.panel-heading -->
            <div class="panel-body">
                <user-account-order :orders="accountDetails.orders">

                </user-account-order>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- root element -->
</template>

<script>
    export default {
        props: ['user'],

        data: function() {
            return {
                accountDetails : null,
                showAddress : true,
                showOrder : true
            }
        },

        mounted() {
            this.accountDetails = JSON.parse(this.user);
        },

        methods: {
            /**
             * toggles the user address panel between open and close
             *
             * @return void
             */
            toggleAddress() {
                this.showAddress = !this.showAddress;
            },

            /**
             * toggles the user orders panel between open and close
             *
             * @return void
             */
            toggleOrder() {
                this.showOrder = !this.showOrder;
            }
        }
    }
</script>