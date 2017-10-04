<template>
    <div>
        <div class="pull-right">
            <button class="btn btn-primary" @click="show.form = true">Create Tax</button>
        </div><!-- /.pull-right -->
        <full-screen v-if="show.form" :close="closeForm">
            <h3 slot="header">{{ form.header }}</h3>
            <div slot="body">
                <tax-form :oldTax="form.tax"
                          :isEdit="form.isEdit"
                          :close="closeForm"
                          :refreshTable="refresh">

                </tax-form>
            </div>
        </full-screen>


        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Percent</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <fade-out-animation>
                <tbody v-if="taxes">
                <tax-row v-for="tax in taxes"
                         :key="tax.id"
                         :tax="tax"
                         :editTax="openEdit">

                </tax-row>
                </tbody>
            </fade-out-animation>
        </table>
        <paginate-items v-if="taxes"
                        :number="lastPage"
                        :current="page"
                        @select-page="setPage">

        </paginate-items>
    </div>
</template>

<script>
    export default {
        data : function() {
            return {
                taxes : null,
                page : 1,
                lastPage : null,
                form : {
                    header : 'Add a Tax',
                    isEdit : false,
                    tax : null
                },
                show : {
                    form : false,
                    delete : false
                }
            }
        },

        created() {
            Event.$on('refresh-taxes',
                () => this.refresh()
            );
        },

        mounted() {
            this.getTaxes();
        },

        methods: {
            /**
             * performs an ajax request to get all taxes
             * @return void
             */
            getTaxes() {
                let self = this;
                this.taxes = null;
                axios.get(window.Laravel.urls.tax_api_url + '?page=' + this.page)
                    .then(
                        (response) => self.setProperties(response.data.taxes)
                    )
                    .catch(
                        () => self.setError()
                    )
            },

            /**
             * Sets properties if the ajax request was a success
             * @return void
             */
            setProperties(response) {
                this.page = response.current_page;
                this.lastPage = response.last_page;
                this.taxes = response.data;
            },

            /**
             * If there was an error it must emit an error
             * @return void
             */
            setError() {
                Event.$emit('update-user-error',  'There was an error retrieving the taxes.  Please try again later!')
            },

            /**
             * If the user registers an edit event it will open the edit form and set form values
             * @return void
             */
            openEdit(tax) {
                this.form.tax = tax;
                this.form.header = 'Edit this Tax';
                this.form.isEdit = true;
                this.show.form = true;
            },

            /**
             * closes the tax form and resets the values
             * @return void
             */
            closeForm() {
                this.show.form = false;
                this.form.header = 'Add a Tax';
                this.form.isEdit = false;
                this.form.tax = null;
            },

            /**
             * sets the new page
             * @param page
             * @return void
             */
            setPage(page) {
                this.page = page;
                this.refresh();
            },

            /**
             * refreshes categories on edit, create, or delete
             * @return void
             */
            refresh(){
                this.getTaxes();
            }
        }
    }
</script>