<template>
    <message-modal>
        <div id="modal-message">{{ message }}</div>
    </message-modal>
</template>

<script>
    export default {
        props : ['message']
    }
</script>