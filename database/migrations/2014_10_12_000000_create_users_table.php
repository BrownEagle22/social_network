<?php

use Illuminate\Support\Facades\Schema;
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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('picture_path');
            $table->date('date_born');
            $table->string('description');
            $table->integer('role')->unsigned()->default(1);
            $table->integer('privacy_type_id')->unsigned();
            $table->integer('deleter_id')->unsigned();

            $table->foreign('deleter_id')->references('id')->on('users');
            $table->foreign('privacy_type_id')->references('id')->on('privacy_type');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
