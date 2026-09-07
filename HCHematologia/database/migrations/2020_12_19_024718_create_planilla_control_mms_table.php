<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanillaControlMmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planilla_control_m_m_s', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->date('fecha');
            $table->string('hto_hb');
            $table->string('vcm');
            $table->string('gb_pmn');
            $table->string('plaquetas');
            $table->string('ldh');
            $table->string('ferremia');
            $table->string('ferritina');
            $table->string('transferrina');
            $table->string('sat_transf');
            $table->string('n_ugr');
            $table->string('p_coombs_d');
            $table->string('n_unidades_pqt');
            $table->string('dosaje_epo');
            $table->string('epo_ui_sem');
            $table->string('ahm_dosis_diaria');
            $table->string('g_csf_dosis_semanal');
            $table->string('agonistas_trombopoy');
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
        Schema::dropIfExists('planilla_control_m_m_s');
    }
}
