<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaPagosAsociadosTable extends Migration
{
    public function up()
    {
        Schema::create('pago_asociado', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('monto', 10,2);
            $table->string('anio', 4);

            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkmes');

            $table->foreign('fkpersona')->references('id')->on('persona')->onUpdate('cascade');
            $table->foreign('fkmes')->references('id')->on('mes')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pago_asociado');
    }
}
