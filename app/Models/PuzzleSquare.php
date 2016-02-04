<?php namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class PuzzleSquare extends Model {
    protected $table = 'puzzle_squares';
    public $timestamps = FALSE;
    
    public static function replace($args){
        //require puzzle_id, row, col
        if (isset($args['puzzle_id']) && isset($args['row']) && isset($args['col'])){
            $ps = PuzzleSquare::where('puzzle_id', $args['puzzle_id'])
                ->where('row', $args['row'])
                ->where('col', $args['col'])
                ->first();
            if (!$ps){
                $ps = new PuzzleSquare;
                $ps->puzzle_id = $args['puzzle_id'];
                $ps->row = $args['row'];
                $ps->col = $args['col'];
            }
            $ps->letter = isset($args['letter']) ? $args['letter'] : "";
            $ps->save();
            
            return $ps;
        }else{
            return array('errors' => array('incomplete input for puzzle square'));
        }
    }
    
    public static function findSuggestion($puzzle, $row, $col){
        $across_word = array();
        $down_word = array();
        
        $down_squares = self::where('puzzle_id', $puzzle->id)
            ->where('col', $col)->orderBy('row')->get();
            
        $keepLookingDown = true;
        $i = 0;
        while ($keepLookingDown){
            $down_word[800 + $i] = $down_squares[$row + $i - 1];
            $i++;
            if (@!$down_squares[$row + $i - 1] || $down_squares[$row + $i - 1]->square_type == 'black'){
                $keepLookingDown = false;
            }
        }
        $keepLookingUp = true;
        $i = 0;
        while ($keepLookingUp){
            $down_word[800 - $i] = $down_squares[$row - $i - 1];
            $i++;
            if (@!$down_squares[$row - $i - 1] || $down_squares[$row - $i - 1]->square_type == 'black'){
                $keepLookingUp = false;
            }
        }
        ksort($down_word);
        $i = 1;
        foreach($down_word as $k=>$sq){
            $down_word[$i++] = $sq;
            unset($down_word[$k]);
        }
        
        $across_squares = self::where('puzzle_id', $puzzle->id)
            ->where('row', $row)->orderBy('col')->get();
            
        $keepLookingRight = true;
        $i = 0;
        while ($keepLookingRight){
            $across_word[800 + $i] = $across_squares[$col + $i - 1];
            $i++;
            if (@!$across_squares[$col + $i - 1] || $across_squares[$col + $i - 1]->square_type == 'black'){
                $keepLookingRight = false;
            }
        }
        $keepLookingLeft = true;
        $i = 0;
        while ($keepLookingLeft){
            $across_word[800 - $i] = $across_squares[$col - $i - 1];
            $i++;
            if (@!$across_squares[$col - $i - 1] || $across_squares[$col - $i - 1]->square_type == 'black'){
                $keepLookingLeft = false;
            }
        }
        
        ksort($across_word);
        $i = 1;
        foreach($across_word as $k=>$sq){
            $across_word[$i++] = $sq;
            unset($across_word[$k]);
        }
        
        $across_query = "select l.letter , count(l.id) c
            from words w 
            left join letters l on l.word_id = w.id
            where w.length = ?
            and l.ordinal = ? ";
        $params = array(count($across_word), ($col - $across_word[1]['col'] + 1));
        
        foreach($across_word as $k=>$square){
            if ($square->letter != ""){
                $across_query .= " and w.id in (select word_id from letters where letter = ? and ordinal = ?) 
                ";
                $params[] = $square->letter;
                $params[] = $square->col - $across_word[1]['col'] + 1;
            }
        }
        $across_query .= " group by l.letter ";
        
        
        $down_query = "select l.letter , count(l.id) c
            from words w 
            left join letters l on l.word_id = w.id
            where w.length = ?
            and l.ordinal = ? ";
        $params[] = count($down_word);
        $params[] = $row - $down_word[1]['row'] + 1;
        
        foreach($down_word as $k=>$square){
            if ($square->letter != ""){
                $down_query .= " and w.id in (select word_id from letters where letter = ? and ordinal = ?) 
                ";
                $params[] = $square->letter;
                $params[] = $square->row - $down_word[1]['row'] + 1;
            }
        }
        $down_query .= " group by l.letter ";
        
        $query = "select a.c*d.c score, a.letter 
            from ($across_query) a 
            inner join ($down_query) d on a.letter = d.letter
            order by score desc";
        
        $suggestions = DB::select(DB::raw($query), $params);
        
        $word_count = Word::count();
        
        return compact('word_count', 'suggestions');
    }
}