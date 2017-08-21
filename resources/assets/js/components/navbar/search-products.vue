<template>
    <li>
        <a href="#" @click="toggleSearch">
            <i class="fa fa-search" aria-hidden="true"></i>
        </a>
        <div class="modal-mask" v-show="showSearch">
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
                           autocomplete="off">
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
                </div>
            </form>
        </div><!-- /.modal-mask -->
    </li><!-- root -->
</template>

<script>
    export default {
        props: ['token'],

        data : function () {
            return {
                showSearch : false,
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

<style>
    .search-form {
        top: 60px;
        position: fixed;
        left: 35%;
        text-align: center;
        display: flex;
    }

    .search-form input {
        width: 350px;
        height: 50px;
        font-size: 1.5em;
        border: 0;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
        cursor: auto;
        text-align: center;
        border-radius: 10px 0 0 10px;
    }

    .search-form input:focus {
        background-color: #DDDDDD;
    }

    .search-results {
        background-color: #f5f5f5;
        padding: 10px;
        position: fixed;
        width: 400px;
        left: 35%;
        top: 112px;
        border-radius: 5px;
    }

    .search-results ul{
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .search-results ul li {
        padding: 4px 0 0 4px;
        margin: 0;
        border-bottom: 1px solid #DDDDDD;
    }

    .search-results ul li a{
        display: flex;
        cursor: pointer;
        text-decoration: none;
    }

    .search-results ul li:hover {
        background-color: #8c8c8c;
    }

    .search-results ul li p {
        color: #000000;
        font-size: 14px;
        padding: 18px;
        margin: 0;
    }

    .search-results ul li img {
        height: 50px;
        width: auto;
    }

    .search-button{
        border: 0;
        width: 50px;
        border-radius: 0 5px 5px 0;
        background-color: rgba(0, 0, 0, .5);
        color: #FFFFFF;
    }
</style>

