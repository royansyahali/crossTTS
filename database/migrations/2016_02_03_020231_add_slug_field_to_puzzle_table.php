<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugFieldToPuzzleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('puzzles', function (Blueprint $table) {
            $table->string('slug')->unique()->default('');
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
            $table->dropForeign('puzzles_slug_unique');
            $table->dropColumn('slug');
        });
    }
}
