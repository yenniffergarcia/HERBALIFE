<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaPaqueteInicialesTable extends Migration
{
    public function up()
    {
        Schema::create('paquete_inicial', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 75)->unique();
            $table->boolean('estado')->default(1);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paquete_inicial');
    }
}
