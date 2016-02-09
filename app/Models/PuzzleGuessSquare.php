<?php namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Model;

class PuzzleGuessSquare extends Model {
	protected $table = 'puzzle_guess_squares';
	public $timestamps = FALSE;
    
    protected $rules = array(
        'puzzle_slug'   => 'required',
        'row'           => 'required|numeric',
        'col'           => 'required|numeric',
        'user_id'       => 'required',
    );
    
    private $errors;
    
    public function validate($data){
        $v = \Validator::make($data, $this->rules);
        
        if ($v->fails()){
            $this->errors = $v->errors();
            return false;
        }

        return true;
    }

    public function errors(){
        return $this->errors;
    }
    
    public function puzzle_guess(){
        return $this->belongsTo(PuzzleGuess::class);
    }
    
    public static function replace(array $args = array()){
        $v = new PuzzleGuessSquare;
        if ($v->validate($args)){
            $puzzle_guess = PuzzleGuess::whereRaw('puzzle_id in (select id from puzzles where slug = ?)', array($args['puzzle_slug']))
                ->where('user_id', $args['user_id'])
                ->first();
                
            $p = Puzzle::where('slug', $args['puzzle_slug'])->first();
            
            if (!$puzzle_guess){
                $puzzle_guess = new PuzzleGuess;
                $puzzle_guess->user_id = $args['user_id'];
                $puzzle_guess->puzzle_id = $p->id;
                $puzzle_guess->created_timestamp_utc = time();
            }
            $puzzle_guess->updated_timestamp_utc = time();
            $puzzle_guess->save();
            
            $pgs = PuzzleGuessSquare::where('puzzle_guess_id', $puzzle_guess->id)
                ->where('row', $args['row'])
                ->where('col', $args['col'])
                ->first();
            
            if (!$pgs){
                $pgs = new PuzzleGuessSquare;
                $pgs->puzzle_guess_id = $puzzle_guess->id;
                $pgs->row = $args['row'];
                $pgs->col = $args['col'];
            }
            $pgs->timestamp_utc = time();
            if (isset($args['letter'])){
                $pgs->letter = $args['letter'];
            }
            $pgs->save();
            
            $pgs['solved'] = $puzzle_guess->solved();
            
            return $pgs;
        }else{
            return array('errors' => $v->errors);
        }
    }
}