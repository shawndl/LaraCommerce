<template>
    <div class="well">
        <h4><u>Account Details:</u></h4>
        <p v-if="user">
            <strong>Name:</strong>  {{ user.first_name }} {{ user.last_name }} <br />
            <strong>Username: </strong>  {{ user.username }} <br />
            <strong>Email: </strong> {{ user.email }}
        </p>
    </div><!-- /.well -->
</template>

<script>
    export default {
        props: ['user']
    }
</script>