<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Letter;
use App\Models\User;
use App\Models\Word;

class WordSeeder extends Seeder{
    public function run(){
        
        $user = User::where('username', 'system')->first();
        
        $filename = "data/5000commonwords.txt";
        $words_str = File::get($filename);
        $words = explode("\r\n", $words_str);
        //$words = explode("\n", $words_str);
        
        foreach($words as $word_str){
            $word = Word::where('word', $word_str)->first();
            if (!$word){
                $args = array(
                    'word' => $word_str,
                    'user_id' => $user->id,
                );
                $word = Word::create($args);
            }
        }
    }
}