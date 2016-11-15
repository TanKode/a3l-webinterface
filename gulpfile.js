var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
 mix.less('remark/site.less', 'public/css/theme.min.css');
 mix.less('remark/bootstrap.less', 'public/assets/css/bootstrap.min.css');
 mix.less('remark/bootstrap-extend.less', 'public/assets/css/bootstrap-extend.min.css');
 mix.less('styles.less', 'public/css/styles.min.css');
});
