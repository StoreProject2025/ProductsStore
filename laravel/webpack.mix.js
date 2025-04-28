const mix = require('laravel-mix');

mix.js('packages/Webkul/Admin/src/Resources/assets/js/app.js', 'public/js')
   .postCss('packages/Webkul/Admin/src/Resources/assets/css/app.css', 'public/css', [
       require('tailwindcss'),
       require('autoprefixer'),
   ])
   .vue()
   .copy('packages/Webkul/Admin/src/Resources/assets/images', 'public/images')
   .copy('packages/Webkul/Admin/src/Resources/assets/fonts', 'public/fonts');