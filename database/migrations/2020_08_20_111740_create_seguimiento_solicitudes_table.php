<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientoSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimiento_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->bigInteger('id_solicitud');
            $table->bigInteger('id_user');
            $table->text('descripcionSeguimiento');
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
        Schema::dropIfExists('seguimiento_solicitudes');
    }
}
