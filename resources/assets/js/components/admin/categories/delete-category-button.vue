<template>
    <div>
        <button class="btn btn-danger" @click="showModal=true">Delete Category</button>
        <confirm-modal v-if="showModal"
                       @cancel="close()"
                       @confirm="onDelete">
            <h3 slot="header">Delete {{ category.name }}</h3>
            <p slot="body">
                Are you sure you want to delete this category?
            </p>
        </confirm-modal>
    </div>
</template>

<script>
    export default {
        props : ['category'],

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
                let self = this;
                axios.post(window.Laravel.urls.category_api_url + '/' + self.category.id, self.post)
                    .then(
                        (response) => self.updateMessage(response.data.message)
                    )
                    .catch(
                        () => self.updateError()
                    )
            },


            /**
             * updates a user error
             * @param message
             * @return void
             */
            updateMessage(message) {
                this.showButton = true;
                Event.$emit('update-user-message', message);
                Event.$emit('refresh-categories');
            },

            /**
             * updates a user error
             * @return void
             */
            updateError(){
                Event.$emit('update-user-error', 'An error has occurred please try again!');
                this.showButton = true;
            }
        }
    }
</script>