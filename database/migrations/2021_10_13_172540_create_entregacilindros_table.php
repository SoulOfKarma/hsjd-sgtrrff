<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregacilindrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entregacilindros', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idCilindro');
            $table->bigInteger('cantVacio')->nullable();
            $table->bigInteger('cantLleno')->nullable();
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
        Schema::dropIfExists('entregacilindros');
    }
}
