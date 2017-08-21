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
            'address'
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
            },

            /**
             * emits an event to the user-address component to perform a delete function
             * @return void
             */
            onDelete(){
                this.showConfirm = false;
                Event.$emit('delete-user-address', this.address);
            }
        }

    }
</script>
