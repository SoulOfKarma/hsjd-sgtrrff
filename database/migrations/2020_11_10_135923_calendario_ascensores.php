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
            $table->string('label_Local');
            $table->bigInteger('id_turnoextra');
            $table->time('hora_inicio_turno_extra')->nullable();
            $table->time('hora_termino_turno_extra'->nullable());
            $table->date('fecha_inicio_turno_extra'->nullable());
            $table->date('fecha_termino_turno_extra'->nullable());
            $table->bigInteger('dias_ejecucion_turno_extra'->nullable());
            $table->bigInteger('horas_ejecucion_turno_extra'->nullable());
            $table->bigInteger('id_vacaciones');
            $table->date('fecha_inicio_vacaciones'->nullable());
            $table->date('fecha_termino_vacaciones'->nullable());
            $table->bigInteger('dias_ejecucion_vacaciones'->nullable());
            $table->time('hora_inicio')->nullable();
            $table->time('hora_termino')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_termino');
            $table->bigInteger('dias_ejecucion');
            $table->bigInteger('horas_ejecucion')->nullable();
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
