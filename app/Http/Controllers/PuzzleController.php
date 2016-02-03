<?php namespace App\Http\Controllers;

use Auth;
use Input;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Puzzle;
use App\Models\PuzzleSquare;
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
        $pts = PuzzleTemplate::findActive();
        
        return $pts;
    }
    
    public function getPuzzleTemplate($slug){
        return PuzzleTemplate::findBySlug($slug);
    }
    
    public function getSuggestion($slug, $row, $col){
        $user = Auth::user();
        if (!$user){
            return array('errors', array('Please log in'));
        }
        $p = Puzzle::findBySlug($slug);
        
        if ($p->user_id != $user->id){
            return array('errors', array('This isn\'t your puzzle'));
        }
        
        return PuzzleSquare::findSuggestion($p, $row, $col);
    }
}
