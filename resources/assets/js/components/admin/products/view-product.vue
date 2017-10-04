<template>
    <div v-if="product">
        <div class="row">
            <div class="col-sm-6">
                <img class="detail-image" :src="product.thumbnail" :alt="'Image of ' + product.title">
            </div><!-- /.col -->
            <div class="col-sm-6">
                <span class="product-title">Price: </span> <span class="price-amount">${{ product.price }}</span>
                <br />
                <span class="product-title">Category: </span><span class="product-details">{{ product.category }}</span>
                <br />
                <span class="product-title">Weight: </span><span class="product-details">{{ product.weight }}</span>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-12">
                <p>{{ product.description }}</p>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <button class="btn btn-danger pull-right" @click="cancel">Cancel</button>
        </div><!-- /.row -->
    </div>
</template>

<script>
    export default {
        props: ['product_id', 'cancel'],

        data () {
            return {
                product : null
            }
        },

        mounted() {
            this.getProduct();
        },

        methods : {
            getProduct() {
                axios.get(window.Laravel.urls.product_url + '/' + this.product_id)
                    .then(
                        (response) => this.product = response.data.product
                    )
                    .catch();
            }
        }
    }
</script>

<style scoped>
    .detail-image{
        border-radius: 1px;
    }
</style>