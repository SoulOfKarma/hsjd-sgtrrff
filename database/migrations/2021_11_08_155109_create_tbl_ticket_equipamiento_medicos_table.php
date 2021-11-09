<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTicketEquipamientoMedicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ticket_equipamiento_medicos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_solicitud');
            $table->bigInteger('id_equipamiento_medico');
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
        Schema::dropIfExists('tbl_ticket_equipamiento_medicos');
    }
}
