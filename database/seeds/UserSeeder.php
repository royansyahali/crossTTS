<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\GoogleUser;


class UserSeeder extends Seeder{
    public function run(){
        $users = array(
            'username' => 'Royan Syah',
            'name' => 'Royan Syah',
           
        );
        
        $g= GoogleUser::create([
            'name' => 'Royan Syah',
            'google_id' => '116233080712066290530',
            'created_timestamp_utc' => time(),
            'updated_timestamp_utc' => time(),
        ]);
        $u = User::where('username', $users['username'])->first();
        if (!$u){
            $u = new User;
            $u->google_user_id = $g->id;
            $u->username = $users['username'];
            $u->name = $users['name'];
            $u->admin = 1;
            $u->created_timestamp_utc = time();
            $u->updated_timestamp_utc = time();
            $u->save();
        }
        $u = User::where('username', 'Royan Syah')->first();
     
        // 
    }
}