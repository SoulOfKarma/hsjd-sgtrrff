<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarioGasfitersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendario_gasfiters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('descripcion_gasfiters');
            $table->bigInteger('id_turno');
            $table->bigInteger('id_trabajador');
            $table->bigInteger('id_edificio');
            $table->string('label');
            $table->string('classes');
            $table->bigInteger('id_val_dia_administrativo');
            $table->bigInteger('id_val_vacaciones');
            $table->bigInteger('id_val_reemplazo');
            $table->bigInteger('id_val_turno_extra');           
            $table->time('hora_inicio')->nullable();
            $table->time('hora_termino')->nullable();
            $table->date('startDate');
            $table->date('endDate');
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
        Schema::dropIfExists('calendario_gasfiters');
    }
}
