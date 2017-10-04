<template>
    <div v-if="sale">
        <div class="row">
            <h4 class="mid_center">Product Details</h4>
            <div class="col-sm-6">
                <img :src="sale.product_thumbnail" :alt="'Image of ' + sale.product_title">
            </div><!-- /.col -->
            <div class="col-sm-6">
                <strong>Product: </strong>{{ sale.product_title }}
                <br />
                <strong>Category: </strong>{{ sale.category }}
                <br />
            </div><!-- /.col -->
        </div><!-- /.row -->
        <hr>
        <div class="row">
            <h4 class="mid_center">Sale Details</h4>
            <div class="col-sm-6">
                <strong>Discount: </strong>{{ sale.discount }}
                <br />
                <span class="product-title">Price: </span>
                <span class="price-cut">{{ sale.product_price }}</span>
                <br />
                <span class="product-title">Discount Price: </span>
                <span class="price-amount">{{ sale.discount_price }}</span>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <strong>Sale Start Date: </strong>{{ sale.sale_start }}
                <br />
                <strong>Sale Finish Date: </strong>{{ sale.sale_finish }}
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <button type="button" class="btn btn-danger" @click="cancel">Cancel</button>
        </div><!-- /.row -->
    </div>

</template>



<script type="text/javascript">
    export default {
        props : ['sale-id', 'cancel'],

        data () {
            return {
                sale : null
            }
        },

        mounted() {
            this.getSale();
        },

        methods : {
            getSale(){
                let self = this;
                axios.get(window.Laravel.urls.sale_url + '/' + this.saleId)
                    .then(
                        (response) => self.sale = response.data.sale
                    )
                    .catch();
            }
        }
    }
</script>