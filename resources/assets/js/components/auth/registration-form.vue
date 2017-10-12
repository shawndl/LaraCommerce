<template>
    <form :action="post_address" method="post" @submit.prevent="beforeSubmit" >
        <input type="hidden" name="_token" :value="csrf_token" @submit.prevent="create"/>
        <div class="row">
            <div class="col-sm-6">
                <div :class="{'form-group' : true, 'has-error' : errors.has('first_name')}">
                    <label for="first_name" class="control-label">
                        First Name
                    </label>
                    <input id="first_name"
                           type="text"
                           class="form-control"
                           name="first_name"
                           v-validate="'required|alpha_spaces'"
                           value=""
                           autofocus>
                    <span class="text-danger" id="first-name-error" v-show="errors.has('first_name')">
                        {{ errors.first('first_name') }}
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div :class="{'form-group' : true, 'has-error' : errors.has('last_name')}">
                    <label for="last_name" class="control-label">
                        Last Name
                    </label>
                    <input id="last_name"
                           type="text"
                           class="form-control"
                           name="last_name"
                           v-validate="'required|alpha_spaces'"

                           value="">
                    <span class="text-danger" id="last-name-error" v-show="errors.has('last_name')">
                        {{ errors.first('last_name') }}
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-6">
                <div :class="{'form-group' : true, 'has-error' : errors.has('username')}">
                    <label for="username" class=" control-label">
                        Username
                    </label>
                    <input id="username"
                           type="text"
                           class="form-control"
                           name="username"
                           value=""
                           v-validate="'required|alpha_spaces|unique-username'">
                    <span class="text-danger" id="username-error" v-show="errors.has('username')">
                        {{ errors.first('username') }}
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div :class="{'form-group' : true, 'has-error' : errors.has('email')}">
                    <label for="email" class="control-label">E-Mail Address</label>
                    <input id="email"
                           type="email"
                           class="form-control"
                           name="email"
                           value=""
                           v-validate="'required|email|unique-email'">
                    <span class="text-danger" id="email-error" v-show="errors.has('email')">
                        {{ errors.first('email') }}
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-6">
                <div :class="{'form-group' : true, 'has-error' : errors.has('password')}">
                    <label for="password" class="control-label">Password</label>
                    <input id="password"
                           type="password"
                           class="form-control"
                           name="password"
                           v-validate="'required|min:5|confirmed'">
                    <span class="text-danger" id="password-error" v-show="errors.has('password')">
                        {{ errors.first('password') }}
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div :class="{'form-group' : true, 'has-error' : errors.has('password_confirmation')}">
                    <label for="password-confirm" class="control-label">Confirm Password</label>
                    <input id="password-confirm"
                           type="password"
                           class="form-control"
                           name="password_confirmation">
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Register
                </button>
            </div>
        </div><!-- form-group -->
    </form>
</template>


<script>
    import { Validator } from 'vee-validate';
    const uniqueEmail = {
        scope : {
            'unique' : false
        },

        getMessage() {
            return `This email address is already registered.`
        },
        validate(value, args) {
            if(value)
            {
                return axios.post(window.Laravel.urls.user_email_url, {
                    email: value
                })
                    .then(function (response) {
                        return {valid : response.data['email']};
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            } else {
                return false;
            }

        }
    };
    Validator.extend('unique-email', uniqueEmail);

    const uniqueUsername = {
        scope : {
            'unique' : false
        },

        getMessage() {
            return `This username is already taken!`
        },
        validate(value, args) {
            if(value)
            {
                return axios.post(window.Laravel.urls.user_username_url, {
                    username: value
                })
                    .then(function (response) {
                        return {valid : response.data['username']};
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            } else {
                return false;
            }

        }
    };
    Validator.extend('unique-username', uniqueUsername);

    export default {
        props : ['csrf_token', 'post_address'],

        methods: {
            beforeSubmit(event) {
                let self = this;
                this.$validator.validateAll().then(function (){
                    if (!self.errors.any()) {
                        event.target.submit();
                    }
                });
            }
        }
    }
</script>