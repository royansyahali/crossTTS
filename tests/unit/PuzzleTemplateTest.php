<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\PuzzleTemplate;
use App\Models\User;

class PuzzleTemplateTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testASlugCanBeCreated(){
        $faker = Faker\Factory::create();
        
        $name = "My first Template";
        
        $slug = PuzzleTemplate::findSlug($name);
        
        $desired_slug = "my-first-template";
        
        $this->assertEquals($desired_slug, $slug);
    }
    
    public function testAPuzzleTemplateCanBeCreated(){
        $faker = Faker\Factory::create();
        
        $user = factory(User::class)->create(['username' => 'janedoe2']);
        
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
        
        $this->assertEquals($puzzleTemplate->name, $name);
        $this->assertEquals($puzzleTemplate->width, $width);
        $this->assertEquals($puzzleTemplate->height, $height);
    }
    
    public function testAnInvalidPuzzleTemplateCannotBeCreated(){
        $faker = Faker\Factory::create();
        
        $user = factory(User::class)->create(['username' => 'janedoe1']);
        
        $name = $faker->sentence;
        $width = $faker->numberBetween(5,20);
        $height = $faker->numberBetween(5,20);
        
        $blackSquares = array();
        
        for ($i = 1; $i < $faker->numberBetween(2,20); $i++){
            $blackSquares[] = $faker->numberBetween(1, $width).'-'.$faker->numberBetween(1, $height);
        }
        
        $puzzleTemplate = new puzzleTemplate;
        
        //Width may not be > 20
        $args = array(
            'name' => $name,
            'width' => 100,
            'height' => $height,
            'blackSquares' => $blackSquares,
            'user_id' => $user->id,
        );
        
        $this->assertFalse($puzzleTemplate->validate($args));

        //Height is required
        $args = array(
            'name' => $name,
            'width' => $width,
            'blackSquares' => $blackSquares,
            'user_id' => $user->id,
        );
        
        $this->assertFalse($puzzleTemplate->validate($args));

        //All validations are met
        $args = array(
            'name' => $name,
            'width' => $width,
            'height' => $height,
            'blackSquares' => $blackSquares,
            'user_id' => $user->id,
        );
        
        $this->assertTrue($puzzleTemplate->validate($args));
        
    }
}
