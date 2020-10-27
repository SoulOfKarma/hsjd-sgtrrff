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
            $table->text('sup_run');
            $table->text('sup_nombre');
            $table->text('sup_apellido');
            $table->bigInteger('id_especialidad1')->unsigned();
            $table->foreign('id_especialidad1')->references('id')->on('especialidad');
            $table->bigInteger('id_especialidad2')->unsigned();
            $table->foreign('id_especialidad2')->references('id')->on('especialidad');
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
