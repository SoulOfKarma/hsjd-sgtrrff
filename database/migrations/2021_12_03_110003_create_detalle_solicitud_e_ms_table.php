<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleSolicitudEMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_solicitud_e_ms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_solicitud')->nullable();
            $table->string('desresolucionresultados')->nullable();
            $table->string('desobservaciones')->nullable();
            $table->bigInteger('id_danoEQ')->nullable();
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
        Schema::dropIfExists('detalle_solicitud_e_ms');
    }
}
