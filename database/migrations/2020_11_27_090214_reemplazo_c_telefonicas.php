<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReemplazoCTelefonicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reemplazo_c_telefonicas', function (Blueprint $table) {
            $table->id();  
            $table->bigInteger('id_calendario_ctelefonicas');
            $table->bigInteger('id_trabajador_reemplazo');
            $table->date('fecha_inicio_reemplazo');
            $table->date('fecha_termino_reemplazo');
            $table->bigInteger('dias_reemplazo');
            $table->boolean('estado_reemplazo');
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
