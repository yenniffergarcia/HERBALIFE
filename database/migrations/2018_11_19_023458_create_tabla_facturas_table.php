<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codpersona',30);
            $table->date('fecha');
            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkpersonivel');
            $table->integer('total');

            $table->foreign('fkpersona')->references('id')->on('personas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fkpersonivel')->references('id')->on('persona_niveles')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('facturas');
    }
}
