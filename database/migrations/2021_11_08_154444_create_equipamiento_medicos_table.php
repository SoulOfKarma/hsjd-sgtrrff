<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipamientoMedicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamiento_medicos', function (Blueprint $table) {
            $table->id();
            $table->string('equipo')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('serie')->nullable();
            $table->string('ninventario')->nullable();
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
        Schema::dropIfExists('equipamiento_medicos');
    }
}
