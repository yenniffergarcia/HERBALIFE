<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaEquiposExpansionTable extends Migration
{
    public function up()
    {
        Schema::create('equipo_expansion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100)->unique();
            $table->decimal('porcentaje', 10,2)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipo_expansion');
    }
}
