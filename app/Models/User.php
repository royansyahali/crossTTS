<?php

namespace App\Models;

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
        $guesses = Puzzle::join('puzzle_guesses', 'puzzle_guesses.puzzle_id', '=', 'puzzles.id')
            ->select('puzzles.slug', 'puzzles.name')
            ->where('puzzle_guesses.user_id', $this->id)
            ->orderBy('updated_timestamp_utc', 'desc')
            ->get();
            
        $puzzles = Puzzle::where('user_id', $this->id)
            ->where('active', 1)
            ->whereNull('deleted_timestamp_utc')
            ->get();
        
        $templates = PuzzleTemplate::where('user_id', $this->id)
            ->select('height', 'width', 'slug', 'name', 'symmetrical')
            ->where('active', 1)
            ->get();

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
