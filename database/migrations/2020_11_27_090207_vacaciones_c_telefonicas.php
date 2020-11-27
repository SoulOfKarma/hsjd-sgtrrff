<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VacacionesCTelefonicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacaciones_c_telefonicas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_calendario_ctelefonicas');
            $table->date('fecha_inicio_vacaciones');
            $table->date('fecha_termino_vacaciones');
            $table->bigInteger('dias_vacaciones');
            $table->boolean('estado_vacaciones');
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
