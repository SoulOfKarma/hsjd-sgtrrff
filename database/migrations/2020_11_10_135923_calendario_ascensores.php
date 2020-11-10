<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CalendarioAscensores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendario_ascensores', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_ascensores');
            $table->string('descripcion_ascensores');
            $table->bigInteger('id_cambio_turno');
            $table->bigInteger('id_dia_administrativo');
            $table->bigInteger('id_vacaciones');
            $table->bigInteger('id_turno_extra');
            $table->bigInteger('id_trabajador');
            $table->bigInteger('id_edificio');
            $table->string('descripcion_ubicacion_ascensor');
            $table->time('horaInicioTurnoExtra')->nullable();
            $table->time('horaTerminoTurnoExtra'->nullable());
            $table->date('fechaInicioTurnoExtra'->nullable());
            $table->date('fechaTerminoTurnoExtra'->nullable());
            $table->bigInteger('diasEjecucionTurnoExtra'->nullable());
            $table->bigInteger('horasEjecucionTurnoExtra'->nullable());
            $table->time('horaInicio');
            $table->time('horaTermino');
            $table->date('fechaInicio');
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
        //
    }
}
