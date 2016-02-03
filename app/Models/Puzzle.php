<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model {
	protected $table = 'puzzles';
	public $timestamps = FALSE;
    
    protected $rules = array(
        'name'                  => 'required',
        'user_id'               => 'required|numeric',
        'puzzle_template_id'    => 'required|numeric',
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
    
    public function clues(){
        return $this->hasMany(Clue::class);
    }
    
    public function puzzle_squares(){
        return $this->hasMany(PuzzleSquare::class);
    }
    
    public static function create(array $args = array()){
        $v = new Puzzle;
        if ($v->validate($args)){
            $p = new Puzzle;
            $p->name = $args['name'];
            $p->slug = self::findSlug($args['name']);
            $p->user_id = $args['user_id'];
            $p->puzzle_template_id = $args['puzzle_template_id'];
            $p->timestamp_utc = time();
            $p->save();
            
            foreach($args['puzzle_squares'] as $puzzle_square){
                $ps = new PuzzleSquare;
                $ps->puzzle_id = $p->id;
                $ps->row = $puzzle_square['row'];
                $ps->col = $puzzle_square['col'];
                $ps->letter = $puzzle_square['letter'];
                $ps->square_type = $puzzle_square['square_type'];
                $ps->save();
            }
            
            foreach($args['clues'] as $c){
                $p->clues()->save($c);
            }
                        
            return $p;
        }else{
            return array('errors' => $v->errors);
        }
    }
    
    public static function findBySlug($slug){
        return self::where('slug', $slug)->first();
    }
    
    public static function findSlug($name){
        $slug = strtolower(preg_replace("/[^a-zA-Z\d]/", "-", $name));
        $origslug = $slug;
        $exists = Puzzle::where('slug', $slug)->first();
        $i = 0;
        while ($exists){
            $slug = $origslug."-".$i++;
            $exists = Puzzle::where('slug', $slug)->first();
        }
        return $slug;
    }
}