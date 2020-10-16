<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('run');
            $table->string('email')->unique();
            $table->string('nombre');
            $table->string('apellido');
            $table->bigInteger('anexo');
            $table->bigInteger('id_cargo')->nullable();
            $table->bigInteger('id_cargo_asociado')->nullable();
            $table->bigInteger('id_edificio');
            $table->bigInteger('id_servicio');
            $table->bigInteger('id_unidadEspecifica');
            $table->string('password');
            $table->string('api_token', 80)->unique()
                        ->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
