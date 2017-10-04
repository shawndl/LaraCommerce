<template>
    <div v-if="products">
        <div class="pull-right">
            <button class="btn btn-primary" @click="show.form = true">Create New Product</button>
        </div><!-- /.row -->
        <full-screen v-if="show.form" :close="close">
            <h3 slot="header">{{ form.header }}</h3>
            <div slot="body">
                <product-form :reset="getProducts"
                              :oldProduct="form.product"
                              :cancel="close">

                </product-form>
            </div>
        </full-screen>
        <table class="table">
            <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>On Sale</th>
                <th>Edit Sale</th>
                <th>Update Product</th>
                <th>Delete Product</th>
            </tr>
            </thead>
            <tbody>
            <product-row v-for="product in products"
                         :key="product.id"
                         :product="product"
                         :onEdit="openEdit"
                         :reset="getProducts">

            </product-row>
            </tbody>
        </table>
        <paginate-items :number="last_page"
                        :current="page"
                        @select-page="setPage">

        </paginate-items>
    </div>
</template>

<script>
    export default {
        data : function() {
            return {
                products : null,
                page : 1,
                lastPage : {required :true, type : Number},
                pages : [],
                show : {
                    form : false
                },
                form : {
                    header : 'Add a Product',
                    isEdit : false,
                    product : null
                }
            }
        },

        created() {
            Event.$on('reset-products',
                () => this.getProducts()
            );
        },

        mounted() {
            this.getProducts();
        },

        methods : {
            /**
             * sets the new page
             * @param page
             * @return void
             */
            setPage(page) {
                this.page = page;
                this.getProducts();
            },

            /**
             * closes the form
             * @return void
             */
            close() {
                this.show.form = false;
                this.form.product = null;
            },

            openEdit(product) {
                this.show.form = true;
                this.form.header = 'Edit this Product!'
                this.form.product = product;
            },

            /**
             * sets the products property with an ajax request
             * @return void
             */
            getProducts() {
                let self = this;
                axios.get(window.Laravel.urls.product_api_url + '?page=' + this.page)
                    .then(function (response) {
                        self.page = response.data.products.current_page;
                        self.last_page = response.data.products.last_page;
                        self.products = response.data.products.data;
                    })
                    .catch(
                        () => self.updateError()
                    );
            },

            /**
             * sends an error if ajax request fails
             * @return void
             */
            updateError(){
                Event.$emit('update-user-error', 'An error has occurred please try again!')
            }
        }
    }
</script>