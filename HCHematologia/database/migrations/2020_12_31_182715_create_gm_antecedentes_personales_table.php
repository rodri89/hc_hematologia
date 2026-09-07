<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGmAntecedentesPersonalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_m_antecedentes_personales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');            
            $table->string('serologia_hbv');
            $table->string('serologia_hcv');
            $table->string('serologia_hzv');
            $table->string('serologia_cmv');
            $table->string('serologia_hiv_4');
            $table->string('serologia_vdrl');
            $table->integer('antigripal');
            $table->integer('antineumococica');
            $table->integer('opcion_ecog');
            $table->string('ant_enfermedad_insuficiencia_cardiaca');
            $table->string('ant_enfermedad_epoc');
            $table->string('ant_enfermedad_insuficiencia_renal');
            $table->string('ant_enfermedad_hepatopatia');
            $table->string('ant_enfermedad_diabetes');
            $table->string('ant_enfermedad_hiv');
            $table->string('ant_enfermedad_otro');
            $table->string('score_charlson_puntaje');
            $table->integer('indice_katz_banio');
            $table->integer('indice_katz_vestimenta');
            $table->integer('indice_katz_movilidad');
            $table->integer('indice_katz_continencia');
            $table->integer('indice_katz_alimentacion');
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
        Schema::dropIfExists('g_m_antecedentes_personales');
    }
}
