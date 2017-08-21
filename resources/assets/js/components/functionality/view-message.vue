<template>
    <message-modal>
        <div>
            {{ message }}
        </div>
    </message-modal>
</template>

<script>
    export default {
        props : ['message']
    }
</script>