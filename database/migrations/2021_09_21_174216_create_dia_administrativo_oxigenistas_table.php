<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiaAdministrativoOxigenistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dia_administrativo_oxigenistas', function (Blueprint $table) {
            $table->id();  
            $table->bigInteger('id_calendario_oxigenistas');
            $table->bigInteger('id_tipo_dia_administrativo');
            $table->date('fecha_dia_administrativo');
            $table->boolean('estado_dia_administrativo');
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
        Schema::dropIfExists('dia_administrativo_oxigenistas');
    }
}
