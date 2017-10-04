<script>
    export default {
        data : function () {
            return {
                message : '',
                errorMessage : '',
                showComponents : {
                    showMessage : false,
                    showError : false,
                    showSideBar : true
                }
            }
        },

        created() {
            Event.$on('update-user-message',
                (message) => this.displayMessage(message)
            );
            Event.$on('close-user-message',
                () => this.closeMessage()
            );
            Event.$on('update-user-error',
                (error) => this.displayError(error)
            );
        },

        mounted() {
            this.setSideBar();
            this.$nextTick(
                () =>  window.addEventListener('resize', this.setSideBar)
            );
        },

        methods: {
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
                }, 5000);
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
                }, 5000);
            },

            /**
             * toggles the sidebar
             * @return void
             */
            toggleSideBar() {
                this.showComponents.showSideBar = !this.showComponents.showSideBar;
            },

            /**
             * sets if the sidebar should be open based on the screen size
             * @return void
             */
            setSideBar() {
                if(document.documentElement.clientWidth < 978) {
                    this.showComponents.showSideBar = false;
                    return;
                }
                this.showComponents.showSideBar = true;
            }
        }
    }
</script>