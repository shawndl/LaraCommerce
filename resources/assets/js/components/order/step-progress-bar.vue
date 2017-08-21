<template>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <ul class="progress-step-bar">
                <li v-for="item in list"
                    :class="[getClass(item.step, item.complete)]"
                    @click="updateCurrent(item.step)">
                    {{ item.name }}
                </li>
            </ul>
        </div><!-- /.col -->
    </div><!-- /.row -->
</template>

<script>
    export default {
        props : [
            'current', 'list'
        ],

        methods: {
            /**
             * gets the class based on the step and if its complete
             * @param step
             * @param complete
             * @return {string}
             */
            getClass(step, complete) {
                if(step === this.current) {
                    return 'active';
                }
                if(complete && step !== this.current) {
                    return 'complete'
                }
                if(!complete && step < this.current && step !== this.current) {
                    return 'incomplete';
                }
                return '';
            },

            /**
             * update the current
             * @param current
             * @return {void}
             */
            updateCurrent(current) {
                this.$emit('update-current', current)
            }
        }
    }
</script>

<style>

    .progress-step-bar {
        counter-reset: step;
    }

    .progress-step-bar li {
        list-style-type: none;
        cursor: pointer;
        float: left;
        width: 25%;
        position: relative;
        text-align: center;
        font-weight: bold;
    }

    .progress-step-bar li:before {
        content: counter(step);
        counter-increment: step;
        height: 30px;
        width: 30px;
        line-height: 28px;
        border: 2px solid #ddd;
        border-radius: 50%;
        display: block;
        text-align: center;
        margin: 0 auto 10px auto;
        background-color: #FFFFFF;
    }

    .progress-step-bar li:after {
        content: '';
        width: 100%;
        position: absolute;
        height: 1px;
        background-color: #ddd;
        top: 15px;
        left: -56%;
        z-index: -1;
    }

    .progress-step-bar li:first-child:after {
        content: none;
    }

    .progress-step-bar li.complete {
        color: #2ab27b;
    }

    .progress-step-bar li.complete:before {
        font-family: FontAwesome;
        content: "\f00c";
        border-color: #2ab27b;
    }

    .progress-step-bar li.active {
        color: #d2691e;
    }

    .progress-step-bar li.active:before {
        border-color: #d2691e;
    }

    .progress-step-bar li.incomplete {
        color: #ff0000;
    }

    .progress-step-bar li.incomplete:before {
        font-family: FontAwesome;
        content: "\f00d";
        border-color: #ff0000;
    }

    @media screen and (max-width: 998px) {
        .progress-step-bar li:after  {
            left: -58%;
        }
    }
</style>