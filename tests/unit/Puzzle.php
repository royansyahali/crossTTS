<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Clue;
use App\Models\Puzzle;
use App\Models\PuzzleTemplate;
use App\Models\User;

class ViewAPuzzleTest extends TestCase
{
    use DatabaseMigrations;
        
    /**
     * A basic functional test example.
     *
     * @return void
     */
     
    public function testViewingAPuzzle(){
        $faker = Faker\Factory::create();
        
        $user = factory(User::class)->create(['username' => 'jondoe1']);
        
        $name = $faker->sentence;
        $width = $faker->numberBetween(5,20);
        $height = $faker->numberBetween(5,20);
        
        $blackSquares = array();
        
        for ($i = 1; $i < $faker->numberBetween(2,20); $i++){
            $blackSquares[] = $faker->numberBetween(1, $width).'-'.$faker->numberBetween(1, $height);
        }
        
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
        
        $puzzle_squares = array();
        
        $ordinal = 1;
        $clues = array();
        
        for($row = 1; $row <= $height; $row++){
            for($col = 1; $col <= $width; $col++){
                if (!in_array($row.'-'.$col, $puzzleTemplate->blackSquares())){
                    $letter = substr($faker->word, 0, 1);
                    $puzzle_squares[] = array(
                        'row' => $row,
                        'col' => $col,
                        'letter' => $letter,
                        'square_type' => 'white',
                    );
                }
                
                if ($row == 1 || in_array(($row - 1).'-'.$col, $puzzleTemplate->blackSquares())){
                    //needs a down clue
                    $clue = new Clue;
                    $clue->clue = $faker->sentence;
                    $clue->ordinal = $ordinal;
                    $clue->direction = 'down';
                    $clues[] = $clue;
                }
                
                if ($col == 1 || in_array($row.'-'.($col - 1), $puzzleTemplate->blackSquares())){
                    //needs an across clue
                    $clue = new Clue;
                    $clue->clue = $faker->sentence;
                    $clue->ordinal = $ordinal;
                    $clue->direction = 'across';
                    
                    $clues[] = $clue;
                }
                if ($row == 1 || in_array(($row - 1).'-'.$col, $puzzleTemplate->blackSquares()) || $col == 1 || in_array($row.'-'.($col - 1), $puzzleTemplate->blackSquares())){
                    $ordinal++;
                }
            }
        }
        
        $args = array(
            'name' => $name,
            'user_id' => $user->id,
            'puzzle_template_id' => $puzzleTemplate->id,
            'puzzle_squares' => $puzzle_squares,
            'clues' => $clues,
        );
        
        $puzzle = Puzzle::create($args);
        
        $user->puzzles()->save($puzzle);
        
        $this->visit('/puzzles/'.$puzzle->slug)->see($name);
    }
}
