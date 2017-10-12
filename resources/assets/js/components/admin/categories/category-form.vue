<template>
    <form @submit.prevent="beforeSubmit">
        <div :class="{'form-group': true, 'has-error' : errors.has('category_name')}">
            <label :for="categoryID" class="control-label">Name: </label>
            <input class="form-control"
                   type="text"
                   v-validate="'required|alpha_spaces'"
                   :name="categoryID"
                   id="category_name"
                   v-model="category.name">
            <span class="help-block"
                  v-show="errors.has('category_name')">
                    <strong>{{ errors.first('category_name') }}</strong>
                </span>
        </div><!-- /.form-group -->
        <button class="btn btn-primary" type="submit">{{ submitButtonMessage }}</button>
    </form>
</template>

<script>
    export default {
        props : ['currentCategory'],

        data: function () {
            return {
                category: {
                    name: null,
                },
                categoryID : 'category_name',
                isEdit : false,
                submitButtonMessage : 'Add'
            }
        },

        mounted() {
            if(this.currentCategory) {
                this.category.name = this.currentCategory.name;
                this.category._method = 'PATCH';
                this.isEdit = true;
                this.submitButtonMessage = 'Edit'
                this.categoryID = this.categoryID + '_' + this.currentCategory.name;
            }

        },

        methods: {
            /**
             * if validation passes it submits an ajax request
             * @return void
             */
            beforeSubmit() {
                let self = this;
                let url = (this.isEdit) ? window.Laravel.urls.category_api_url + '/' + self.currentCategory.id
                    : window.Laravel.urls.category_api_url
                this.$validator.validateAll().then(function() {
                    if (!self.errors.any()) {
                        self.ajaxRequest(url);
                    }

                });
            },

            /**
             *  Sends an ajax requests for a new or update a category
             *  @return void
             */
            ajaxRequest(url){
                axios.post(url, this.category)
                    .then(
                        (response) => this.updateMessage(response.data.message)
                    )
                    .catch(
                        () => this.updateError()
                    );
            },

            /**
             * updates a user error
             * @param message
             */
            updateMessage(message) {
                this.showButton = true;
                Event.$emit('update-user-message', message);
                Event.$emit('refresh-categories');
                this.$emit('close-form');
                if(!this.isEdit) {
                    this.category.name = '';
                    this.$validator.clean();
                }
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