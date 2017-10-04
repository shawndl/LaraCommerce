<template>
    <slide-out-animation>
        <div class="full-screen-container">
            <div class="full-screen-header">
                <slot name="header">
                    default header
                </slot>
            </div>
            <div>
                <slot name="body">
                    default body
                </slot>
            </div>
        </div><!-- /.full-screen-container -->
    </slide-out-animation>
</template>

<script>
    export default {
        props : ['close']
    }
</script>

<style scoped>
    .full-screen-container {
        position: absolute;
        top: 10%;
        left: 10%;
        overflow: auto;
        border: 1px solid #8c8c8c;
        border-radius: 5px;
        background-color: #DDDDDD;
        margin: 0;
        padding: 20px;
        width: 80%;
        height: auto;
        z-index: 1000;
    }

    .full-screen-header{
        color: #2A3F54;
        text-align: center;
        padding: 5px;
    }
</style>