<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketEquipamientoApoyoClinicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_equipamiento_apoyo_clinicos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_solicitud');
            $table->bigInteger('id_equipamiento_apoyoclinico');
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
        Schema::dropIfExists('ticket_equipamiento_apoyo_clinicos');
    }
}
