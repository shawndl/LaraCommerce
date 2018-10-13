<template>
    <form @submit.prevent="beforeSubmit">
        <div class="row">
            <div class="col-sm-6">
                <div :class="{'form-group': true, 'has-error' : errors.has('state-name')}">
                    <label for="state-name" class="control-label">Name: </label>
                    <input class="form-control"
                           type="text"
                           name="state-name"
                           id="state-name"
                           v-model="state.name"
                           v-validate="'required|alpha_spaces'">
                    <span class="help-block"
                          v-show="errors.has('state-name')">
                        <strong>{{ errors.first('state-name') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div :class="{'form-group': true, 'has-error' : errors.has('abbreviation')}">
                    <label>Percent </label>
                    <input class="form-control"
                           type="text"
                           name="abbreviation"
                           id="abbreviation"
                           v-model="state.abbreviation"
                           v-validate="'required|alpha'">
                    <span class="help-block"
                          v-show="errors.has('abbreviation')">
                        <strong>{{ errors.first('abbreviation') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="pull-left">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div><!-- /.pull-left -->
            <div class="pull-right">
                <button type="button" class="btn btn-danger" @click="close">Cancel</button>
            </div><!-- /.pull-right -->
        </div><!-- /.row -->
    </form>
</template>

<script>
    export default {
        props: ['isEdit', 'oldState', 'close', 'refresh'],
        data : function() {
            return {
                state : {
                    name : '',
                    abbreviation : ''
                }
            }
        },

        mounted() {
            if(this.isEdit) {
                this.setEditForm();
            }
        },

        methods: {
            /**
             * sets form values if it is an edit form
             *
             * @return void
             */
            setEditForm() {
                this.state = {
                    name : this.oldState.name,
                    abbreviation : this.oldState.abbreviation
                };
            },

            /**
             *  checks if the form passed validation before submitting results
             *  @return void
             */
            beforeSubmit() {
                let self = this;
                this.$validator.validateAll().then(() => {
                    if (!self.errors.any()) {
                        if(self.isEdit){
                            this.edit();
                        } else {
                            this.ajaxRequest(window.Laravel.urls.state_api_url);
                        }
                    }
                });
            },

            /**
             *  adds the patch to the method request
             *  @return void
             */
            edit() {
                this.state._method = 'patch';
                this.ajaxRequest(window.Laravel.urls.state_api_url + '/' + this.oldState.id);
            },

            /**
             *  performs an ajax request and updates the user message
             *  @return void
             */
            ajaxRequest(url) {
                let self = this;
                axios.post(url, this.state)
                    .then(
                        (response) => self.updateMessage(response.data)
                    )
                    .catch(
                        () => self.updateError()
                    );
            },

            /**
             *  updates the user message and closes the form
             *  @return void
             */
            updateMessage(data){
                Event.$emit('update-user-message', data.message);
                this.refresh();
                this.close();
            },

            /**
             * updates a user error
             */
            updateError(){
                Event.$emit('update-user-error', 'An error has occurred please try again!');
                this.close();
            }

        }
    }
</script>