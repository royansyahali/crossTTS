<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clue extends Model {
	protected $table = 'clues';
	public $timestamps = FALSE;
    
    protected $rules = array(
        'clue'                  => 'required',
        'puzzle_slug'           => 'required',
        'ordinal'               => 'required|numeric',
        'direction'             => 'required',
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
    
    public static function replace(array $args = array()){
        $v = new Clue;
        if ($v->validate($args)){
            $puzzle = Puzzle::findBySlug($args['puzzle_slug']);
            if (!$puzzle){
                return array('errors' => array('Puzzle not found'));
            }
            $c = self::where('puzzle_id', $puzzle->id)
                ->where('ordinal', $args['ordinal'])
                ->where('direction', $args['direction'])
                ->first();
            if (!$c){
                $c = new Clue;
            }
            $c->clue = $args['clue'];
            $c->puzzle_id = $puzzle->id;
            $c->ordinal = $args['ordinal'];
            $c->direction = $args['direction'];
            $c->save();
            
            return $c;
        }else{
            return array('errors' => $v->errors);
        }
    }
}