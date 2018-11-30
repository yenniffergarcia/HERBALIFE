<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaClienteTable extends Migration
{
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('apellido',100);
            $table->string('direccion',100);
            $table->string('telefono',8)->unique();
            $table->boolean('estado')->default(1); 
            
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}
