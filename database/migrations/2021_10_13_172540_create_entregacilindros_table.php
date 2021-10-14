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
            $table->bigInteger('idTicket');
            $table->bigInteger('idCilindro');
            $table->bigInteger('cantRecepcion')->nullable();
            $table->bigInteger('cantEntrega')->nullable();
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
