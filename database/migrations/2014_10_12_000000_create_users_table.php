<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('google_id')->unique();
            // $table->string('screen_name')->nullable();
            // $table->string('description')->nullable();
            // $table->string('url')->nullable();
            // $table->string('utc_offset')->nullable();
            // $table->string('profile_background_image_url')->nullable();
            // $table->string('profile_image_url')->nullable();
            // $table->string('oauth_token')->nullable();
            // $table->string('oauth_token_secret')->nullable();
            $table->integer('created_timestamp_utc')->unsigned();
            $table->integer('updated_timestamp_utc')->unsigned();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->rememberToken();
            $table->integer('google_user_id')->unsigned()->nullable()->unique();
            $table->foreign('google_user_id')->references('id')->on('google_users');
            $table->boolean('admin')->default(0);
            $table->boolean('active')->default(1);
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
        Schema::drop('users');
        Schema::drop('google_users');
    }
}
