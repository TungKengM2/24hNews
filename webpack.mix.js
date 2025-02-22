const mix = require('laravel-mix');

mix.js('resources/js/ckeditor.js', 'public/js');
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [])
    .sass('resources/sass/app.scss', 'public/css')
    .copyDirectory('resources/assets', 'public/assets');
mix.setPublicPath('public');
