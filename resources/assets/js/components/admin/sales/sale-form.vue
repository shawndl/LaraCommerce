<template>
    <form @submit.prevent="beforeSubmit">
        <div class="row">
            <div class="col-sm-6">
                <input-date :label="'Sale Start Date:'"
                            :name="'sales-start'"
                            :error="fieldErrors.start"
                            @date-change="setDate($event)">

                </input-date>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <input-date :label="'Sale Finish Date:'"
                            :name="'sales-finish'"
                            :error="fieldErrors.finish"
                            @date-change="setDate($event)">

                </input-date>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-6">
                <div :class="{'form-group': true, 'has-error' : fieldErrors.discount}">
                    <label for="sale-discount" class="control-label">Discount:</label>
                    <select class="form-control"
                            id="sale-discount"
                            v-model="sale.discount"
                            name="sale-discount"
                            @change="validateFields()">
                        <option></option>
                        <option value="0.05">5%</option>
                        <option value="0.10">10%</option>
                        <option value="0.15">15%</option>
                        <option value="0.20">20%</option>
                        <option value="0.25">25%</option>
                        <option value="0.30">30%</option>
                        <option value="0.35">35%</option>
                        <option value="0.40">40%</option>
                        <option value="0.45">45%</option>
                        <option value="0.50">50%</option>
                        <option value="0.55">55%</option>
                        <option value="0.60">60%</option>
                        <option value="0.65">65%</option>
                        <option value="0.70">70%</option>
                        <option value="0.75">75%</option>
                        <option value="0.80">80%</option>
                        <option value="0.85">85%</option>
                        <option value="0.90">90%</option>
                        <option value="0.95">95%</option>
                    </select>
                    <span class="help-block"
                          v-show="fieldErrors.discount">
                                    <strong>The discount field is required.</strong>
                                </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-12 ">
                <button type="submit" id="sale-submit" class="btn btn-success pull-left">{{ button.submit }}</button>
                <button type="button" class="btn btn-danger pull-right" @click="cancel">Cancel</button>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </form>
</template>

<script>
    import moment from 'moment';

    export default {
        props : ['sales', 'onSale', 'product-id', 'cancel', 'refresh'],

        data : function() {
            return {
                sale : {
                    start : null,
                    finish : null,
                    discount : null,
                    product_id : {required : true, type : Number}
                },
                button : {
                    submit : 'Add',
                },
                config : {
                    format : 'YYYY-MM-DD',
                    allowInputToggle :true
                },
                fieldErrors : {
                    start : false,
                    finish : false,
                    discount : false
                }
            }
        },

        mounted() {
            this.setProperties();
        },

        watch: {
            /**
             *  If the product is updated then it must check if it is on sale
             *  @return void
             */
            sales: function () {
                this.onSale = (this.sales.length > 0);
                this.setProperties()
            },

        },

        methods: {
            /**
             * when the component is mounted or if sales are updated then it will update the properties
             * @return void
             */
            setProperties() {
                this.sale = {};
                this.button.submit = (this.onSale) ? 'Edit Sale' : 'Add Sale';
                if(this.onSale) {
                    this.fillOutForm();
                }
                this.sale.product_id = this.productId;
            },

            /**
             * uses the sale property to fill out the sales form if is edit
             * @return void
             */
            fillOutForm() {
                this.sale = {
                    start : this.sales[0].start,
                    finish : this.sales[0].finish,
                    discount : this.sales[0].discount
                };
            },

            /**
             * when a date change event is fired from the input-date component
             * this function will set the value and validate
             * @return void
             */
            setDate($event){
                if($event.name == 'sales-start') {
                    this.sale.start = $event.date;
                }
                if($event.name == 'sales-finish') {
                    this.sale.finish = $event.date;
                }
                this.validateFields();
            },

            /**
             *  is there any errors
             *  @return boolean
             */
            hasError(){
               return (this.fieldErrors.start !== false || this.fieldErrors.finish !== false);
            },

            /**
             *  is there any errors
             *  @return boolean
             */
            validateDateRequired(){
                if(this.sale.start === null) {
                    this.fieldErrors.start = 'The start date field is required!';
                } else {
                    this.fieldErrors.start = false;
                }

                if(this.sale.finish === null) {
                    this.fieldErrors.finish = 'The finish date field is required!';
                }else {
                    this.fieldErrors.finish = false;
                }

                if(this.sale.discount === null) {
                    this.fieldErrors.discount = 'The discount field is required!';
                }else {
                    this.fieldErrors.discount = false;
                }
            },

            /**
             *  Checks if the start date is before the finish date
             *  And sets an error message
             *  @return void
             */
            validateDateCompare() {
                if(this.sale.start === null || this.sale.finish === null) {
                    return;
                }
                let start = new Date(this.sale.start);
                let finish = new Date(this.sale.finish);
                if(start.getTime() > finish.getTime()) {
                    this.fieldErrors.start = 'The start date must be before the finish date';
                } else {
                    this.fieldErrors.start = false;
                }
            },

            /**
             *  validates each field and displays error messages
             *  @return void
             */
            validateFields() {
                this.validateDateRequired();
                if(this.hasError()) {
                    return;
                }
                this.validateDateCompare();

            },

            /**
             *  checks if the form passed validation before submitting results
             *  @return void
             */
            beforeSubmit(){
                this.validateFields();
                if(this.hasError()) {
                    return;
                }
                if(this.onSale) {
                    this.edit();
                    console.log('editing');
                } else {
                    this.ajaxRequest(window.Laravel.urls.sale_url)
                }
            },

            /**
             *  adds the patch to the method request
             *  @return void
             */
            edit() {
                this.sale._method = 'patch';
                this.ajaxRequest(window.Laravel.urls.sale_url + '/' + this.sales[0].id);
            },


            /**
             *  performs an ajax request and updates the user message
             *  @return void
             */
            ajaxRequest(url) {
                let self = this;
                axios.post(url, this.sale)
                    .then(
                        (response) => self.updateMessage(response.data.message)
                    )
                    .catch(
                        () => self.updateError()
                    );
            },

            /**
             * updates the user message and closes the modal
             * @param message
             */
            updateMessage(message) {
                Event.$emit('update-user-message', message)
                this.refresh();
                this.cancel();
            },

            /**
             * updates a user error
             * @return void
             */
            updateError(){
                Event.$emit('update-user-error', 'An error has occurred please try again!');
                this.cancel();
            }
        }
    }
</script>