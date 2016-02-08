<?php namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Model;

class PuzzleGuess extends Model {
	protected $table = 'puzzle_guesses';
	public $timestamps = FALSE;
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}