<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuzzleTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puzzle_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 64)->unique();
            $table->string('name');
            $table->tinyInteger('active')->default(0);
            $table->integer('width');
            $table->integer('height');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->tinyInteger('symmetrical')->default(1);
            $table->integer('created_timestamp_utc')->unsigned();
            $table->integer('updated_timestamp_utc')->unsigned();
        });
        
        Schema::create('puzzle_template_squares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('puzzle_template_id')->unsigned();
            $table->foreign('puzzle_template_id')->references('id')->on('puzzle_templates');
            $table->integer('x');
            $table->integer('y');
            $table->enum('square_type', array('white', 'black', 'circle'));
            $table->integer('created_timestamp_utc')->unsigned();
            $table->integer('updated_timestamp_utc')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('puzzle_template_squares');
        Schema::drop('puzzle_templates');
    }
}
