<?php


Route::group(['namespace'=>'Control','middleware'=>"web"], function ()
{
    Route::get('index', 'LoginController@index');
    Route::post('/login',['as' => 'login', 'uses' => 'LoginController@login']);
});

Route::get('/logout',['as' => 'logout', 'uses' => 'Control\LoginController@logout']);

Route::get('/dashboard',['as'=>'dashboard', 'uses' => 'Control\Dashboard@index']);