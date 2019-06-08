<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('owner_id')->unsigned();
            $table->integer('privacy_type_id')->unsigned();
            $table->integer('deleter_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('description');
            $table->string('picture_path')->nullable();

            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('privacy_type_id')->references('id')->on('privacy_type');
            $table->foreign('deleter_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
