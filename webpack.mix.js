const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.setPublicPath(path.resolve('.'))
    .js('resources/js/app.js', 'public')
    .version()
    .js('resources/js/noise.js', 'public')
    .version()
    .js('resources/js/stripe.js', 'public')
    .version()
    .sass('resources/sass/app.scss', 'public')
    .version()
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')],
    });
