<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaPuntosMesTable extends Migration
{
    public function up()
    {
        Schema::create('punto_mes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->decimal('punto', 10,2);

            $table->unsignedInteger('fkmes');
            $table->unsignedInteger('fkpersona');

            $table->foreign('fkmes')->references('id')->on('mes')->onUpdate('cascade');
            $table->foreign('fkpersona')->references('id')->on('persona')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('punto_mes');
    }
}
