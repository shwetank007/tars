<?php


Route::get('/', 'Control\LoginController@index');
Route::post('/', 'Control\LoginController@login');

Route::group(['namespace'=>'Control','middleware'=>"web"], function ()
{
    Route::get('/login', ['as' => 'user.login','uses' => 'LoginController@index']);
    Route::post('/login',['as' => 'login', 'uses' => 'LoginController@login']);
});

Route::get('/logout',['as' => 'logout', 'uses' => 'Control\LoginController@logout']);

Route::get('/dashboard',['as'=>'dashboard', 'uses' => 'Control\DashboardController@refer'])->middleware('auth.user');