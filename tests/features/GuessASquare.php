<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Letter;
use App\Models\Puzzle;
use App\Models\PuzzleGuessSquare;
use App\Models\PuzzleSquare;
use App\Models\PuzzleTemplate;
use App\Models\User;
use App\Models\Word;

class GuessingASquareTest extends TestCase
{
    use DatabaseMigrations;
        
    /**
     * A basic functional test example.
     *
     * @return void
     */
     
    public function testGuessingASquare(){
        
        $faker = Faker\Factory::create();
        
        $user_creator = factory(User::class)->create(['username' => 'jaimegarcia']);
        $user_guesser = factory(User::class)->create(['username' => 'wilmyers']);
        
        $name = "puzzle template";
        $width = 10;
        $height = 10;
        
        $blackSquares = array();
        
        $args = array(
            'name' => $name,
            'width' => $width,
            'height' => $height,
            'blackSquares' => $blackSquares,
            'user_id' => $user_creator->id,
        );
        
        $puzzleTemplate = PuzzleTemplate::create($args);
        
        $user_creator->puzzleTemplates()->save($puzzleTemplate);
        
        $name = "my puzzle";

        $firstword = "st";
        $puzzleSquares = array();
        
        for($row = 1; $row <= 10; $row++){
            for($col = 1; $col <= 10; $col++){
                $puzzleSquares[] = array(
                    'row' => $row,
                    'col' => $col,
                    'letter' => 'a',
                    'square_type' => 'white'
                );
            }
        }
        
        $clues = array();
        
        $args = array(
            'name' => $name,
            'puzzle_template_id' => $puzzleTemplate->id,
            'puzzle_squares' => $puzzleSquares,
            'clues' => $clues,
            'user_id' => $user_creator->id,
        );
        
        $puzzle = Puzzle::create($args);
        
        $puzzle->activate();
        
        $guess = "x";
        
        $args = array(
            'puzzle_slug' => $puzzle->slug,
            'row' => 1,
            'col' => 1,
            'letter' => $guess,
            'user_id' => $user_guesser->id,
        );
        
        $pgs = PuzzleGuessSquare::create($args);
        
        $this->actingAs($user_guesser)->visit('/puzzles/'.$puzzle->slug)->see($guess);
    }
}
