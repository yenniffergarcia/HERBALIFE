<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre1',50);
            $table->string('nombre2',50)->nullable();
            $table->string('apellido1',50);
            $table->string('apellido2',50)->nullable();
            $table->string('apellido3',50)->nullable();
            $table->string('codigo',30);
            $table->string('direccion',50);
            $table->integer('idPadre');
            $table->unsignedInteger('fkdepartamento');
            $table->string('email',100);


            $table->foreign('fkdepartamento')->references('id')->on('Departamentos')->onUpdate('cascade')->onDelete('cascade');
            
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
        Schema::dropIfExists('personas');
    }
}
