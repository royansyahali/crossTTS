<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\{User,GoogleUser};

class UserSeeder extends Seeder{
    public function run(){
        $users = array(
            'username' => 'Royan Syah',
            'name' => 'Royan Syah',
        );
        
        $u = User::where('username', $users['username'])->first();
        $g = GoogleUser::where('name', $users['name'])->first();
        if (!$g){
            $g = new GoogleUser();
            $g->name = $users['name'];
            $g->google_id = '116233080712066290530';
            $g->created_timestamp_utc = time();
            $g->updated_timestamp_utc = time();
            $g->save();
        }
        if (!$u){
            $u = new User;
            $u->username = $users['username'];
            $u->name = $users['name'];
            $u->admin = 1;
            $u->remember_token= '8ZEFZGLUcDR7g0JNUXsiOGd6mRtowYbUAP1GYGg2Ot89Xxtkk8KrxNvYYqui';
            $u->created_timestamp_utc = time();
            $u->updated_timestamp_utc = time();
            $u->google_user_id = 1;
            $u->most_recent_ip = '127.0.0.1';
            $u->save();
            
        }
    }
}