<template>
    <div>
        <select-user-address v-if="isForm"
                             :addresses="addresses"
                             :states="states"
                             :order_id="order_id"
                             :refreshAddress="getAddresses">

        </select-user-address>
        <user-account-address v-else
                              :addresses="addresses">

        </user-account-address>
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

        created() {
            Event.$on('submit-user-address',
                (details) => this.onAdd(details)
            );

            Event.$on('delete-user-address',
                (address) => this.onDelete(address.id)
            );
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

