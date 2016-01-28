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
    public function testViewingAPuzzleTemplate()
    {   
        $user = factory(User::class)->create(['username' => 'johndoe3']);
        $puzzleTemplate = factory(PuzzleTemplate::class)->make([
            'name' => 'My first puzzle template', 
            'width' => 5, 
            'height' => 5
        ]);
        
        $user->puzzleTemplates()->save($puzzleTemplate);
        
        $this->visit('/johndoe3/puzzleTemplates')->see('My first puzzle template');
    }
}
