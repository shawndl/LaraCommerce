<template>
    <div>
        <button class="btn btn-danger" @click="showModal = true">Delete Tax</button>
        <confirm-modal v-if="showModal"
                       @cancel="close()"
                       @confirm="onDelete">
            <h3 slot="header">Delete {{ tax.name }}</h3>
            <p slot="body">
                Are you sure you want to delete this tax?
            </p>
        </confirm-modal>
    </div>
</template>

<script>
    export default {
        props : ['tax', 'refresh'],

        data : function() {
            return {
                showModal : false,
                post : {
                    _method : 'DELETE'
                }
            }
        },

        methods: {
            /**
             * closes the confirm modal
             * @return void
             */
            close() {
                this.showModal = false;
            },

            /**
             * performs an ajax request to delete the category
             * @return void
             */
            onDelete(){
                axios.post(window.Laravel.urls.tax_api_url + '/' + this.tax.id, this.post)
                    .then(
                        (response) => this.updateMessage(response.data.message)
                    )
                    .catch(
                        () => this.updateError()
                    )
            },


            /**
             * updates a user error
             * @param message
             * @return void
             */
            updateMessage(message) {
                this.showModal= true;
                Event.$emit('update-user-message', message);
                this.refresh();
            },

            /**
             * updates a user error
             * @return void
             */
            updateError(){
                Event.$emit('update-user-error', 'An error has occurred please try again!');
                this.showModal = true;
            }
        }
    }
</script>