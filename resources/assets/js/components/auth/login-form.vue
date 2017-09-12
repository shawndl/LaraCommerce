<template>
    <form :action="post_address" method="post" @submit.prevent="beforeSubmit" >
        <input type="hidden" name="_token" :value="csrf_token"/>
        <div class="row top-buffer-20">
            <div :class="{'form-group': true, 'has-error' : errors.has('email')}">
                <label for="email"
                       class="col-md-4 control-label">
                    E-Mail Address
                </label>
                <div class="col-md-6">
                    <input id="email"
                           type="email"
                           class="form-control"
                           name="email"
                           v-validate="'required|email'"
                           value=""
                           autofocus>
                    <span class="help-block"
                          id="email-error"
                          v-show="errors.has('email')">
                        <strong>{{ errors.first('email') }}</strong>
                    </span>
                </div>
            </div>
        </div><!-- /.row -->
        <div class="row top-buffer-20">
            <div :class="{'form-group': true, 'has-error' : errors.has('password')}">
                <label for="password" class="col-md-4 control-label">Password</label>

                <div class="col-md-6">
                    <input id="password"
                           type="password"
                           class="form-control"
                           name="password"
                           v-validate="'required'">
                    <span class="help-block"
                          id="password-error"
                          v-show="errors.has('password')">
                        <strong>{{ errors.first('password') }}</strong>
                    </span>
                </div>
            </div>
        </div><!-- /.row -->
        <div class="form-group top-buffer-10">
            <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Login
                </button>

                <a class="btn btn-link" :href="forgot_password">
                    Forgot Your Password?
                </a>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props : ['csrf_token', 'post_address', 'forgot_password'],

        methods: {
            beforeSubmit(event) {
                this.$validator.validateAll().then(() => {
                    event.target.submit();
                });
            },
        }
    }
</script>