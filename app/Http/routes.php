<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function(){
        return view('welcome');
    });
    
    Route::get('/puzzle_templates', 'PuzzleController@getPuzzleTemplates');
    Route::get('/puzzle_templates/{slug}', 'PuzzleController@getPuzzleTemplate');
    Route::post('/puzzle_templates', 'PuzzleController@postPuzzleTemplate');
    
    Route::get('/puzzles', 'PuzzleController@showPopularPuzzles');
    Route::get('/puzzles/{slug}', 'PuzzleController@getPuzzle');
    Route::post('/puzzles', 'PuzzleController@postPuzzle');
    
    Route::get('/puzzle_squares/suggestion/{puzzle_slug}/{row}/{col}', 'PuzzleController@getSuggestion');
    Route::post('/puzzle_square', 'PuzzleController@postSquare');
    
    Route::get('/auth/me', 'AuthController@getMe');
    Route::get('/auth/logout', 'AuthController@getLogout');
    Route::get('/auth/killwindow', 'AuthController@getKillWindow');
    Route::get('/auth/twitter', 'AuthController@redirectToProvider');
    Route::get('/auth/twitter/callback', 'AuthController@handleProviderCallback');
    
    Route::get('/users/{username}/puzzles', 'UserController@showPuzzles');
    Route::get('/users/{username}/puzzle_templates', 'UserController@showPuzzleTemplates');

});
