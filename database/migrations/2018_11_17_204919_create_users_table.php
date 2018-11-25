<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->boolean('estado')->default(1);
            
            $table->unsignedInteger('fkpersona');            
            $table->foreign('fkpersona')->references('id')->on('persona')->onUpdate('cascade');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
