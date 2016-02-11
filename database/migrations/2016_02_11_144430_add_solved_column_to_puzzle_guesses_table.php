<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSolvedColumnToPuzzleGuessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('puzzle_guesses', function (Blueprint $table) {
            $table->integer('solved_timestamp_utc')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('puzzle_guesses', function (Blueprint $table) {
            $table->dropColumn('solved_timestamp_utc');
        });
    }
}
