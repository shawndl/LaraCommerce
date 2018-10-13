<template>
    <div>
        <div class="pull-right">
            <button class="btn btn-primary" @click="show.form = true">Create State</button>
        </div><!-- /.pull-right -->
        <full-screen v-if="show.form" :close="closeForm">
            <h3 slot="header">{{ form.header }}</h3>
            <div slot="body">
                <state-form :oldState="form.state"
                          :isEdit="form.isEdit"
                          :close="closeForm"
                          :refresh="getStates">

                </state-form>
            </div>
        </full-screen>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Abbreviation</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>

            <fade-out-animation>
                <tbody v-if="states">
                    <state-row v-for="state in states"
                               :key="state.id"
                               :state="state"
                               :refresh="getStates" :openEdit="onEdit">

                    </state-row>
                </tbody>
            </fade-out-animation>
        </table>
        <paginate-items v-if="states"
                        :number="lastPage"
                        :current="page"
                        @select-page="setPage">

        </paginate-items>
    </div>
</template>

<script>
    export default {
        data : function() {
            return {
                page : 1,
                lastPage : null,
                states : null,
                form : {
                    header : 'Add a State',
                    isEdit : false,
                    state : null
                },
                show : {
                    form : false
                }
            }
        },

        mounted() {
            this.getStates();
        },

        methods: {
            /**
             * performs an ajax request to get all categories
             * @return void
             */
            getStates() {
                this.states = null;
                axios.get(window.Laravel.urls.state_api_url + '?page=' + this.page)
                    .then(
                        (response) => this.setProperties(response.data.states)
                    )
                    .catch(() => this.setError())
            },


            /**
             * Sets properties if the ajax request was a success
             * @return void
             */
            setProperties(response) {
                console.log(response);
                this.page = response.current_page;
                this.lastPage = response.last_page;
                this.states = response.data;
            },

            /**
             * If there was an error it must emit an error
             * @return void
             */
            setError() {
                Event.$emit('update-user-error',  'There was an error retrieving the states.  Please try again later!')
            },

            /**
             * sets the new page
             * @param page
             * @return void
             */
            setPage(page) {
                this.page = page;
                this.getStates();
            },

            /**
             * closes the tax form and resets the values
             * @return void
             */
            closeForm() {
                this.show.form = false;
                this.form.header = 'Add a Tax';
                this.form.isEdit = false;
                this.form.state = null;
            },

            /**
             * prepares form for edit mode
             * @param state
             * @return void
             */
            onEdit(state) {
                this.form.state = state;
                this.form.isEdit = true;
                this.form.header = 'Edit this State';
                this.show.form = true;
            }
        }
    }
</script>