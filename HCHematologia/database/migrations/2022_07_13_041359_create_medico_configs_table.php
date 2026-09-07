<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicoConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medico_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('medico_id');
            $table->foreign('medico_id')->references('id')->on('users');
            $table->unsignedInteger('modulo_id');
            $table->foreign('modulo_id')->references('id')->on('modulos');
            $table->string('valor_string');
            $table->integer('valor_integer');
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
        Schema::dropIfExists('medico_configs');
    }
}
