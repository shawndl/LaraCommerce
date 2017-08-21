<script>
    export default {
        props : [

        ],

        data : function () {
            return {
                cart: {
                    information: {
                        count: 0,
                        total: 0,
                        subTotal: 0,
                        taxes: 0
                    },
                    products: []
                },
                message : '',

                postData : {},
                showComponents : {
                    showSideBar : true,
                    showMessage : false,
                    fullScreen : false,
                }
            }
        },

        mounted() {
            this.getCart();
            this.setShowSideBar();
            this.$nextTick(
                () =>  window.addEventListener('resize', this.setShowSideBar)
            );
        },

        created() {
            Event.$on('update-user-message',
                (message) => this.displayMessage(message)
            );
            Event.$on('close-user-message',
                () => this.closeMessage()
            );
            Event.$on('update-user-cart',
                (value) => this.updateCart(value)
            );
            Event.$on('remove-item-cart',
                (value) => this.removeItem(value)
            );
            Event.$on('update-user-error',
                (message) => this.displayMessage(message)
            );
            Event.$on('reset-users-cart',
                () => this.cart = {
                    information: {
                        count: 0,
                        total: 0,
                        subTotal: 0,
                        taxes: 0
                    },
                    products: []
                },
            );

            Event.$on('full-screen-window',
                () => this.showComponents.fullScreen = true
            );
        },

        methods: {
            /**
             * sets if the sidebar should be shown based on the screen size
             * @return {void}
             */
            setShowSideBar() {
                if(document.documentElement.clientWidth < 979) {
                    this.showComponents.showSideBar = false;
                    return;
                }
                this.showComponents.showSideBar = true;
            },

            /**
             * ajax requrest to get the current cart information
             * and set to cart
             * @return {void}
             */
            getCart() {
                self = this;
                axios.get(Laravel.urls.shopping_cart)
                    .then(function (response) {
                        self.cart = response.data.cart;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

             /**
             * gets the post data from the child classes and sets the postData property
             * then it calls the ajax post request method to add to send the data to the
             * server
             * @param {value} post data sent from child class
             * @return {void}
             */
            addToCart(value) {
                this.postData = value;
                this.ajaxPostRequest(Laravel.urls.shopping_cart_add);
            },

            /**
             * ajax request to update the current cart
             * @return {void}
             */
            updateCart(value) {
                this.postData = value;
                this.ajaxPostRequest(Laravel.urls.shopping_cart_update);
            },

            /**
             * ajax request to remove an item from the current cart
             * @return {void}
             */
            removeItem(value) {
                this.postData = {product : value};
                this.ajaxPostRequest(Laravel.urls.shopping_cart_delete);
            },

            /**
             * sends a post ajax request to server and sets the message and cart property
             * @param url
             * @param data
             * @return {void}
             */
            ajaxPostRequest(url) {
                self = this;
                axios.post(url, this.postData)
                    .then(function (response) {
                        self.cart = response.data.cart;
                        self.displayMessage(response.data.message);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            /**
             * displays a message to the user for 3 seconds
             * @return void
             */
            displayMessage(message) {
                this.message = message;
                this.openMessage();
            },

            /**
             * open the message box
             * @return void
             */
            openMessage() {
                this.showComponents.showMessage = true;
            },

            /**
             * close the message box
             * @return void
             */
            closeMessage() {
                this.showComponents.showMessage = false;
            }
        }
    }
</script>