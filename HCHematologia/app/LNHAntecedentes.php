<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LNHAntecedentes extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'serologia_hbv', 'serologia_hcv', 'serologia_hzv', 'serologia_cmv', 'serologia_hiv_4', 'serologia_vdrl', 'antigripal', 'antineumococica', 'opcion_ecog', 'insuficiencia_cardiaca', 'epoc','insuficiencia_renal', 'hepatopatia', 'diabetes', 'hiv', 'score_charlson','activo'];
}            