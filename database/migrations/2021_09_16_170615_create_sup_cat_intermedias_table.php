<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupCatIntermediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_cat_intermedias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_supervisor');
            $table->bigInteger('id_categoria');
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
        Schema::dropIfExists('sup_cat_intermedias');
    }
}
