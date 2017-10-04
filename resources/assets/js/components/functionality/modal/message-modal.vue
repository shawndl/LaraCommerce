<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="pull-right">
                    <i class="fa fa-times close-modal" id="close-icon" role="button"
                       aria-hidden="true" @click="cancel"></i>
                </div>
                <div class="modal-body">
                    <slot>default body</slot>
                </div><!-- /.modal-body -->
            </div><!-- /.modal-container -->
        </div><!-- /.modal-wrapper -->
    </div><!-- /.modal-mask -->
</template>

<script>
    export default {
        methods: {
            /**
             * emits message to the parent class that the user canceled the action
             * @return {void}
             */
            cancel() {
                Event.$emit('close-user-message');
            }
        }


    }
</script>
