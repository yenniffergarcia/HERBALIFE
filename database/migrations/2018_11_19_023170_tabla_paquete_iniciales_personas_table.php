<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaPaqueteInicialesPersonasTable extends Migration
{
    public function up()
    {
        Schema::create('paquete_inicial_persona', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('estado')->default(1);

            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkpaquete_producto');

            $table->foreign('fkpersona')->references('id')->on('persona')->onUpdate('cascade');
            $table->foreign('fkpaquete_producto')->references('id')->on('paquete_producto')->onUpdate('cascade');


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paquete_inicial_persona');
    }
}
