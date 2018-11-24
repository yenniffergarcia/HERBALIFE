<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaDetalleCargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_cargas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkproducto');
            $table->date('fecha_vencimiento');

            $table->foreign('fkproducto')->references('id')->on('tabla_productos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fkpersona')->references('id')->on('personas')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detalle_cargas');
    }
}
