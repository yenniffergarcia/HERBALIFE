<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaPersonasTable extends Migration
{
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre1',50);
            $table->string('nombre2',50)->nullable();
            $table->string('apellido1',50);
            $table->string('apellido2',50)->nullable();
            $table->string('apellido3',50)->nullable();
            $table->string('codigo',11)->unique();
            $table->string('direccion',100);
            $table->integer('id_padre');
            $table->string('email',100)->unique();
            $table->boolean('estado')->default(1); 

            $table->unsignedInteger('fkdepartamento');            
            $table->foreign('fkdepartamento')->references('id')->on('departamento')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
