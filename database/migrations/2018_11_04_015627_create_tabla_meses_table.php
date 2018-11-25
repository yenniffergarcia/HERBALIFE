<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaMesesTable extends Migration
{
    public function up()
    {
        Schema::create('mes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mes',20);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mes');
    }
}
