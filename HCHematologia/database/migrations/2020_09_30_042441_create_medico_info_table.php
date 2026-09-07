<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicoInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medico_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('medico_user_id');
            $table->foreign('medico_user_id')->references('id')->on('users');
            $table->integer('consulta_id');
            $table->integer('es_nueva_consulta');
            $table->integer('paciente_id');
            $table->integer('activo');
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
        Schema::dropIfExists('medico_infos');
    }
}
