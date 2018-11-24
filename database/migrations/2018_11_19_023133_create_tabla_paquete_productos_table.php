<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaPaqueteProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquete_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fkproducto');
            $table->unsignedInteger('fkpaquete');

            $table->foreign('fkproducto')->references('id')->on('tabla_productos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fkpaquete')->references('id')->on('paquete_iniciales')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('paquete_productos');
    }
}
