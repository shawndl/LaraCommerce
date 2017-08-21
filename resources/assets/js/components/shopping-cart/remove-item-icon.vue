<template>
    <div :class="mainClass">
        <div class="event-icon">
            <i :class="sizeClass" aria-hidden="true" @click="toggleModal"></i>
        </div>
        <confirm-modal v-show="showModal"
                       @confirm="updateCart"
                       @cancel="toggleModal">
            <h3 slot="header">Remove {{ product }}</h3>
            <p slot="body">Are you sure you want to remove {{ product }} from your order?</p>
        </confirm-modal>
    </div>

</template>

<script>
    export default {
        props : [
            'product_id', 'product','mainClass', 'sizeClass'
        ],

        data : function () {
            return {
                showModal : false
            }
        },

        methods: {
            /**
             * toggles the model between show and hide
             * @return {void}
             */
            toggleModal() {
                this.showModal = !this.showModal;
            },

            /**
             * emits message to parent class to remove this item from the cart
             * @return {void}
             */
            updateCart() {
                this.toggleModal();
                this.$emit('remove-item', this.product_id);
            }
        }
    }
</script>