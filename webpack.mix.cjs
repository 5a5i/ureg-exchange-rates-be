const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .vue() // Enable Vue 3 support
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .options({
        processCssUrls: false,
    })
    .webpackConfig({
        resolve: {
            extensions: ['.js', '.json', '.vue'], // Ensure proper module resolution
        },
    });
