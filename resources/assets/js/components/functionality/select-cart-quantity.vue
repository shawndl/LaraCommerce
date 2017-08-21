<template>
    <div>
        <label for="quantity" v-show="showLabel">Quantity: </label>
        <select id="quantity" v-on:change="updateQuantity">
            <option v-for="quantity in quantities"
                    :selected="current == quantity ? 'selected' : ''"
                    :value="quantity">
                {{ quantity }}
            </option>
        </select>
    </div>
</template>

<script>
    export default {
        props : [
            'current', 'product_id', 'showLabel'
        ],

        data : function () {
            return {
                quantities: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                selected : null
            }
        },

        methods: {
            /**
             * emits event that the quantity was updated
             * @param event
             */
            updateQuantity(event) {
                this.$emit('quantity', {quantity : event.target.value, product : this.product_id})
            }
        }
    }
</script>