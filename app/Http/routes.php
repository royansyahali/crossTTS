<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function(){
        return view('welcome');
    });
    
    Route::get('/puzzle_templates', 'PuzzleController@getPuzzleTemplates');
    Route::get('/puzzle_templates/{slug}', 'PuzzleController@getPuzzleTemplate');
    Route::post('/puzzle_templates', 'PuzzleController@postPuzzleTemplate');
    
    Route::get('/puzzles/list/{limit?}', 'PuzzleController@getPuzzles');
    Route::get('/incomplete_puzzles', 'PuzzleController@showIncompletePuzzles');
    Route::get('/puzzles/{slug}', 'PuzzleController@getPuzzle');
    Route::get('/puzzles/{slug}/edit', 'PuzzleController@getPuzzleForEdit');
    Route::post('/puzzles/{slug}/delete', 'PuzzleController@deletePuzzle');
    Route::post('/puzzles', 'PuzzleController@postPuzzle');
    Route::post('/puzzles/setname', 'PuzzleController@setName');
    Route::post('/puzzles/activate', 'PuzzleController@activatePuzzle');
    Route::get('/puzzles/{slug}/problem_squares', 'PuzzleController@getProblemSquares');
    
    Route::get('/puzzle_squares/suggestion/{puzzle_slug}/{row}/{col}', 'PuzzleController@getSuggestion');
    Route::post('/puzzle_square', 'PuzzleController@postSquare');
    
    Route::post('/puzzle_guess_square', 'PuzzleController@postGuessSquare');
    
    Route::post('/clue', 'PuzzleController@postClue');
    
    Route::get('/auth/me', 'AuthController@getMe');
    Route::get('/auth/logout', 'AuthController@getLogout');
    Route::get('/auth/killwindow', 'AuthController@getKillWindow');
    Route::get('/auth/twitter', 'AuthController@redirectToProvider');
    Route::get('/auth/twitter/callback', 'AuthController@handleProviderCallback');
    
    Route::get('/users/{username}', 'UserController@getProfile');
    Route::get('/users/{username}/puzzles', 'UserController@showPuzzles');
    Route::get('/users/{username}/puzzle_templates', 'UserController@showPuzzleTemplates');

});
