<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Puzzle;
use App\Models\User;

class ViewPopularPuzzlesTest extends TestCase
{
    use DatabaseMigrations;
        
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testViewingPopularPuzzles()
    {   
        $user = factory(User::class)->create(['username' => 'johndoe1']);
        $user->puzzles()->save(factory(Puzzle::class)->make(['name' => 'My first puzzle']));
        $user->puzzles()->save(factory(Puzzle::class)->make(['name' => 'My second puzzle']));
        $user->puzzles()->save(factory(Puzzle::class)->make(['name' => 'My third puzzle']));
        $user->puzzles()->save(factory(Puzzle::class)->make(['name' => 'My fourth puzzle']));
        $user->puzzles()->save(factory(Puzzle::class)->make(['name' => 'My fifth puzzle']));
        
        $this->visit('/puzzles')->see('My first puzzle');
        $this->visit('/puzzles')->see('My second puzzle');
        $this->visit('/puzzles')->see('My third puzzle');
        $this->visit('/puzzles')->see('My fourth puzzle');
        $this->visit('/puzzles')->see('My fifth puzzle');
    
    }
}
