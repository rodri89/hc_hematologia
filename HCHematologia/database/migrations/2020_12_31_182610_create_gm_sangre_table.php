<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGmSangreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_m_sangres', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');            
            $table->string('hto_hb_vcm');            
            $table->string('leucocitos');            
            $table->string('plaquetas');            
            $table->string('urea_creatinina');            
            $table->string('ci_creat_ml_min');            
            $table->string('calcemia');            
            $table->string('vsg');
            $table->string('ldh');
            $table->string('b2_microglobulina');            
            $table->string('proteinograma_prot_totales');
            $table->string('proteinograma_albumina');
            $table->string('proteinograma_alfa');
            $table->string('proteinograma_beta');
            $table->string('proteinograma_gamma');
            $table->string('proteinograma_obs');
            $table->integer('opcion_issr');
            $table->string('dosaje_igg');
            $table->string('dosaje_iga');
            $table->string('dosaje_igm');
            $table->string('dosaje_igd');
            $table->string('dosaje_ige');
            $table->string('inmunofijacion');
            $table->string('k_libre_l_libre');
            $table->string('componente_m');
            $table->string('b_cross_laps');
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
        Schema::dropIfExists('g_m_sangres');
    }
}
