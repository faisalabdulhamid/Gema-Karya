let mix = require('laravel-mix');

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

mix
  .js('vuejs/js/proyek/proyek.js', 'public/js')
  .js('vuejs/js/detail-proyek/detail-proyek.js', 'public/js')
  .js('vuejs/js/resiko/resiko.js', 'public/js')
  .js('vuejs/js/bahan-baku/bahan-baku.js', 'public/js')
  .js('vuejs/js/pekerjaan/pekerjaan.js', 'public/js')
  .js('vuejs/js/pegawai/pegawai.js', 'public/js')
  // .js('vuejs/js/app.js', 'public/js')
  // .sass('vuejs/sass/app.scss', 'public/css');
