<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaDetalleCargasTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_carga', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->date('fecha_vencimiento');
            $table->boolean('estado')->default(1);
            
            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkproducto');

            $table->foreign('fkproducto')->references('id')->on('producto')->onUpdate('cascade');
            $table->foreign('fkpersona')->references('id')->on('persona')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_carga');
    }
}
