<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Puzzle;
use App\Models\PuzzleTemplate;
use App\Models\User;

class ViewAnotherUsersProfileTest extends TestCase
{
    use DatabaseMigrations;
        
    /**
     * A basic functional test example.
     *
     * @return void
     */
    
    public function testViewingAnotherUsersProfile(){   
        $user1 = factory(User::class)->create(['username' => 'paulgoldschmidt']);
        $user2 = factory(User::class)->create(['username' => 'arodysvizcaino']);
        
        $this->actingAs($user1)->visit('/users/arodysvizcaino')->see('arodysvizcaino');
    }
}
