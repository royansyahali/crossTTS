<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('{username}', 'UserController@show');
});
