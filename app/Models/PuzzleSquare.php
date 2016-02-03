<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuzzleSquare extends Model {
    protected $table = 'puzzle_squares';
    public $timestamps = FALSE;
    
    public static function findSuggestion($puzzle, $row, $col){
        //Start here
    }
}