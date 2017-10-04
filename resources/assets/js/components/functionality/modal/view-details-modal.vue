<template>
    <div class="modal-wrapper">
        <div class="modal-container">
            <div class="modal-body">
                <slot name="body">
                    default body
                </slot>
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <slot name="footer">
                    <div class="row">
                        <div class="pull-right">
                            <button class="btn btn-danger" @click="close">Close</button>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </slot>
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-container -->
    </div><!-- /.modal-wrapper -->
</template>

<script>
    export default {
        methods: {
            /**
             * emits message to parent that the user confirmed the action
             * @return {void}
             */
            close() {
                this.$emit('close');
            }
        }


    }
</script>

<style>
    .modal-container {
        width: 60%;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
        position: absolute;
        top: 20px;
        left: 20%;
    }
</style>