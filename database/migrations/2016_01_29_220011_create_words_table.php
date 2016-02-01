<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->increments('id');
            $table->string('word')->unique();
            $table->mediumInteger('length')->index();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('timestamp_utc')->unsigned();
        });
        Schema::create('letters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('letter',1);
            $table->integer('word_id')->unsigned()->default(0);
            $table->foreign('word_id')->references('id')->on('words');
            $table->mediumInteger('ordinal')->index();
        });
        Schema::create('clues_available', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('word_id')->unsigned()->default(0);
            $table->foreign('word_id')->references('id')->on('words');
            $table->string('clue');
            $table->integer('timestamp_utc')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clues_available');
        Schema::drop('letters');
        Schema::drop('words');
    }
}
