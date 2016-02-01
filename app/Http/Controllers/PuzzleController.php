<?php namespace App\Http\Controllers;

use Auth;
use Input;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Puzzle;
use App\Models\PuzzleTemplate;
use App\Models\User;

class PuzzleController extends Controller
{
    public function showPopularPuzzles(){
        $puzzles = Puzzle::take(5)->get();
        
        return $puzzles;
    }
    
    public function postPuzzleTemplate(){
        $user = Auth::user();
        if (!$user){
            return array('errors', array('Please log in'));
        }
        
        $pt = new PuzzleTemplate;
        $args = Input::all();
        $args['user_id'] = $user->id;
        
        if ($pt->validate($args)){
            return PuzzleTemplate::create($args);
        }else{
            abort('401', $pt->errors());
        }
        
    }
    
    public function getPuzzleTemplates(){
        $pts = PuzzleTemplate::leftjoin('users', 'users.id', '=', 'puzzle_templates.user_id')
            ->selectRaw('puzzle_templates.name, puzzle_templates.slug, width, height, users.name owner, users.username, concat(from_unixtime(puzzle_templates.timestamp_utc), \' GMT\') created')
            ->where('puzzle_templates.active', 1)->get();
        
        return $pts;
    }
}
