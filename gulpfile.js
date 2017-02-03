var elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');

var argv = require('yargs').argv;
var gulp = require('gulp');

gulp.task('default', function() {
    gulp.task('build');
});

if (argv.build) {
    elixir(function (mix) {
        mix.webpack([
            './resources/assets/js/app.js',
            './node_modules/bootstrap/dist/js/bootstrap.js',
            './node_modules/jasny-bootstrap/dist/js/jasny-bootstrap.js',
        ], './public/js/app.js');
        mix.styles([
            './public/css/app.css',
            './node_modules/bootstrap/dist/css/bootstrap.css',
            './node_modules/jasny-bootstrap/dist/css/jasny-bootstrap.css',
            './resources/assets/css/common.css',
        ], './public/css/app.css');
    });
}
else if (argv.js) {
    elixir(function (mix) {
        mix.webpack([
            './resources/assets/js/app.js',
            './node_modules/bootstrap/dist/js/bootstrap.js',
            './node_modules/jasny-bootstrap/dist/js/jasny-bootstrap.js',
        ], './public/js/app.js');
    });
}