<template>
    <div>
        <h4>Where do you want the package shipped</h4>
        <add-new-address :refresh="refreshAddress">

        </add-new-address>
        <form  @submit.prevent="beforeSubmit">
            <div :class="{'form-group': true, 'has-error' : errors.has('address')}">
                <div class="row-fluid">
                    <div class="span12 text-center">
                       <span class="help-block"
                             v-show="errors.has('address')">
                           <strong>{{ errors.first('address') }}</strong>
                        </span>
                    </div><!-- text-center -->
                </div><!-- /.row-fluid -->
                <div class="row" v-for="(row, rowKey) in addresses">
                    <div class="col-sm-6" v-for="(address, colKey) in row">
                        <div :class="{'address-box' : true, 'active' : isActive(address.id)}">
                            <label :for="address.id" class="address-details">
                                <p>{{ address.street_address }}  </p>
                                <p>{{ address.city }}, {{ address.state }}, {{ address.postal_code }}</p>
                                <input class="address-radio-button"
                                       type="radio"
                                       :id="address.id"
                                       name="address"
                                       v-validate="'required'"
                                       :value="address.id"
                                       v-model="pickedAddress">
                            </label>
                            <div class="address-box-footer">
                                <div class="address-edit-button">
                                    <edit-address :address="address"
                                                  :refresh="refreshAddress">

                                    </edit-address>
                                </div><!-- /.address-edit -->
                                <div class="address-delete-button">
                                    <delete-address :address="address"
                                                    :refresh="refreshAddress">

                                    </delete-address>
                                </div><!-- /.address-edit -->
                            </div><!-- /.address-footer-box -->
                        </div><!-- /.address-box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.form-group -->
            <div class="row">
                <div class="col-sm-2 col-sm-offset-5">
                    <input class="btn btn-primary" type="submit"/>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </form>
    </div>
</template>

<script>
    export default {
        props : [
            'addresses', 'order_id', 'refreshAddress'
        ],

        data: function() {
            return {
                pickedAddress : ''
            }
        },

        methods: {
            /**
             * should active class be applied
             * This is used in the template for address-boxes div
             * @param id
             * @return {boolean}
             */
            isActive(id) {
                return (id === this.pickedAddress);
            },

            /**
             * selects the current address
             * @return {void}
             */
            beforeSubmit() {
                let self = this;
                let post = {address_id : this.pickedAddress};
                this.$validator.validateAll().then(() => {
                    if(!self.order_id) {
                        self.ajaxRequest(window.Laravel.urls.order_url, post)
                    } else {
                        self.edit(post);
                    }
                });
            },

            /**
             * changes ajax request for an update
             * @return void
             */
            edit(post) {
                post._method = 'PATCH';
                let url = window.Laravel.urls.order_url + '/' + this.order_id;
                this.ajaxRequest(url, post);
            },

            /**
             * does an ajax request to the OrderController
             * @return void
             */
            ajaxRequest(url, post) {
                let self = this;
                axios.post(url, post)
                    .then(function (response) {
                        self.updateMessage(response.data)
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },

            /**
             * updates the users message
             * @return void
             */
            updateMessage(data) {
                Event.$emit('update-user-message', data.message)
                Event.$emit('user-pick-address', data);
            },

            /**
             * updates the users message
             * @return void
             */
            updateError() {
                Event.$emit('update-user-error', 'There was an error, please try again');
            }

        }
    }
</script>