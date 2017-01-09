var elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');

var argv = require('yargs').argv;
var gulp = require('gulp');

if (argv.build) {
    elixir(function (mix) {
        mix.webpack('./resources/assets/js/app.js', './public/js/app.js');
        mix.styles(['./node_modules/bootstrap/dist/css/bootstrap.css'], './public/css/app.css');
    });
}
else if (argv.js) {
    elixir(function (mix) {
        mix.webpack('./resources/assets/js/app.js', './public/js/app.js');
    });
}