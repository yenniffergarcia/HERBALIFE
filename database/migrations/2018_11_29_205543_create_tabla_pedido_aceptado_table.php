<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaPedidoAceptadoTable extends Migration
{
    public function up()
    {
        Schema::create('pedido_aceptado', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');

            $table->unsignedInteger('fkstock');
            $table->unsignedInteger('fkpedido');

            $table->foreign('fkstock')->references('id')->on('stock')->onUpdate('cascade');
            $table->foreign('fkpedido')->references('id')->on('pedido')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido_aceptado');
    }
}
