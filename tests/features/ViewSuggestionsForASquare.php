<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Letter;
use App\Models\Puzzle;
use App\Models\PuzzleSquare;
use App\Models\PuzzleTemplate;
use App\Models\User;
use App\Models\Word;

class ViewSuggestionsForASquareTest extends TestCase
{
    use DatabaseMigrations;
        
    /**
     * A basic functional test example.
     *
     * @return void
     */
     
    public function testViewingSuggestionsForASquare(){
        
        $faker = Faker\Factory::create();
        
        $user = factory(User::class)->create(['username' => 'krisbryant']);
        
        $name = $faker->sentence;
        $width = 10;
        $height = 10;
        
        $blackSquares = array();
        
        $args = array(
            'name' => $name,
            'width' => $width,
            'height' => $height,
            'blackSquares' => $blackSquares,
            'user_id' => $user->id,
        );
        
        $puzzleTemplate = PuzzleTemplate::create($args);
        
        $user->puzzleTemplates()->save($puzzleTemplate);
        
        $name = $faker->sentence;

        $firstword = "st";
        $puzzleSquares = array();
        
        for($k = 0; $k < strlen($firstword); $k++){
            $puzzleSquares[] = array(
                'row' => 1,
                'col' => $k + 1,
                'letter' => substr($firstword, $k, 1),
                'square_type' => 'white'
            );
        }
        
        $clues = array();
        
        $args = array(
            'name' => $name,
            'puzzle_template_id' => $puzzleTemplate->id,
            'puzzle_squares' => $puzzleSquares,
            'clues' => $clues,
            'user_id' => $user->id,
        );
        
        $puzzle = Puzzle::create($args);
        
        $this->seed(); //Populate the words and letters tables
        
        $this->actingAs($user)->visit('/puzzle_squares/suggestion/'.$puzzle->slug."/1/3")->see("r");
    }
}
