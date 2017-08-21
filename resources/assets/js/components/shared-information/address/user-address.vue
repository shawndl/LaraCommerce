<template>
    <div>
        <select-user-address v-if="(states && isForm)"
                           :addresses="userAddresses"
                           :states="states">

        </select-user-address>
        <user-account-address v-if="(states && userAddresses && !isForm)"
                              :addresses="userAddresses"
                              :states="states">

        </user-account-address>
    </div>
</template>

<script>

    export default {
        props : [
            'addresses', 'isForm'
        ],

        data : function() {
            return {
                userAddresses : null,
                states : null
            }
        },

        mounted() {
            this.formatAddresses(this.addresses);
            this.setStates();
        },

        created() {
            Event.$on('submit-user-address',
                (details) => this.onAdd(details)
            );

            Event.$on('delete-user-address',
                (address) => this.onDelete(address.id)
            );
        },

        methods: {
            /**
             * formats the addresses into chunks of 2 to 3 depending on the window screen
             * these chunks are used by the child class to create bootstrap rows with columns
             * @param addresses
             * @return {void}
             */
            formatAddresses(addresses) {
                this.userAddresses = _.chunk(addresses, 2);
            },

            /**
             * performs an ajax request for the states
             * @return {void}
             */
            setStates() {
                let self = this;
                axios.get(window.Laravel.urls.state_url)
                    .then(function (response) {
                        self.states = response.data.states;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            /**
             * when the child class confirms the update the method will send an ajax request
             * to the server to delete the address
             * @return void
             */
            onDelete(address) {
                let self = this;
                axios.post(window.Laravel.urls.address_url + '/' + address, {_method : 'Delete'})
                    .then(function (response) {
                        self.updateMessage(response.data.message);
                        self.formatAddresses(response.data.addresses);
                    })
                    .catch(function (error) {
                        self.updateError(error);
                    });
            },

            /**
             * performs an ajax request to either update or create a new address
             * @param details

             * @return {void}
             */
            onAdd(details) {
                let self = this;
                axios.post(details.url, details.form)
                    .then(function (response) {
                        self.formatAddresses(response.data.addresses);
                        self.updateMessage(response.data.message);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            /**
             * updates the message property in the parent component
             * @return {void}
             */
            updateMessage(message) {
                Event.$emit('update-user-message', message);
            },

            /**
             * updates the error property in the parent component
             * @param error
             */
            updateError(error) {
                //TODO: add error property
            }
        }
    }
</script>

