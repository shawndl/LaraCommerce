<template>
    <tr>
        <td class="table-element">{{ category.name }}</td>
        <td>
            <edit-category-button :category="category">

            </edit-category-button>
        </td>
        <td>
            <delete-category-button :category="category">

            </delete-category-button>
        </td>
    </tr>
</template>

<script>
    export default {
        props : ['category'],

        data : function() {
            return {

            }
        }
    }
</script>