<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fkpersona');
            $table->unsignedInteger('fkdetallecarg');
            $table->integer('cantidad');


            $table->foreign('fkpersona')->references('id')->on('personas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fkdetallecarg')->references('id')->on('detalle_cargas')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('stocks');
    }
}
