<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLhSangresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_h_sangres', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');            
            $table->string('hto_hb_vcm');
            $table->string('leucocitos');
            $table->string('pqts');
            $table->string('urea_creatinina');
            $table->string('ci_creat_ml_min');
            $table->string('tgo_tgp_fal_bb');
            $table->string('uricemia');
            $table->string('vsg');
            $table->string('ldh');
            $table->string('b2_microglobulina');
            $table->string('proteinograma');
            $table->string('serologia_hbv');
            $table->string('serologia_hcv');
            $table->string('serologia_hzv');
            $table->string('serologia_cmv');
            $table->string('serologia_hiv_4');
            $table->string('serologia_vdrl');
            
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
        Schema::dropIfExists('l_h_sangres');
    }
}
