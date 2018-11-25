<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaPaqueteProductosTable extends Migration
{
    public function up()
    {
        Schema::create('paquete_producto', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('estado')->default(1);

            $table->unsignedInteger('fkproducto');
            $table->unsignedInteger('fkpaquete');

            $table->foreign('fkproducto')->references('id')->on('producto')->onUpdate('cascade');
            $table->foreign('fkpaquete')->references('id')->on('paquete_inicial')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paquete_producto');
    }
}
