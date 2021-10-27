<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantencionProgramadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantencion_programadas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_edificio');
            $table->string('descripcion_mantencion');
            $table->string('descripcion_proveedor')->nullable();
            $table->bigInteger('codManEne')->nullable();
            $table->bigInteger('codManFeb')->nullable();
            $table->bigInteger('codManMar')->nullable();
            $table->bigInteger('codManAbr')->nullable();
            $table->bigInteger('codManMay')->nullable();
            $table->bigInteger('codManJun')->nullable();
            $table->bigInteger('codManJul')->nullable();
            $table->bigInteger('codManAgo')->nullable();
            $table->bigInteger('codManSep')->nullable();
            $table->bigInteger('codManOct')->nullable();
            $table->bigInteger('codManNov')->nullable();
            $table->bigInteger('codManDic')->nullable();
            $table->string('desFrecuencia')->nullable();
            $table->bigInteger('id_anio');
            $table->bigInteger('id_tmantencion');
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
        Schema::dropIfExists('mantencion_programadas');
    }
}
