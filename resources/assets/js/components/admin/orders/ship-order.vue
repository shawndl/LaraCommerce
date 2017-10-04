<template>
    <div class="well">
        <h3>Shipping Details</h3>
        <p>
            <strong :class="{'text-success' : order.paid_for, 'text-danger' : !order.paid_for}" >Paid:
                <span v-if="order.paid_for">Yes</span>
                <span v-else>No</span>
            </strong>
        </p>
        <div v-if="order.shipped">
            <p>
                <strong :class="{'text-success' : order.shipped, 'text-danger' : !order.shipped}">Shipped:
                    <span v-if="order.shipped">Yes</span>
                    <span v-else>No</span>
                </strong>
            </p>
            <p>
                <strong v-if="order.shipped">Ship Date: {{ order.ship_date }}</strong>
            </p>
        </div>
        <div>
            <button v-if="order.paid_for && !order.shipped" class="btn btn-primary" @click="open">Shipped</button>
            <form-modal v-if="showForm"
                        @cancel-modal-form="close()">
                <h3 slot="header">Ship Order</h3>
                <div slot="body">
                    <form @submit.prevent="beforeSubmit">
                        <div class="row">
                            <div class="col-sm-6">
                                <input-date :label="'Ship Date:'"
                                            :name="'ship-date'"
                                            :error="fieldErrors.shipDate"
                                            @date-change="setDate($event)">

                                </input-date>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <input-date :label="'Estimated Date of Arrival'"
                                            :name="'arrival-date'"
                                            :error="fieldErrors.arrivalDate"
                                            @date-change="setDate($event)">

                                </input-date>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <div class="row">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div><!-- /.pull-right -->
                        </div><!-- /.row -->
                    </form>
                </div><!-- body -->
            </form-modal>
        </div>
    </div><!-- /.well -->
</template>

<script>
    export default {
        props : ['order'],

        data : function() {
            return {
                showForm : false,
                post : {
                    ship : null,
                    arrival : null
                },
                fieldErrors : {
                    shipDate : false,
                    arrivalDate : false
                }
            }
        },

        methods: {
            /**
             * opens the confirm model
             * @return void
             */
            open() {
                this.showForm = true;
            },

            /**
             * closes the confirm model
             * @return void
             */
            close() {
                this.showForm = false;
            },

            /**
             * sets the date when the input date class has been selected
             * @return void
             */
            setDate(event) {
                if(event.name === 'ship-date') {
                    this.post.ship = event.date;
                }
                if(event.name === 'arrival-date') {
                    this.post.arrival = event.date;
                }
                this.validateFields();
            },

            /**
             * validates the dates fields
             * @return void
             */
            validateFields() {
                this.validateFieldsRequired();
                if(this.hasErrors()) {
                    return;
                }
                this.validateDateCompare();
            },

            /**
             * validates the dates fields are empty
             * @return void
             */
            validateFieldsRequired(){
                if(this.post.ship === null) {
                    this.fieldErrors.shipDate = 'The ship date is required!'
                } else {
                    this.fieldErrors.shipDate = false;
                }
                if(this.post.arrival === null) {
                    this.fieldErrors.arrivalDate = 'The ship date is required!'
                } else {
                    this.fieldErrors.arrivalDate = false;
                }
            },


            /**
             *  Checks if the arrival date is after the ship date
             *  And sets an error message
             *  @return void
             */
            validateDateCompare() {
                if(this.post.ship === null || this.post.arrival === null) {
                    return;
                }
                let start = new Date(this.post.ship);
                let finish = new Date(this.post.arrival);
                if(start.getTime() > finish.getTime()) {
                    this.fieldErrors.shipDate = 'The shipped date must be before the arrival date';
                } else {
                    this.fieldErrors.shipDate = false;
                }
            },

            /**
             * are there errors
             * @return boolean
             */
            hasErrors() {
                return (this.fieldErrors.shipDate !== false || this.fieldErrors.arrivalDate !== false);
            },

            /**
             * sends an ajax request update the shipping date
             * @return void
             */
            beforeSubmit(){
                let self = this;
                this.validateFields();
                if(this.hasErrors()) {
                    return;
                }
                axios.post(window.Laravel.urls.order_url + '/' + this.order.id, this.post)
                    .then(
                        (response) => console.log(response)
                    )
                    .catch(
                        (error) => console.log(error)
                    );
                this.close();
            },

            /**
             * emits a success message to the user
             * @return void
             */
            updateMessage(message) {
                Event.$emit('update-user-message', message);
                Event.$emit('reset-products');
                this.close();
            }
        }

    }
</script>