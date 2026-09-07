<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLnhPronosticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_n_h_pronosticos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');                        
            $table->string('ecog');
            $table->string('ldh');
            $table->string('testiculo');
            $table->string('extra_nodal_renal');
            $table->string('snc');
            $table->string('edad_60');
            $table->string('doble_hit');
            $table->string('sintomas_b');
            $table->string('m_osea');
            $table->string('bulky');
            $table->string('hiv');
            $table->integer('opcion_ripi');
            $table->integer('checkbox_ripi_riesgo_bajo');
            $table->integer('checkbox_ripi_riesgo_intermedio_bajo');
            $table->integer('checkbox_ripi_riesgo_intermedio_alto');
            $table->integer('checkbox_ripi_riesgo_alto');
            $table->integer('opcion_flipi');
            $table->integer('checkbox_flipi_bajo');
            $table->integer('checkbox_flipi_intermedio_bajo');
            $table->integer('checkbox_flipi_alto');
            $table->integer('opcion_mipi_edad');
            $table->integer('opcion_mipi_ecog');
            $table->integer('opcion_mipi_ldh');
            $table->integer('opcion_mipi_leucocitos');
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
        Schema::dropIfExists('l_n_h_pronosticos');
    }
}
