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
        props: ['user']
    }
</script>