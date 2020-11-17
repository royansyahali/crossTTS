<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddDeletedColumnToPuzzlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('puzzles', function (Blueprint $table) {
            $table->integer('deleted_timestamp_utc')->nullable()->unsigned();
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
            $table->dropColumn('deleted_timestamp_utc');
        });
    }
}
