<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnoExtraCalderasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turno_extra_calderas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_calendario_calderas');
            $table->time('hora_inicio_turno_extra');
            $table->time('hora_termino_turno_extra');
            $table->date('fecha_inicio_turno_extra');
            $table->date('fecha_termino_turno_extra');
            $table->bigInteger('dias_ejecucion_turno_extra');
            $table->bigInteger('horas_ejecucion_turno_extra'); 
            $table->boolean('estado_turno_extra');
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
        Schema::dropIfExists('turno_extra_calderas');
    }
}
