<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaCategoriasTable extends Migration
{
    public function up()
    {
        Schema::create('categoria', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50);
            $table->boolean('estado')->default(1);            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categoria');
    }
}
