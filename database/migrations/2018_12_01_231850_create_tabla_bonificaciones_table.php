<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaBonificacionesTable extends Migration
{
    public function up()
    {
        Schema::create('bonificacion', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('monto', 10,2);
            $table->string('anio', 4);

            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkequipo_expansion');
            $table->unsignedInteger('fkmes');

            $table->foreign('fkmes')->references('id')->on('mes')->onUpdate('cascade');
            $table->foreign('fkpersona')->references('id')->on('persona')->onUpdate('cascade');
            $table->foreign('fkequipo_expansion')->references('id')->on('equipo_expansion')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bonificacion');
    }
}
