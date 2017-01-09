<?php

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

Route::group(["namespace" => 'Control', 'middleware' => 'api'], function() {
	Route::post('login', ['uses' => 'LoginController@login']);
});

Route::group(["namespace" => 'Control', 'middleware' => 'api'], function() {
	Route::resource('hero', 'HeroController');
	Route::resource('villain', 'VillainController');
	Route::resource('match', 'MatchController');
});


Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
