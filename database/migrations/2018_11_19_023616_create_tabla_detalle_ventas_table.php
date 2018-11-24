<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->unsignedInteger('fkstock');
            $table->unsignedInteger('fkfactura');
            $table->date('fecha');

            $table->foreign('fkstock')->references('id')->on('stocks')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detalle_ventas');
    }
}
