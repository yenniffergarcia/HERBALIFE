<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaDescuentosTable extends Migration
{
    public function up()
    {
        Schema::create('descuento', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('porcentaje', 5,2)->unique();         
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('descuento');
    }
}
