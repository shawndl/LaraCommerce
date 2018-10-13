<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-header">
                    <slot name="header">
                        default header
                    </slot>
                </div><!-- /.modal-header -->
                <div class="modal-body">
                    <slot name="body">default body</slot>
                </div><!-- /.modal-body -->
                <div class="modal-footer">
                    <slot name="footer">
                        <div class="row">
                            <div class="col-xs-3 col-xs-offset-3">
                                <button class="btn btn-primary" @click="confirm">OK</button>
                            </div><!-- /.col -->
                            <div class="col-xs-3 col-xs-offset-1">
                                <button class="btn btn-danger" @click="cancel">Cancel</button>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </slot>
                </div><!-- /.modal-footer -->
            </div><!-- /.modal-container -->
        </div><!-- /.modal-wrapper -->
    </div><!-- /.modal-mask -->
</template>

<script>
    export default {
        methods: {
            /**
             * emits message to parent that the user confirmed the action
             * @return {void}
             */
            confirm(e) {
                e.preventDefault();
                this.$emit('confirm');
            },

            /**
             * emits message to the parent class that the user canceled the action
             * @return {void}
             */
            cancel() {
                this.$emit('cancel');
            }
        }


    }
</script>

<style>
    .modal-container {
        width: 300px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }
</style>