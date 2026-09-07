<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LHAntecedentes extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'opcion_antigripal', 'opcion_antineumococica', 'opcion_ecog', 'insuficiencia_cardiaca', 'epoc', 'insuficiencia_renal', 'hep', 'diabetes', 'hiv', 'score_charlson','activo'];
}
     