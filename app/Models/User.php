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
    
    public static function findByUserName($username){
        return self::where('username', $username)->first();
    }
    
}
