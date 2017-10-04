<template>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>

        <fade-out-animation>
            <tbody v-if="categories">
                <category-row v-for="category in categories"
                              :key="category.id"
                              :category="category"
                              @refresh-categories="refresh">

                </category-row>
            </tbody>
        </fade-out-animation>
    </table>
</template>

<script>
    export default {
        data : function() {
            return {
                categories : null
            }
        },

        created() {
            Event.$on('refresh-categories',
                () => this.refresh()
            );
        },

        mounted() {
            this.getCategories();
        },

        methods: {
            /**
             * performs an ajax request to get all categories
             * @return void
             */
            getCategories() {
                let self = this;
                this.categories = null;
                axios.get(window.Laravel.urls.category_api_url)
                    .then(
                        (response) => self.categories = response.data.categories
                    )
                    .catch()
            },

            /**
             * refreshes categories on edit, create, or delete
             * @return void
             */
            refresh(){
                this.getCategories();
            }
        }
    }
</script>