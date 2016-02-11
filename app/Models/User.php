<?php

namespace App\Models;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
	public $timestamps = FALSE;
    
    public function twitter(){
        return $this->belongsTo('App\Models\TwitterUser', 'twitter_user_id');
    }
    
    public function puzzles(){
        return $this->hasMany(Puzzle::class);
    }
    
    public function puzzleTemplates(){
        return $this->hasMany(PuzzleTemplate::class);
    }
    
    public static function findByUserName($username){
        return self::where('username', $username)->first();
    }
    
    public function profile(){
        $guesses = Puzzle::leftJoin('puzzle_templates', 'puzzle_templates.id', '=', 'puzzles.puzzle_template_id')
            ->join('puzzle_guesses', 'puzzle_guesses.puzzle_id', '=', 'puzzles.id')
            ->selectRaw('puzzles.slug puzzle_slug, puzzles.name puzzle_name, puzzle_templates.slug template_slug')
            ->where('puzzle_guesses.user_id', $this->id)
            ->orderBy('updated_timestamp_utc', 'desc')
            ->get();
            
        $puzzles = Puzzle::leftJoin('puzzle_templates', 'puzzle_templates.id', '=', 'puzzles.puzzle_template_id')
            ->where('puzzles.user_id', $this->id)
            ->where('puzzles.active', 1)
            ->whereNull('deleted_timestamp_utc')
            ->selectRaw('puzzles.slug puzzle_slug, puzzles.name puzzle_name, puzzle_templates.slug template_slug')
            ->get();

        $templates = PuzzleTemplate::where('active', 1)
            ->where(function($query){
                $query->where('user_id', $this->id)
                    ->orWhereRaw('id in (select puzzle_template_id from puzzles where user_id = ?)', array($this->id))
                    ->orWhereRaw('id in (select puzzles.puzzle_template_id from puzzle_guesses inner join puzzles on puzzle_guesses.puzzle_id = puzzles.id where puzzle_guesses.user_id = ?)', array($this->id));
            })
            ->select('id', 'height', 'width', 'slug', 'name', 'symmetrical', 'user_id')
            ->with('puzzleTemplateSquares')
            ->get();

        foreach($templates as $template_key=>$t){
            foreach($t->puzzleTemplateSquares as $k=>$s){
                $square = $templates[$template_key]->puzzleTemplateSquares[$k];
                $row = $square->row;
                $col = $square->col;
                $templates[$template_key]->puzzleTemplateSquares[$row.'-'.$col] = $square;
                unset($templates[$template_key]->puzzleTemplateSquares[$row.'-'.$col]->row);
                unset($templates[$template_key]->puzzleTemplateSquares[$row.'-'.$col]->col);
                unset($templates[$template_key]->puzzleTemplateSquares[$row.'-'.$col]->puzzle_template_id);
                unset($templates[$template_key]->puzzleTemplateSquares[$row.'-'.$col]->id);
                unset($templates[$template_key]->puzzleTemplateSquares[$k]);
            }
            $templates[$t->slug] = $templates[$template_key];
            $templates[$t->slug]['clue_squares'] = $t->clueSquares();
            unset($templates[$template_key]);
        }
        return array(
            'username'                  => $this->username,
            'name'                      => $this->name,
            'profile_image_base_url'    => isset($this->twitter->profile_image_url) ? str_replace("_normal.jpeg", "", $this->twitter->profile_image_url) : "",
            'templates'                 => $templates,
            'puzzles'                   => $puzzles,
            'attempted_puzzles'         => $guesses,
            'twitter_handle'            => isset($this->twitter->screen_name) ? $this->twitter->screen_name : "",
        );
    }
}
