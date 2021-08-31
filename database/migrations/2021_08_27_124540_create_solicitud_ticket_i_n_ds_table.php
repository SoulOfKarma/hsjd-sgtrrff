<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudTicketINDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_ticket_i_n_ds', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->bigInteger('id_user');
            $table->bigInteger('id_estado');
            $table->bigInteger('id_edificio');
            $table->bigInteger('id_servicio');
            $table->bigInteger('id_ubicacionEx')->nullable();
            $table->bigInteger('id_tipoReparacion');
            $table->bigInteger('id_categoria');
            $table->string('tituloP');
            $table->text('descripcionP');
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
        Schema::dropIfExists('solicitud_ticket_i_n_ds');
    }
}
