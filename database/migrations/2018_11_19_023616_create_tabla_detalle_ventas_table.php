<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaDetalleVentasTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->date('fecha');

            $table->unsignedInteger('fkstock');
            $table->unsignedInteger('fkfactura');

            $table->foreign('fkstock')->references('id')->on('stock')->onUpdate('cascade');
            $table->foreign('fkfactura')->references('id')->on('factura')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_venta');
    }
}
