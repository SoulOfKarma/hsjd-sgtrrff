<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoApMantencionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_ap_mantenciones', function (Blueprint $table) {
            $table->id();
            $table->string('id_mantencionAP');
            $table->bigInteger('codMan');
            $table->bigInteger('idEstadoManAP');
            $table->bigInteger('codManMes');
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
        Schema::dropIfExists('estado_ap_mantenciones');
    }
}
