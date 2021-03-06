<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Puzzle;
use App\Models\PuzzleTemplate;
use App\Models\User;

class ViewAnotherUsersPuzzlesTest extends TestCase
{
    use DatabaseMigrations;
        
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testViewingAPuzzle(){
        
        $faker = Faker\Factory::create();
        
        $user = factory(User::class)->create(['username' => 'krisbryant']);
        
        $name = $faker->sentence;
        $width = $faker->numberBetween(5,20);
        $height = $faker->numberBetween(5,20);
        
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

        $puzzleSquares = array();
        
        $clues = array();
        
        $args = array(
            'name' => $name,
            'puzzle_template_id' => $puzzleTemplate->id,
            'puzzle_squares' => $puzzleSquares,
            'clues' => $clues,
            'user_id' => $user->id,
        );
        
        $puzzle = Puzzle::create($args);
        
        $this->visit('/puzzles/'.$puzzle->slug)->see($name);
    }
    
    public function testViewingAnotherUsersPuzzles(){   
        $user = factory(User::class)->create(['username' => 'johndoe2']);
        $puzzle = factory(Puzzle::class)->make(['name' => 'My first puzzle']);
        
        $user->puzzles()->save($puzzle);
        
        $this->visit('/users/johndoe2/puzzles')->see('My first puzzle');
    }
}
