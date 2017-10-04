<template>
    <div class="form-group" :class="{'has-error' : error}">
        <label :for="name" class="control-label">{{ label }}</label>
        <date-picker @change="emitDateChange()" :date="startTime" :option="option"></date-picker>
        <span class="help-block"
              v-show="error">
            <strong>{{ error }}</strong>
        </span>
    </div><!-- /.form-group -->
</template>

<script type="text/javascript">
    import myDatepicker from 'vue-datepicker'

    export default {
        props : ['label', 'name', 'error'],

        data () {
            return {
                startTime: {
                    time: ''
                },

                option: {
                    type: 'day',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD',
                    placeholder: 'when?',
                    inputStyle: {
                        'display': 'inline-block',
                        'padding': '6px',
                        'line-height': '22px',
                        'font-size': '16px',
                        'border': '2px solid #fff',
                        'box-shadow': '0 1px 3px 0 rgba(0, 0, 0, 0.2)',
                        'border-radius': '2px',
                        'color': '#5F5F5F'
                    },
                    color: {
                        header: '#ccc',
                        headerText: '#f00'
                    },
                    buttons: {
                        ok: 'Ok',
                        cancel: 'Cancel'
                    },
                    overlayOpacity: 0.5,
                    dismissible: true
                },
            }
        },
        components: {
            'date-picker': myDatepicker
        },
        methods : {
            /**
             * when the user enters a date it will emit to the parent class
             * @return void
             */
            emitDateChange(){
                this.$emit('date-change', {name  : this.name, date : this.startTime.time});
            }
        }
    }
</script>