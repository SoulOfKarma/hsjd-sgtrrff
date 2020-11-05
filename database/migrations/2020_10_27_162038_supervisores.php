<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Supervisores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisores', function (Blueprint $table) {
            $table->id();
            $table->string('sup_run')->unique();
            $table->string('sup_nombre');
            $table->string('sup_apellido');
            $table->bigInteger('id_especialidad1')->unsigned();
            $table->foreign('id_especialidad1')->references('id')->on('especialidades');
            $table->bigInteger('id_especialidad2')->unsigned();
            $table->foreign('id_especialidad2')->references('id')->on('especialidades');
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
