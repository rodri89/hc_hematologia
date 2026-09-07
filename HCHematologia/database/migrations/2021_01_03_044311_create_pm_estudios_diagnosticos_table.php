<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmEstudiosDiagnosticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_m_estudios_diagnosticos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');            
            $table->date('fecha1');            
            $table->date('fecha2');            
            $table->string('hto_hb');            
            $table->string('hiv');
            $table->string('biopsia_mo');
            $table->string('vcm');
            $table->string('vdrl');
            $table->string('gb_pmn');
            $table->string('hbv');
            $table->string('citogenetico');
            $table->string('plaquetas');
            $table->string('hcv');
            $table->string('albumina');
            $table->string('otro');
            $table->string('categoria_who_2016');
            $table->string('ldh');
            $table->string('gyf');
            $table->string('puntaje_ipss_r');
            $table->string('ers');
            $table->string('pcd');
            $table->string('mortalidad');
            $table->string('ferremia');
            $table->string('pci');
            $table->string('progresion_leucemia');
            $table->string('ferritina');
            $table->string('score_charlson');
            $table->string('transferrina');
            $table->string('sat_transf');
            $table->string('comorbilidades');
            $table->string('dosaje_epo');
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
        Schema::dropIfExists('p_m_estudios_diagnosticos');
    }
}
