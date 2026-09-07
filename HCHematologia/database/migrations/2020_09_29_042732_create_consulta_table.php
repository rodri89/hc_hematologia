<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->integer('medico_id');
            $table->integer('tipo_consulta');            
            $table->integer('es_foto');
            $table->string('edad_mostrar'); //esto lo utilizo para guardame la edad que tenia en esa consulta
            $table->integer('linfoma_hodgkin');
            $table->integer('linfoma_no_hodgkin');
            $table->integer('gammapatia_monoclonal');
            $table->integer('planilla_mielodisplasia');
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
        Schema::dropIfExists('consultas');
    }
}
