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
                                   :states="states"
                                   @form-submit="toggleForm">

                </user-address-form>
            </div>
        </form-modal>
    </div>
</template>

<script>

    export default {
        props : [
            'address', 'states'
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
            }
        }

    }
</script>
