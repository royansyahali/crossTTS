<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitter_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('twitter_id')->unique();
            $table->string('screen_name')->nullable();
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->string('utc_offset')->nullable();
            $table->string('profile_background_image_url')->nullable();
            $table->string('profile_image_url')->nullable();
            $table->string('oauth_token')->nullable();
            $table->string('oauth_token_secret')->nullable();
            $table->integer('created_timestamp_utc')->unsigned();
            $table->integer('updated_timestamp_utc')->unsigned();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->rememberToken();
            $table->integer('twitter_user_id')->unsigned()->nullable()->unique();
            $table->foreign('twitter_user_id')->references('id')->on('twitter_users');
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
        Schema::drop('twitter_users');
    }
}
