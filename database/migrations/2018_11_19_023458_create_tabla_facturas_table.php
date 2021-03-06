<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaFacturasTable extends Migration
{
    public function up()
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->decimal('subtotal', 10,2);
            $table->decimal('total', 10,2);
            $table->boolean('estado')->default(1);
            $table->boolean('pagado')->default(0);

            $table->string('fkcodigo', 11);            
            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkpersonivel');

            $table->foreign('fkcodigo')->references('codigo')->on('persona')->onUpdate('cascade');
            $table->foreign('fkpersona')->references('id')->on('persona')->onUpdate('cascade');
            $table->foreign('fkpersonivel')->references('id')->on('persona_nivel')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido');
    }
}
