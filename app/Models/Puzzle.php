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
        $ret = array();
        
        $db = PuzzleSquare::where('puzzle_id', $this->id)->orderBy('row')->orderBy('col')->get();
        foreach($db as $ps){
            $ret[$ps->row.'-'.$ps->col] = array(
                'letter' => $ps->letter,
                'square_type' => $ps->square_type,
            );
        }
        
        return $ret;
    }
    
    public function puzzle_template(){
        return $this->belongsTo(PuzzleTemplate::class);
    }
    
    public function owner(){
        return User::find($this->user_id)->select('name')->first()['name'];
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
            
            $ptss = PuzzleTemplateSquare::where('puzzle_template_id', $args['puzzle_template_id'])->get();
            
            foreach($ptss as $pts){
                $ps = new PuzzleSquare;
                $ps->puzzle_id = $p->id;
                $ps->row = $pts->row;
                $ps->col = $pts->col;
                $letter = "";
                if (isset($args['puzzle_squares'])){
                    foreach($args['puzzle_squares'] as $puzzle_square){
                        if ($puzzle_square['row'] == $pts->row && $puzzle_square['col'] == $pts->col){
                            $letter = $puzzle_square['letter'];
                        }
                    }
                }
                $ps->letter = $letter;
                $ps->square_type = $pts->square_type;
                $ps->save();
            }
            
            if (isset($args['clues'])){
                foreach($args['clues'] as $c){
                    $p->clues()->save($c);
                }
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