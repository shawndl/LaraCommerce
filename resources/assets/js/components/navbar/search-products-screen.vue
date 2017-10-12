<template>
    <div class="modal-mask">
        <form :action="searchURL" method="post">
            <input type="hidden" name="_token" :value="token" />
            <div class="form-group search-form">
                <div class="search-field">

                </div><!-- /.search-field -->
                <input class="form-control"
                       type="text"
                       placeholder="search"
                       name="search"
                       v-model="search"
                       v-on:keyup="toggleResults"
                       autocomplete="off"
                       v-on:keyup.esc="close">
                <button class="search-button" type="submit">
                    <i class="fa fa-search fa-lg" aria-hidden="true"></i>
                </button>
            </div><!-- /.form-group -->
            <div class="search-results" v-show="showResults">
                <ul>
                    <li v-for="product in searchResults">
                        <a :href="showProductsURL + '/' + product.title ">
                            <img :src="product.image">
                            <p><strong>{{ product.title }}</strong></p>
                            <p>${{ product.price }}</p>
                        </a>
                    </li>
                </ul>
            </div><!-- /.search-results -->
        </form>
    </div><!-- /.modal-mask -->
</template>


<script>
    export default {
        props: ['token', 'show', 'cart'],

        data : function () {
            return {
                showResults: false,
                searchURL: '',
                search: '',
                showProductsURL: '',
                searchResults: {}
            }
        },

        mounted() {
            this.searchURL = Laravel.urls.search_url;
            this.showProductsURL = Laravel.urls.show_product_url;
        },

        methods: {
            /**
             * toggles between opening and closing the search box
             *
             * @return void
             */
            toggleSearch() {
                this.showSearch = !this.showSearch;
            },

            /**
             * only show results if the user has enter 2 characters or more
             *
             * @return void
             */
            toggleResults() {
                if(this.search.length >= 2) {
                    this.showResults = true;
                    this.searchProducts();
                } else {
                    this.showResults = false;
                }
            },

            /**
             * closes search results
             * @return void
             */
            close() {
                Event.$emit('show-search-screen')
            },

            /**
             * performs an ajax request to User\API\SearchController@store
             * returns an array of related products and sets the products property
             * @return void
             */
            searchProducts() {
                let self = this;
                axios.post(Laravel.urls.search_url + '/api', {search : this.search})
                    .then((response) => self.searchResults = response.data.products)
                    .catch((error) => console.log(error));
            }
        }
    }
</script>


