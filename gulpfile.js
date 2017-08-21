const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.sass('app.scss');

    mix.scripts([
        '../../../node_modules/vue/dist/vue.js',
        '../../../node_modules/jquery/dist/jquery.js',
        '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
        '../../../node_modules/axios/dist/axios.js',
        'components',
        'app.js'
    ], 'public/js/app.js');

    mix.copy('node_modules/bootstrap-sass/assets/fonts', 'public/fonts/bootstrap')
    mix.copy('node_modules/font-awesome/fonts', 'public/fonts')
});

