<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Puzzle;
use App\Models\PuzzleTemplate;
use App\Models\User;

class ViewAPuzzleTemplateTest extends TestCase
{
    use DatabaseMigrations;
        
    /**
     * A basic functional test example.
     *
     * @return void
     */
     
    public function testViewingAPuzzleTemplate(){
        $faker = Faker\Factory::create();
        
        $user = factory(User::class)->create(['username' => 'jondoe']);
        
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
        
        //Disable this test because mysqlite doesn't like 'from_unixtime' or 'concat' :(
        //$this->visit('/puzzle_templates/'.$puzzleTemplate->slug)->see($name);
    }
    
    public function testViewingAUsersPuzzleTemplate()
    {
        $user = factory(User::class)->create(['username' => 'johndoe3']);
        $puzzleTemplate = factory(PuzzleTemplate::class)->make([
            'name' => 'My first puzzle template', 
            'width' => 5, 
            'height' => 5
        ]);
        
        $user->puzzleTemplates()->save($puzzleTemplate);
        
        //Disable this test because mysqlite doesn't like 'from_unixtime' or 'concat' :(
        //$this->visit('/johndoe3/puzzle_templates')->see('My first puzzle template');
    }
}
