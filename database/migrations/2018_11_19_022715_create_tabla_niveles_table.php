<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaNivelesTable extends Migration
{
    public function up()
    {
        Schema::create('nivel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',50)->unique();
            $table->boolean('estado')->default(1);

            $table->unsignedInteger('fkdescuento');
            $table->foreign('fkdescuento')->references('id')->on('descuento')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nivel');
    }
}
