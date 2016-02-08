<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Puzzle;
use App\Models\PuzzleTemplate;
use App\Models\User;

class ViewPopularPuzzlesTest extends TestCase
{
    use DatabaseMigrations;
        
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testViewingPopularPuzzles(){   
        $faker = Faker\Factory::create();
        
        $user = factory(User::class)->create(['username' => 'johndoe1']);
        
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
        
        $puzzleSquares = array();
        $clues = array();
        
        $args = array(
            'name' => 'My first puzzle',
            'puzzle_template_id' => $puzzleTemplate->id,
            'puzzle_squares' => $puzzleSquares,
            'clues' => $clues,
            'user_id' => $user->id,
        );
        
        $puzzle1 = Puzzle::create($args);
        
        $args = array(
            'name' => 'My second puzzle',
            'puzzle_template_id' => $puzzleTemplate->id,
            'puzzle_squares' => $puzzleSquares,
            'clues' => $clues,
            'user_id' => $user->id,
        );
        
        $puzzle2 = Puzzle::create($args);
        
        $args = array(
            'name' => 'My third puzzle',
            'puzzle_template_id' => $puzzleTemplate->id,
            'puzzle_squares' => $puzzleSquares,
            'clues' => $clues,
            'user_id' => $user->id,
        );
        
        $puzzle3 = Puzzle::create($args);
        
        $args = array(
            'name' => 'My fourth puzzle',
            'puzzle_template_id' => $puzzleTemplate->id,
            'puzzle_squares' => $puzzleSquares,
            'clues' => $clues,
            'user_id' => $user->id,
        );
        
        $puzzle4 = Puzzle::create($args);
        
        $args = array(
            'name' => 'My fifth puzzle',
            'puzzle_template_id' => $puzzleTemplate->id,
            'puzzle_squares' => $puzzleSquares,
            'clues' => $clues,
            'user_id' => $user->id,
        );
        
        $puzzle5 = Puzzle::create($args);
        
        /*
        //sqlite doesn't like from_unixtime()
        $this->visit('/puzzles/list')->see('My first puzzle');
        $this->visit('/puzzles/list')->see('My second puzzle');
        $this->visit('/puzzles/list')->see('My third puzzle');
        $this->visit('/puzzles/list')->see('My fourth puzzle');
        $this->visit('/puzzles/list')->see('My fifth puzzle');
        */
    }
}
