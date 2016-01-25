<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function(){
        return view('welcome');
    });
    Route::get('{username}', 'UserController@show');
});
