<template>
    <div>
        <div @click="toggleForm">
            <span>Edit</span>
        </div>
        <form-modal v-if="showForm"
                    @cancel-modal-form="showForm = false">
            <h3 slot="header">Edit this Address</h3>
            <div slot="body">
                <user-address-form :editAddress="address"
                                   @form-submit="formSubmit">

                </user-address-form>
            </div>
        </form-modal>
    </div>
</template>

<script>

    export default {
        props : [
            'address', 'refresh'
        ],

        data : function() {
            return {
                showForm : false
            }
        },

        methods: {
            /**
             * toggle the address modal
             * @return void
             */
            toggleForm() {
                this.showForm = !this.showForm;
            },

            /**
             * closes the form and refreshes the addresses on the screen
             * @return void
             */
            formSubmit() {
                this.refresh();
                this.showForm = false;
            },
        }

    }
</script>
