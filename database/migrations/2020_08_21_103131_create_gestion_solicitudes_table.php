<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestion_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->bigInteger('id_solicitud');
            $table->bigInteger('id_trabajador');
            $table->bigInteger('id_supervisor');
            $table->bigInteger('idApoyo1');
            $table->bigInteger('idApoyo2');
            $table->bigInteger('idApoyo3');
            $table->bigInteger('idTurno');
            $table->time('horaInicio');
            $table->time('horaCambiada')->nullable();
            $table->time('horaTermino');
            $table->date('fechaInicio');
            $table->date('fechaCambiada')->nullable();
            $table->date('fechaTermino');
            $table->bigInteger('diasEjecucion');
            $table->bigInteger('horasEjecucion');
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
        Schema::dropIfExists('gestion_solicitudes');
    }
}
