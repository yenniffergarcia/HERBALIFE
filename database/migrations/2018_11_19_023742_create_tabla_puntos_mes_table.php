<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaPuntosMesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntos_mes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fkmes');
            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkfactura');

            $table->foreign('fkmes')->references('id')->on('tabla_meses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fkpersona')->references('id')->on('personas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fkfactura')->references('id')->on('facturas')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('puntos_mes');
    }
}
