<template>
    <div>
        <div class="address-header">
            <button class="btn btn-success" @click="onNewAddress">Add an Address</button>
        </div>
        <form-modal v-if="showForm"
                    @cancel-modal-form="showForm = false">
            <h3 slot="header">Add a New Address</h3>
            <div slot="body">
                <user-address-form :states="states"
                                   @form-submit="toggleForm">

                </user-address-form>
            </div>
        </form-modal>
    </div>

</template>

<script>

    export default {
        props: ['states'],

        data : function() {
            return {
                showForm : false
            }
        },

        methods: {
            /**
             * sets the edit form to true so an address will not be set in the address form
             * and it will toggle the modal form
             * @return {void}
             */
            onNewAddress(){
                this.toggleForm();
            },

            /**
             * toggle the address modal
             * @return void
             */
            toggleForm() {
                this.showForm = !this.showForm;
            }

        }

    }
</script>

<style>
    .address-header {
        text-align: center;
    }
</style>
