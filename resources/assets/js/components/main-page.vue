<script>
    export default {
        props : [

        ],

        data : function () {
            return {
                message : '',
                errorMessage : '',
                showComponents : {
                    showSideBar : true,
                    showMessage : false,
                    showError : false,
                    fullScreen : false,
                    search : false
                }
            }
        },

        mounted() {
            //this.getCart(); //delete
            this.setShowSideBar();
            this.$nextTick(
                () =>  window.addEventListener('resize', this.setShowSideBar)
            );
        },

        created() {
            Event.$on('update-user-message',
                (message) => this.displayMessage(message)
            );
            Event.$on('update-user-error',
                (error) => this.displayError(error)
            );
            Event.$on('full-screen-window',
                () => this.showComponents.fullScreen = true
            );
            Event.$on('show-search-screen',
                () => this.showComponents.search = !this.showComponents.search
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
             * displays a message to the user for 5 seconds
             * @return void
             */
            displayMessage(message) {
                this.message = message;
                this.showComponents.showMessage = true;
                self = this;
                setTimeout(function() {
                    self.showComponents.showMessage = false;
                }, 3000);
            },

            /**
             * displays an error to the user for 5 seconds
             * @return void
             */
            displayError(error) {
                console.log(error);
                this.errorMessage = error;
                this.showComponents.showError = true;
                self = this;
                setTimeout(function() {
                    self.showComponents.showError = false;
                }, 3000);
            },
        }
    }
</script>