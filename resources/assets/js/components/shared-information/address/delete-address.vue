<template>
    <div>
        <div @click="toggleModal">
            <span>Delete</span>
        </div>
        <confirm-modal v-if="showConfirm"
                       @confirm="onDelete"
                       @cancel="showConfirm = false">
            <h3 slot="header">Delete this Address?</h3>
            <p slot="body">
                {{ address.address }} <br />
                {{ address.city + ', ' + address.state + address.postal_code }}
            </p>
        </confirm-modal>
    </div>

</template>

<script>

    export default {
        props : [
            'address', 'refresh'
        ],

        data : function() {
            return {
                showConfirm : false
            }
        },

        methods: {
            /**
             * toggle the address modal
             * @return void
             */
            toggleModal() {
                this.showConfirm = !this.showConfirm;
                //TODO: there is an error on the user account deletes but continue to refactor 
            },

            /**
             * emits an event to the user-address component to perform a delete function
             * @return void
             */
            onDelete(){
                this.showConfirm = false;
                this.ajaxRequest();
            },

            /**
             * Deletes the selected address with an ajax request
             * @return void
             */
            ajaxRequest() {
                let self = this;
                axios.post(window.Laravel.urls.address_url + '/' + this.address.id, {_method : 'Delete'})
                    .then(function (response) {
                        self.updateMessage(response.data);
                    })
                    .catch(function () {
                        self.updateError();
                    });
            },

            /**
             * displays a user message on success
             * @param data
             * @return void
             */
            updateMessage(data) {
                Event.$emit('update-user-message', data.message);
                this.showConfirm = false;
                this.refresh();
            },

            /**
             * displays an error message
             * @return void
             */
            updateError() {
                Event.$emit('update-user-error',
                    'An error occurred please try again!');
            }
        }

    }
</script>
