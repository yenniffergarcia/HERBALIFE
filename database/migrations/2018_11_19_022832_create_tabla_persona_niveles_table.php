<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaPersonaNivelesTable extends Migration
{
    public function up()
    {
        Schema::create('persona_nivel', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('estado')->default(1);
            
            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fknivel');

            $table->foreign('fkpersona')->references('id')->on('persona')->onUpdate('cascade');
            $table->foreign('fknivel')->references('id')->on('nivel')->onUpdate('cascade');
            
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('persona_nivel');
    }
}
