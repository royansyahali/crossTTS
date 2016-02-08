<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuzzleGuessTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puzzle_guesses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('puzzle_id')->unsigned();
            $table->foreign('puzzle_id')->references('id')->on('puzzles');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('created_timestamp_utc')->nullable()->unsigned();
            $table->integer('updated_timestamp_utc')->nullable()->unsigned();
        });
        Schema::create('puzzle_guess_squares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('puzzle_guess_id')->unsigned();
            $table->foreign('puzzle_guess_id')->references('id')->on('puzzle_guesses');
            $table->integer('row');
            $table->integer('col');
            $table->string('letter',1);
            $table->integer('timestamp_utc')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('puzzle_guess_squares');
        Schema::drop('puzzle_guesses');
    }
}
