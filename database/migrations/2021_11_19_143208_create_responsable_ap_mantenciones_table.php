<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsableApMantencionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsable_ap_mantenciones', function (Blueprint $table) {
            $table->id();
            $table->string('id_mantencion_ap');
            $table->bigInteger('codMan');
            $table->bigInteger('id_trabajador');
            $table->bigInteger('codManMes');
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
        Schema::dropIfExists('responsable_ap_mantenciones');
    }
}
