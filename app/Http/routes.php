<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function(){
        return view('welcome');
    });
    Route::get('/puzzles', 'PuzzleController@showPopularPuzzles');
    Route::get('{username}/puzzles', 'UserController@showPuzzles');
});
