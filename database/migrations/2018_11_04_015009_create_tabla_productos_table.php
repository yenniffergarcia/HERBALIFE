<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaProductosTable extends Migration
{
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50)->unique();
            $table->string('descripcion', 1000);
            $table->decimal('punto', 10,2);
            $table->decimal('precio', 10, 2);
            $table->boolean('estado')->default(1); 

            $table->unsignedInteger('fkcategoria');
            $table->foreign('fkcategoria')->references('id')->on('categorias')->onUpdate('cascade')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
