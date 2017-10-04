<template>
    <div class="message-container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="alert alert-danger">
                    <strong>Error!</strong> {{ errorMessage }}
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</template>

<script>
    export default {
        props: ['error-message'],
    }
</script>

<style>

</style>