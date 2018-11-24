<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaTelefonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telefonos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero',10);
            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkcompania');

            $table->foreign('fkpersona')->references('id')->on('personas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fkcompania')->references('id')->on('companias')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('telefonos');
    }
}
