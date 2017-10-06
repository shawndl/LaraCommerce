<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>User's Details</h3>
        </div><!-- /.panel-heading -->
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <user-details :user="user">

                    </user-details>
                </div><!-- /.col -->
                <div class="col-sm-6">

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.panel-body -->
    </div><!-- /.panel -->
</template>

<script>
    export default {
        data: function() {
            return {
                user : null
            }
        },

        mounted() {
            this.getUser();
        },

        methods : {
            /**
             * sends an ajax request to get the user
             * @return void
             */
            getUser(){
                axios.get(window.Laravel.urls.users_url)
                    .then(
                        (response) => this.user = response.data.user
                    )
                    .catch(
                        () => this.updateError()
                    );
            },

            /**
             * if there is an error with the ajax report it will send an ajax request
             * @return void
             */
            updateError(){
                Event.$emit('update-user-error', 'An error retrieving your user account information, please try again!');
            }
        },
    }
</script>