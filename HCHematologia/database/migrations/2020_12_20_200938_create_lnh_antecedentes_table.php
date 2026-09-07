<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLnhAntecedentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_n_h_antecedentes', function (Blueprint $table) {
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
            $table->integer('opcion_antigripal');
            $table->integer('opcion_antineumococica');
            $table->integer('opcion_ecog');
            $table->string('insuficiencia_cardiaca');
            $table->string('epoc');
            $table->string('insuficiencia_renal');
            $table->string('hepatopatia');
            $table->string('diabetes');
            $table->string('hiv');
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
        Schema::dropIfExists('l_n_h_antecedentes');
    }
}
