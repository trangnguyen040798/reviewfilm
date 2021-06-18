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
   .sass('resources/sass/app.scss', 'public/css');
mix.sass('resources/assets/admin/scss/login.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/admin/scss/style.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/admin/scss/user.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/admin/scss/country.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/admin/scss/artist.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/admin/scss/category.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/admin/scss/film.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/admin/scss/manage-video.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/admin/scss/create-video.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/admin/scss/news.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/admin/scss/manage-slider.scss', 'public/assets/admin/css/');
mix.sass('resources/assets/client/scss/master.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/home.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/film.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/category.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/news.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/account.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/create-video.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/manage-video.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/list-video.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/detail-artist.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/view-list-saved-video.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/create-film.scss', 'public/assets/client/css/');
mix.sass('resources/assets/client/scss/about-us.scss', 'public/assets/client/css/');
mix.js('resources/assets/admin/js/login.js', 'public/assets/admin/js/');
mix.js('resources/assets/admin/js/register.js', 'public/assets/admin/js/');
mix.js('resources/assets/admin/js/user.js', 'public/assets/admin/js/');
mix.js('resources/assets/admin/js/country.js', 'public/assets/admin/js/');
mix.js('resources/assets/admin/js/artist.js', 'public/assets/admin/js/');
mix.js('resources/assets/admin/js/category.js', 'public/assets/admin/js/');
mix.js('resources/assets/admin/js/news.js', 'public/assets/admin/js/');
mix.js('resources/assets/admin/js/film.js', 'public/assets/admin/js/');
mix.js('resources/assets/admin/js/manage-video.js', 'public/assets/admin/js/');
mix.js('resources/assets/admin/js/manage-slider.js', 'public/assets/admin/js/');
mix.js('resources/assets/client/js/category.js', 'public/assets/client/js/');
mix.js('resources/assets/client/js/create-video.js', 'public/assets/client/js/');
mix.js('resources/assets/client/js/manage-video.js', 'public/assets/client/js/');
mix.js('resources/assets/client/js/account.js', 'public/assets/client/js/');
mix.js('resources/assets/client/js/edit-account.js', 'public/assets/client/js/');
mix.js('resources/assets/client/js/list-video.js', 'public/assets/client/js/');
