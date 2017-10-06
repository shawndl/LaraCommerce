<template>
    <form class="address-form" @submit.prevent="beforeSubmit">
        <div class="row">
            <div class="col-sm-12">
                <div :class="{'form-group': true, 'has-error' : errors.has('street_address')}">
                    <label for="street_address" class="control-label">Address: </label>
                    <input class="form-control"
                           id="street_address"
                           type="text"
                           name="street_address"
                           v-validate="'required|regex:^[A-Za-z0-9.\\s\\/]+$'"
                           v-model="address.street_address">
                    <span class="help-block"
                          v-show="errors.has('street_address')">
                        <strong>{{ errors.first('street_address') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-6" v-if="states">
                <div :class="{'form-group': true, 'has-error' : errors.has('state')}">
                    <label for="state" class="control-label">State:</label>
                    <select name="state"
                            id="state"
                            class="form-control"
                            v-validate="'required'"
                            v-model="address.state"
                          >
                        <option></option>
                        <option v-for="(state, id) in states"
                                :value="id">{{ state }}
                        </option>
                    </select>
                    <span class="help-block"
                          v-show="errors.has('state')">
                        <strong>{{ errors.first('state') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div :class="{'form-group': true, 'has-error' : errors.has('city')}">
                    <label for="city" class="control-label">City: </label>
                    <input  type="text"
                            name="city"
                            id="city"
                            class="form-control"
                            v-validate="'required|alpha_spaces'"
                            v-model="address.city">
                    <span class="help-block"
                          v-show="errors.has('city')">
                        <strong>{{ errors.first('city') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-6">
                <div :class="{'form-group': true, 'has-error' : errors.has('postal_code')}">
                    <label for="postal_code" class="control-label">Postal Code: </label>
                    <input class="form-control"
                           id="postal_code"
                           name="postal_code"
                           type="text"
                           v-validate="'required|between:1000, 99999'"
                           v-model="address.postal_code">
                    <span class="help-block"
                          v-show="errors.has('postal_code')">
                        <strong>{{ errors.first('postal_code') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-12">
                <button class="btn btn-danger pull-right" type="button" @click="close">Cancel</button>
                <button class="btn btn-primary pull-left" type="submit">Submit</button>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </form>
</template>

<script>
    export default {
        props : ['editAddress', 'close'],

        data : function () {
            return {
                states : null,
                address : {
                    street_address : '',
                    state : '',
                    city : '',
                    postal_code : ''
                }
            }
        },

        mounted() {
            this.setStates();
            if(this.editAddress) {
                this.setAddress();
            }
        },

        methods : {
            /**
             * performs an ajax request for the states
             * @return {void}
             */
            setStates() {
                let self = this;
                axios.get(window.Laravel.urls.state_url)
                    .then(function (response) {
                        self.states = response.data.states;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            /**
             * sets the address when the user is editing an address
             * it will bind the values to the form fields
             * @return {void}
             */
            setAddress() {
                this.address = {
                    street_address : this.editAddress.street_address,
                    postal_code : this.editAddress.postal_code,
                    state : this.editAddress.state_id,
                    city: this.editAddress.city

                };
            },

            /**
             * prevents the form from being submitted unless it passes validation
             * @return {boolean}
             */
            beforeSubmit() {
                this.$validator.validateAll().then(() => {
                    if(this.editAddress) {
                        this.edit();
                    } else {
                        this.ajaxRequest(window.Laravel.urls.address_url)
                    }
                });
            },

            /**
             * on edit it will add patch and change url
             * @return {boolean}
             */
            edit() {
                this.address._method = 'patch';
                this.ajaxRequest(window.Laravel.urls.address_url + '/' + this.editAddress.id);

            },

            /**
             * performs an ajax request to add or edit an address
             * @return {boolean}
             */
            ajaxRequest(url) {
                axios.post(url, this.address)
                    .then(
                        (response) => this.updateMessage(response.data)
                    )
                    .catch(
                        (error) => console.log(error)
                    );
            },

            /**
             * Displays a user message
             * @param data
             * @return void
             */
            updateMessage(data) {
                Event.$emit('update-user-message', data.message);
                this.$emit('form-submit');
            },

            /**
             * Displays a user error
             * @return void
             */
            updateError() {
                Event.$emit('update-user-message', data.message);
                this.close();
            }
        }
    }
</script>

<style>
    .address-form {
        text-align: left;
        color: #636b6f;
    }
</style>

