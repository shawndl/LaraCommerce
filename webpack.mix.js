const { mix } = require('laravel-mix');
const webpack = require('webpack');

mix.webpackConfig({
    plugins: [
        // Fix for moment.js failed to find local error
        new webpack.ContextReplacementPlugin(/\.\/locale$/, 'empty-module', false, /js$/)
    ]
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
    .version()
    .copy('node_modules/font-awesome/fonts', 'public/fonts')
    .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap');



mix.js('resources/assets/js/admin.js', 'public/js')
    .sass('resources/assets/sass/admin.scss', 'public/css');