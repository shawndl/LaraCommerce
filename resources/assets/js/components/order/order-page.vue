<template>
    <div class="container-fluid">
        <div class="order-header">
            <h1 class="order-title">Your Shopping Cart ({{ cart.information.count }})</h1>
        </div><!-- /.order-header -->
        <step-progress-bar :list="steps"
                           :current="current"
                           @update-current="updateCurrent">

        </step-progress-bar>
        <div class="order-wrapper">
            <order-details :current="current"
                           :cart="cart"
                           :user_order="user_order"
                           @address-is-complete="steps.Address.complete = true">

            </order-details>
            <div class="row">
                <div class="pull-left" v-if="notFirst()">
                    <a class="btn btn-primary"
                       @click="updateCurrent(getPrevious().step)">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        {{ getPrevious().name }}
                    </a>
                </div>
                <div class="pull-right" v-if="notLast()">
                    <a :class="{'btn btn-success' : true, 'disabled' : (!isComplete())}"
                       @click="updateCurrent(getNext().step)">
                        {{ getNext().name }}
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div><!-- /.row -->
        </div><!-- /.order-wrapper -->
    </div><!-- /.container -->
</template>

<script>
    export default {
        props : [
            'cart', 'user_order', 'stage'
        ],

        data: function() {
          return {
              steps : {
                  'Edit_Cart': {name : 'Edit Cart', url : 'edit-order', step : 1, complete : true},
                  'Address': {name : 'Select Address',  url : 'select-address', step : 2, complete : false},
                  'Payment' : {name : 'Payment', url : 'payment', step : 3, complete : false},
                  'Confirm' :  {name : 'Invoice', url : 'invoice', step : 4, complete : false},
              },
              current : 1,
          }
        },

        mounted() {
            Event.$emit('full-screen-window', true);
            this.$nextTick(function () {
                this.setStage()
            })
        },

        created() {
            Event.$on('user-paid-for-order',
                () => this.steps.Payment.complete = true
            );
        },

        methods: {
            /**
             * sets the current page property based on the stage property
             * @return {void}
             */
            setStage(){
                let currentPage;
                switch (this.stage) {
                    case 'edit-order' :
                        this.current = 1;
                        break;
                    case 'select-address' :
                        this.current = 2;
                        break;
                    case 'payment' :
                        currentPage = this.isPreviousComplete(3);
                        this.updateCurrent(currentPage);
                        break;
                    case 'invoice' :
                        currentPage = this.isPreviousComplete(4);
                        this.updateCurrent(currentPage);
                        break;
                    default :
                        this.current = 1;
                        break;
                }
            },

            /**
             * prevents the user from skipping steps
             * If the user has not completed the previous step then the current step will
             * step after the highest value completed
             * @return {int}
             */
            isPreviousComplete(stage) {
                let highestValue;
                let self = this;
                // Cycles through the steps to determine what the highest value for being complete is
                Object.keys(this.steps).forEach(function(key){
                    if(self.steps[key].complete === true) {
                        highestValue = self.steps[key].step + 1;
                    }
                });
                return (stage < highestValue) ? stage : highestValue;
            },

            /**
             * updates the current value which reflects the step the user is currently on
             * @param value
             * @return {void}
             */
            updateCurrent(value) {
                this.current = value;
                let step = this.getCurrent();
                history.replaceState({}, step.name, step.url);
            },

            /**
             * is this the last step
             * used to determine if the last button shoul be displayed
             * @return {boolean}
             */
            notLast() {
                if(Object.keys(this.steps).length === this.current) {
                    return false;
                }
                return true;
            },

            /**
             * is this the first step
             * used to determine if the last button shoul be displayed
             * @return {boolean}
             */
            notFirst() {
                if(this.current === 1) {
                    return false;
                }
                return true;
            },

            /**
             * returns the current step key for the steps object
             * @return {string}
             */
            getCurrent() {
                let self = this;
                let current = _.findKey(this.steps, function(value){
                    return (value.step === self.current);
                });
                return this.steps[current];
            },

            /**
             * returns the next step object
             * @return {Object | boolean}
             */
            getNext() {
                let self = this;
                let next = _.findKey(this.steps, function(value){
                   return (value.step === self.current + 1);
                });
                return this.steps[next];
            },

            /**
             * returns the previous step
             * @return {Object | boolean}
             */
            getPrevious() {
                let self = this;
                let previous = _.findKey(this.steps, function(value){
                    return (value.step === self.current - 1);
                });
                return this.steps[previous];
            },

            /**
             * Is the current step compete
             * @return {bool}
             */
            isComplete(){
                return this.getCurrent().complete;
            }
        }
    }
</script>