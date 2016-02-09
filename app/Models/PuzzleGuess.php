<?php namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Model;

class PuzzleGuess extends Model {
	protected $table = 'puzzle_guesses';
	public $timestamps = FALSE;
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function puzzle(){
        return $this->belongsTo(Puzzle::class);
    }
    
    public function solved(){
        $p = $this->puzzle;
        
        $guess_squares_db = PuzzleGuessSquare::where('puzzle_guess_id', $this->id)
            ->orderBy('row')
            ->orderBy('col')
            ->get();
            
        $guess_squares = array();
        foreach($guess_squares_db as $gs){
            $guess_squares[$gs->row.'-'.$gs->col] = array('letter' => $gs->letter);
        }
        
        $pss = $p->puzzle_squares(true);
        
        foreach($pss as $k=>$ps){
            if ($ps['square_type'] != "black" && (!isset($guess_squares[$k]) || $guess_squares[$k]['letter'] != $ps['letter'])){
                return 0;
            }
        }
        
        return 1;
    }
}