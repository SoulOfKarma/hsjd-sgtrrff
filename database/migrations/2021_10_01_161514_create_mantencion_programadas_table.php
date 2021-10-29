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
            $table->string('codManEne')->nullable();
            $table->string('codManFeb')->nullable();
            $table->string('codManMar')->nullable();
            $table->string('codManAbr')->nullable();
            $table->string('codManMay')->nullable();
            $table->string('codManJun')->nullable();
            $table->string('codManJul')->nullable();
            $table->string('codManAgo')->nullable();
            $table->string('codManSep')->nullable();
            $table->string('codManOct')->nullable();
            $table->string('codManNov')->nullable();
            $table->string('codManDic')->nullable();
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
