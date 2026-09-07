<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GMAntecedentesPersonales extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'serologia_hbv', 'serologia_hcv', 'serologia_hzv', 'serologia_cmv', 'serologia_hiv_4','serologia_vdrl','antigripal','antineumococica','opcion_ecog','ant_enfermedad_insuficiencia_cardiaca','ant_enfermedad_epoc','ant_enfermedad_insuficiencia_renal','ant_enfermedad_hepatopatia','ant_enfermedad_diabetes','ant_enfermedad_hiv','ant_enfermedad_otro','score_charlson_puntaje','indice_katz_banio','indice_katz_vestimenta', 'indice_katz_movilidad', 'indice_katz_continencia', 'indice_katz_alimentacion', 'activo'];
}
