const mix = require('laravel-mix');

/*
|--------------------------------------------------------------------------
| Mix Asset Management
|--------------------------------------------------------------------------
|
| Mix provides a clean, fluent API for defining some Webpack build steps
| for your theme. Compile the Sass for your front-end and editor
| css. Optionally compile JS here if you are using ES2016+ or web components
|
*/
mix.setPublicPath('public')
    .sourceMaps()
    .disableNotifications()
    .options({
        processCssUrls: false,
    })
    .sass('sass/app.scss', 'css')
    .js('js/app.js', 'js')
    .copy('node_modules/lightcase/src/fonts/', 'public/fonts')
    .copy('node_modules/lightcase/src/js/lightcase.js', 'public/js/lightcase.js')

    // Copy FontAwesome Pro to assets directory
    .copy('node_modules/@fortawesome/fontawesome-pro/webfonts/', 'public/webfonts')
    .copy('node_modules/@fortawesome/fontawesome-pro/css/all.min.css', 'public/css/fontawesome-all.min.css')

    .browserSync({
        proxy: 'http://wordpress.test',
        files: [
            './public/css/*.css',
            './public/js/*.js',
            '**/*.php',
            './views/**/*.twig'
        ],
        notify: false,
    });