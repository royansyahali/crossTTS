<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Clue;
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
    
    public function testGuessingTheLastCorrectSquare(){
        $faker = Faker\Factory::create();
        
        $user_creator = factory(User::class)->create(['username' => 'trevorrosenthal']);
        $user_guesser = factory(User::class)->create(['username' => 'nickhundley']);
        
        $name = $faker->sentence;
        $width = 5;
        $height = 5;
        
        $blackSquares = array('1-1', '5-5');
        
        $args = array(
            'name' => $name,
            'width' => $width,
            'height' => $height,
            'blackSquares' => $blackSquares,
            'user_id' => $user_creator->id,
        );
        
        $puzzleTemplate = PuzzleTemplate::create($args);
        
        $user_creator->puzzleTemplates()->save($puzzleTemplate);
        
        $name = $faker->sentence;

        $puzzleSquares = array();
        
        $clues = array();
        
        $args = array(
            'name' => $name,
            'puzzle_template_id' => $puzzleTemplate->id,
            'puzzle_squares' => $puzzleSquares,
            'clues' => $clues,
            'user_id' => $user_creator->id,
        );
        
        $puzzle = Puzzle::create($args);
        
        $firstword = "shop";
        $secondword = "shove";
        $thirdword = "wanes";
        $fourthword = "arent";
        $fifthword = "beds";
        
        for($k = 0; $k < strlen($firstword); $k++){
            $args = array(
                'row' => 1,
                'col' => $k + 2,
                'letter' => substr($firstword, $k, 1),
                'puzzle_id' => $puzzle->id,
            );
            PuzzleSquare::replace($args);
        }
        
        for($k = 0; $k < strlen($secondword); $k++){
            $args = array(
                'row' => 2,
                'col' => $k + 1,
                'letter' => substr($secondword, $k, 1),
                'puzzle_id' => $puzzle->id,
            );
            PuzzleSquare::replace($args);
        }
        
        for($k = 0; $k < strlen($thirdword); $k++){
            $args = array(
                'row' => 3,
                'col' => $k + 1,
                'letter' => substr($thirdword, $k, 1),
                'puzzle_id' => $puzzle->id,
            );
            PuzzleSquare::replace($args);
        }
        
        for($k = 0; $k < strlen($fourthword); $k++){
            $args = array(
                'row' => 4,
                'col' => $k + 1,
                'letter' => substr($fourthword, $k, 1),
                'puzzle_id' => $puzzle->id,
            );
            PuzzleSquare::replace($args);
        }
        
        for($k = 0; $k < strlen($fifthword); $k++){
            $args = array(
                'row' => 5,
                'col' => $k + 1,
                'letter' => substr($fifthword, $k, 1),
                'puzzle_id' => $puzzle->id,
            );
            PuzzleSquare::replace($args);
        }
        
        $clue_str = $faker->sentence;
        
        $across_clues = array(
            array(
                'ordinal'   => 1,
                'clue'      => 'Woodworking locale',
            ),
            array(
                'ordinal'   => 5,
                'clue'      => 'Forcefully move',
            ),
            array(
                'ordinal'   => 6,
                'clue'      => 'Lessens',
            ),
            array(
                'ordinal'   => 7,
                'clue'      => '"I\'m right, _____ I?',
            ),
            array(
                'ordinal'   => 8,
                'clue'      => 'Places for flowers',
            ),
        );
        $down_clues = array(
            array(
                'ordinal'   => 1,
                'clue'      => 'Unit of stock',
            ),
            array(
                'ordinal'   => 2,
                'clue'      => 'Sharpened (as skills)',
            ),
            array(
                'ordinal'   => 3,
                'clue'      => 'Baking appliances',
            ),
            array(
                'ordinal'   => 4,
                'clue'      => 'Insect',
            ),
            array(
                'ordinal'   => 5,
                'clue'      => 'Gently Brush',
            ),
        );
        
        foreach($across_clues as $clue){
            $args = array(
                'puzzle_slug' => $puzzle->slug,
                'clue' => $clue['clue'],
                'ordinal' => $clue['ordinal'],
                'direction' => 'across',
            );
            $clue = Clue::replace($args);
        }
        
        foreach($down_clues as $clue){
            $args = array(
                'puzzle_slug' => $puzzle->slug,
                'clue' => $clue['clue'],
                'ordinal' => $clue['ordinal'],
                'direction' => 'down',
            );
            $clue = Clue::replace($args);
        }
        
        $ret = $puzzle->activate();
        
        
        for($k = 0; $k < strlen($firstword); $k++){
            $args = array(
                'row' => 1,
                'col' => $k + 2,
                'letter' => substr($firstword, $k, 1),
                'puzzle_slug' => $puzzle->slug,
                'user_id' => $user_guesser->id,
            );
            $pgs = PuzzleGuessSquare::replace($args);
        }
        
        $this->assertEquals($pgs['solved'], '0');
        
        for($k = 0; $k < strlen($secondword); $k++){
            $args = array(
                'row' => 2,
                'col' => $k + 1,
                'letter' => substr($secondword, $k, 1),
                'puzzle_slug' => $puzzle->slug,
                'user_id' => $user_guesser->id,
            );
            $pgs = PuzzleGuessSquare::replace($args);
        }
        
        $this->assertEquals($pgs['solved'], '0');
        
        for($k = 0; $k < strlen($thirdword); $k++){
            $args = array(
                'row' => 3,
                'col' => $k + 1,
                'letter' => substr($thirdword, $k, 1),
                'puzzle_slug' => $puzzle->slug,
                'user_id' => $user_guesser->id,
            );
            $pgs = PuzzleGuessSquare::replace($args);
        }
        
        $this->assertEquals($pgs['solved'], '0');
        
        for($k = 0; $k < strlen($fourthword); $k++){
            $args = array(
                'row' => 4,
                'col' => $k + 1,
                'letter' => substr($fourthword, $k, 1),
                'puzzle_slug' => $puzzle->slug,
                'user_id' => $user_guesser->id,
            );
            $pgs = PuzzleGuessSquare::replace($args);
        }
        
        $this->assertEquals($pgs['solved'], '0');
        
        for($k = 0; $k < strlen($fifthword); $k++){
            $args = array(
                'row' => 5,
                'col' => $k + 1,
                'letter' => substr($fifthword, $k, 1),
                'puzzle_slug' => $puzzle->slug,
                'user_id' => $user_guesser->id,
            );
            $pgs = PuzzleGuessSquare::replace($args);
        }
        
        $this->assertEquals($pgs['solved'], '1');
    }
    
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
        
        $pgs = PuzzleGuessSquare::replace($args);
        
        $this->actingAs($user_guesser)->visit('/puzzles/'.$puzzle->slug)->see($guess);
    }
}
