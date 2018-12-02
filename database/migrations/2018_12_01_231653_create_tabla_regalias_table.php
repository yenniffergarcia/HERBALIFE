<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaRegaliasTable extends Migration
{
    public function up()
    {
        Schema::create('regalia', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('porcentaje', 10,2)->default(0.05);
            $table->decimal('monto', 10,2);
            $table->string('anio', 4);

            $table->unsignedInteger('fkpersona');
            $table->string('fkcodigo', 11);
            $table->unsignedInteger('fkmes');
            $table->unsignedInteger('fkpedido');

            $table->foreign('fkpersona')->references('id')->on('persona')->onUpdate('cascade');
            $table->foreign('fkcodigo')->references('codigo')->on('persona')->onUpdate('cascade');
            $table->foreign('fkpedido')->references('id')->on('pedido')->onUpdate('cascade');
            $table->foreign('fkmes')->references('id')->on('mes')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('regalia');
    }
}
