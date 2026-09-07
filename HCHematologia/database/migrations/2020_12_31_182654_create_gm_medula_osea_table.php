<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGmMedulaOseaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_m_medula_oseas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');            
            $table->string('cmf_plasmocitos');            
            $table->string('cmf_aberrantes');            
            $table->string('citogenetico_bandeo_g');                        
            $table->string('citogenetico_fish_17p');                        
            $table->string('citogenetico_fish_1q');                        
            $table->string('citogenetico_fish_14q_32');                        
            $table->string('biopsia_plasmocitos');                        
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
        Schema::dropIfExists('g_m_medula_oseas');
    }
}
