<template>
    <tr>
        <td class="table-element">{{ tax.name }}</td>
        <td class="table-element">{{ tax.percent }}</td>
        <td>
            <button class="btn btn-primary" @click="editTax(tax)">Edit Tax</button>
        </td>
        <td>
            <delete-tax-button :tax="tax"
                               :refresh="refreshTaxes">

            </delete-tax-button>
        </td>
    </tr>
</template>

<script>
    export default {
        props : ['tax', 'editTax', 'refreshTaxes'],

        data : function() {
            return {

            }
        },

        methods : {
            openEdit() {
                this.$emit('open-edit-tax', this.tax);
            }
        }
    }
</script>