<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTablePuzzleSquares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('puzzles', function (Blueprint $table) {
            $table->integer('puzzle_template_id')->unsigned()->default(0);
            $table->foreign('puzzle_template_id')->references('id')->on('puzzle_templates');
        });
        Schema::create('clues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clue');
            $table->integer('puzzle_id')->unsigned();
            $table->foreign('puzzle_id')->references('id')->on('puzzles');
            $table->integer('ordinal');
            $table->enum('direction', array('across', 'down'));
        });
        Schema::create('puzzle_squares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('puzzle_id')->unsigned();
            $table->foreign('puzzle_id')->references('id')->on('puzzles');
            $table->integer('row');
            $table->integer('col');
            $table->string('letter',1);
            $table->enum('square_type', array('white', 'black', 'circle'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('puzzles', function (Blueprint $table) {
            $table->dropForeign('puzzles_puzzle_template_id_foreign');
            $table->dropColumn('puzzle_template_id');
        });
        Schema::drop('puzzle_squares');
        Schema::drop('clues');
    }
}
