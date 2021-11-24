<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentacionApTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentacion_ap_tables', function (Blueprint $table) {
            $table->id();
            $table->string('idMAP');
            $table->string('descripcionDocumento')->nullable();
            $table->string('nombreDocumento');
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
        Schema::dropIfExists('documentacion_ap_tables');
    }
}
