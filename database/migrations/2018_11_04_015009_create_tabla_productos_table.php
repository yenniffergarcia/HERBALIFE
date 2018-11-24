<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaProductosTable extends Migration
{
   
    public function up()
    {
        Schema::create('tabla_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 20)->unique();
            $table->string('descripcion', 1000);
            $table->integer('punto');
            $table->decimal('precio', 10, 2);

            $table->unsignedInteger('fkcategoria');

            $table->foreign('fkcategoria')->references('id')->on('tabla_categorias')->onUpdate('cascade')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

  
    public function down()
    {
        Schema::dropIfExists('tabla_productos');
    }
}
