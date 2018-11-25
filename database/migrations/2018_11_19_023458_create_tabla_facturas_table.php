<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaFacturasTable extends Migration
{
    public function up()
    {
        Schema::create('factura', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->decimal('subtotal', 10,2);
            $table->decimal('total', 10,2);

            $table->string('fkcodigo', 10);            
            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkpersonivel');

            $table->foreign('fkcodigo')->references('id')->on('persona')->onUpdate('cascade');
            $table->foreign('fkpersona')->references('id')->on('persona')->onUpdate('cascade');
            $table->foreign('fkpersonivel')->references('id')->on('persona_nivel')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factura');
    }
}
