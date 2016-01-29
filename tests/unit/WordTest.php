<?php

use DB;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Letter;
use App\Models\User;
use App\Models\Word;

class WordTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testAWordCanBeCreated()
    {
        $faker = Faker\Factory::create();
        
        $user = factory(User::class)->create(['username' => 'janedoe2']);
        
        $word_str = $faker->word;
        
        $args = array(
            'word' => $word_str,
            'user_id' => $user->id,
        );
        
        $word = Word::create($args);
        
        $first_letter = Letter::where('word_id', $word->id)
            ->where('ordinal', '1')
            ->first();
        
        $this->assertEquals($word->word, $word_str);
        $this->assertEquals($first_letter->letter, substr($word_str,0,1));
        
        if (strlen($word_str) > 1){
            $second_letter = Letter::where('word_id', $word->id)
                ->where('ordinal', 2)
                ->first();
            $this->assertEquals($second_letter->letter, substr($word_str,1,1));
        }
    }
}
