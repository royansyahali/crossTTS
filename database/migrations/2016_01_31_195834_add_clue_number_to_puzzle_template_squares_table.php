<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClueNumberToPuzzleTemplateSquaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('puzzle_template_squares', function (Blueprint $table) {
            $table->integer('clue_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('puzzle_template_squares', function (Blueprint $table) {
            $table->dropColumn('clue_number');
        });
    }
}
