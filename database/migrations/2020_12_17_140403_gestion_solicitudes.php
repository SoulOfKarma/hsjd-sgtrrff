<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GestionSolicitudes extends Migration
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
            $table->bigInteger('idDuracion')->nullable();
            $table->time('horaInicio');
            $table->time('horaCambiada')->nullable();
            $table->time('horaTermino')->nullable();
            $table->date('fechaInicio');
            $table->date('fechaCambiada')->nullable();
            $table->date('fechaTermino')->nullable();
            $table->bigInteger('diasEjecucion')->nullable();
            $table->bigInteger('horasEjecucion')->nullable();
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
        //
    }
}
