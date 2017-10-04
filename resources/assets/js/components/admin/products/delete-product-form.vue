<template>
    <div>
        <button class="btn btn-danger" id="delete-button" @click="open()">Delete</button>
        <confirm-modal v-if="showModal"
                       @cancel="close()"
                       @confirm="onDelete">
            <h3 slot="header">Delete {{ product.title }}</h3>
            <p slot="body">
                <img :src="product.image.thumbnail" :alt="'Image of ' + product.title">
            </p>
        </confirm-modal>
    </div>

</template>

<script>
    export default {
        props: ['post_url', 'product'],

        data : function() {
            return {
                showModal : false,
            }
        },

        methods: {
            /**
             * opens the confirm model
             * @return void
             */
            open() {
                this.showModal = true;
            },

            /**
             * closes the confirm model
             * @return void
             */
            close() {
                this.showModal = false;
            },

            /**
             * emits an event to the user-address component to perform a delete function
             * @return void
             */
            onDelete(){
                let self = this;
                axios.post(this.post_url, {
                    _method: 'DELETE'
                })
                    .then(function (response) {
                        self.updateMessage(response.data.message);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                this.close();
            },

            /**
             * emits a success message to the user
             */
            updateMessage(message) {
                Event.$emit('update-user-message', message);
                Event.$emit('reset-products');
                this.close();
            }
        }
    }
</script>