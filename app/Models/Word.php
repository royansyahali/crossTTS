<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model {
	protected $table = 'words';
	public $timestamps = FALSE;
    
    protected $rules = array(
        'word'      => 'required|max:30',
        'user_id'   => 'required',
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
    
    public function letters(){
        return $this->hasMany(Letter::class);
    }
    
    public static function create(array $args = array()){
        $v = new Word;
        if ($v->validate($args)){
            $w = new Word;
            $word = preg_replace("[^a-zA-Z]", "", $args['word']);
            $w->word = $word;
            $w->length = strlen($args['word']);
            $w->user_id = $args['user_id'];
            $w->timestamp_utc = time();
            $w->save();
            
            for($i = 0; $i < strlen($word); $i++){
                $l = new Letter;
                $l->letter = substr($word,$i,1);
                $l->word_id = $w->id;
                $l->ordinal = $i+1;
                $l->save();
            }
            
            return $w;
        }else{
            return array('errors' => $v->errors);
        }
    }
}