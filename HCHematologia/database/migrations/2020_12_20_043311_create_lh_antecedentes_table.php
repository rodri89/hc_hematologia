<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLhAntecedentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_h_antecedentes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');            
            $table->integer('opcion_antigripal');
            $table->integer('opcion_antineumococica');
            $table->integer('opcion_ecog');
            $table->integer('insuficiencia_cardiaca');
            $table->integer('epoc');
            $table->integer('insuficiencia_renal');
            $table->integer('hep');
            $table->integer('diabetes');
            $table->integer('hiv');
            $table->string('score_charlson');
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
        Schema::dropIfExists('l_h_antecedentes');
    }
}
