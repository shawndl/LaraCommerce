<template>
    <form @submit.prevent="beforeSubmit">
        <div class="row">
            <div class="col-sm-6">
                <div :class="{'form-group': true, 'has-error' : errors.has('tax-name')}">
                    <label for="tax-name" class="control-label">Name: </label>
                    <input class="form-control"
                           type="text"
                           name="tax-name"
                           id="tax-name"
                           v-model="tax.name"
                           v-validate="'required|alpha_spaces'">
                    <span class="help-block"
                          v-show="errors.has('tax-name')">
                        <strong>{{ errors.first('tax-name') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div :class="{'form-group': true, 'has-error' : errors.has('tax-percent')}">
                    <label>Percent </label>
                    <input class="form-control"
                           type="text"
                           name="tax-percent"
                           id="tax-percent"
                           v-model="tax.percent"
                           v-validate="'required|regex:^[0.09]+.([1-90]+)'">
                    <span class="help-block"
                          v-show="errors.has('tax-percent')">
                        <strong>{{ errors.first('tax-percent') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-12">
                <div :class="{'form-group': true, 'has-error' : errors.has('tax-description')}">
                     <label for="tax-description" class="control-label">Description: </label>
                     <textarea class="form-control"
                               type="text"
                               id="tax-description"
                               name="tax-description"
                               v-model="tax.description"
                               v-validate="'required|regex:^[a-zA-Z190 .\'\?]+$'">

                     </textarea>
                    <span class="help-block"
                          v-show="errors.has('tax-description')">
                        <strong>{{ errors.first('tax-description') }}</strong>
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
        props: ['isEdit', 'oldTax', 'close', 'refreshTable'],
        data : function() {
            return {
                tax : {
                    name : '',
                    description : '',
                    percent : 0.00
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
                this.tax = {
                    name : this.oldTax.name,
                    description : this.oldTax.description,
                    percent : this.oldTax.percent
                };
            },

            /**
             *  checks if the form passed validation before submitting results
             *  @return void
             */
            beforeSubmit() {
                let self = this;
                this.$validator.validateAll().then(() => {
                    if(self.isEdit){
                        this.edit();
                    } else {
                        this.ajaxRequest(window.Laravel.urls.tax_api_url);
                    }
                });
            },

            /**
             *  adds the patch to the method request
             *  @return void
             */
            edit() {
                this.tax._method = 'patch';
                this.ajaxRequest(window.Laravel.urls.tax_api_url + '/' + this.oldTax.id);
            },

            /**
             *  performs an ajax request and updates the user message
             *  @return void
             */
            ajaxRequest(url) {
                let self = this;
                axios.post(url, this.tax)
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
                this.refreshTable();
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