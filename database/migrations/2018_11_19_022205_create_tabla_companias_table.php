<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaCompaniasTable extends Migration
{
    public function up()
    {
        Schema::create('compania', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',10)->unique();
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compania');
    }
}
