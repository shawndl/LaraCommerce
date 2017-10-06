<template>
    <div>
        <fade-out-animation v-if="isForm">
            <select-user-address v-if="addresses"
                                 :addresses="addresses"
                                 :order_id="order_id"
                                 :refreshAddress="getAddresses">

            </select-user-address>
        </fade-out-animation>
        <fade-out-animation v-else>
            <user-account-address v-if="addresses"
                                  :addresses="addresses"
                                  :refreshAddress="getAddresses">

            </user-account-address>
        </fade-out-animation>
    </div>
</template>

<script>

    export default {
        props : ['isForm', 'order_id'],

        data : function() {
            return {
                addresses : null,
                states : null
            }
        },

        mounted() {
            this.getAddresses();
        },

        methods: {
            /**
             * Performs an ajax request to get the users addresses
             * @return {void}
             */
            getAddresses() {
                this.addresses = null;
                axios.get(window.Laravel.urls.address_url)
                    .then(
                        (response) => this.formatAddresses(response.data.addresses)
                    )
                    .catch(
                        () => this.updateError()
                    );
            },

            /**
             * formats the addresses into chunks of 2 to 3 depending on the window screen
             * these chunks are used by the child class to create bootstrap rows with columns
             * @param addresses
             * @return {void}
             */
            formatAddresses(addresses) {
                this.addresses = _.chunk(addresses, 2);
            },

            /**
             * updates the error property in the parent component
             * @param error
             */
            updateError() {
                Event.$emit('update-user-error',
                    'There was an error retrieving your addresses, please try again!');
            }
        }
    }
</script>

