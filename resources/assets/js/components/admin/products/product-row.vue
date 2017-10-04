<template>
    <tr>
        <td>
            <span class="table-element"><a href="javascript:void(0)" @click="toggleProduct" :id="product.title + '-id'" class="is-link">{{ product.title }}</a></span>
            <full-screen v-if="show.productDetails">
                <h3 slot="header">{{ product.title }}</h3>
                <div slot="body">
                    <view-product :product_id="product.id" :cancel="toggleProduct">

                    </view-product>
                </div>
            </full-screen>

        </td>
        <td><span class="table-element">{{ product.category.name }}</span></td>
        <td><span class="table-element">{{ product.price }}</span></td>
        <td>
            <span v-if="onSale">
                <full-screen v-if="show.saleDetails" @close="toggleSale">
                    <h3 slot="header">Sales Details</h3>
                    <div slot="body">
                        <view-sale-details :sale-id="product.sales[0].id" :cancel="toggleSale">

                        </view-sale-details>
                    </div>
                </full-screen>

                <button class="btn btn-success" @click="toggleSale">View Sale</button>
            </span>
            <span class="text-danger table-element" v-else>
                No Sale
            </span>
        </td>
        <td>
            <button :class="{'btn' : true, 'btn-primary' : onSale, 'btn-success' : !onSale}"
                    @click="show.saleForm = true">{{ slider.button.saleForm }}</button>
            <full-screen v-if="show.saleForm">
                <h3 slot="header">{{ slider.header.sale }}</h3>
                <div slot="body">
                    <sale-form :cancel="toggleSaleForm"
                               :refresh="refreshSale"
                               :sales="product.sales"
                               :onSale="onSale"
                               :product-id="product.id">

                    </sale-form>
                </div>
            </full-screen>
        </td>
        <td>
            <button class="btn btn-primary" @click="onEdit(product)">Edit Product</button>
        </td>
        <td>
            <delete-product-form :post_url="urls.delete"
                                 :product="product">
            </delete-product-form>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['product', 'onEdit', 'reset'],

        data : function() {
            return {
                onSale : {required: true, type : Boolean},
                urls : {
                    edit : {required: true, type : String},
                    delete : {required: true, type : String}
                },
                show : {
                    saleDetails : false,
                    saleForm : false,
                    productDetails : false
                },
                slider : {
                    header : {
                        sale : 'Add a Sale'
                    },
                    button : {
                        saleForm : 'Add Sale'
                    },
                }
            }
        },



        mounted() {
            this.urls.edit = window.Laravel.urls.product_url + '/' + this.product.id + '/edit';
            this.urls.delete = window.Laravel.urls.product_url + '/' + this.product.id;
            this.onSale = (this.product.sales.length > 0);
            if(this.onSale) {
                this.slider.header.sale = 'Edit this Sale';
                this.slider.button.saleForm = 'Edit Sale';
            }
        },

        watch: {
            /**
             *  If the product is updated then it must check if it is on sale
             *  @return void
             */
            product: function () {
                this.onSale = (this.product.sales.length > 0);
            },

        },

        methods: {
            /**
             * opens and closes the view sale details
             * @return void
             */
            toggleSale() {
                this.show.saleDetails = !this.show.saleDetails;
            },

            /**
             * opens and closes the view sale form
             * @return void
             */
            toggleSaleForm() {
                this.show.saleForm = !this.show.saleForm;
            },

            /**
             * opens and closes the view product modal
             * @return void
             */
            toggleProduct() {
                this.show.productDetails = !this.show.productDetails;
            },

            /**
             * refreshes data after a sale
             * @return void
             */
            refreshSale() {
                this.slider.button.saleForm = 'Edit Sale';
                this.slider.header.sale = 'Edit this sale';
                this.reset();
            }
        }
    }
</script>