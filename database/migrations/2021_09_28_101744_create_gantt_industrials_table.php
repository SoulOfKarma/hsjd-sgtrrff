<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGanttIndustrialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gantt_industrials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resourceId');
            $table->date('start');
            $table->date('end');
            $table->string('title');
            $table->string('eventcolor')->nullable();
            $table->bigInteger('resourceAsociado')->nullable();
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
        Schema::dropIfExists('gantt_industrials');
    }
}