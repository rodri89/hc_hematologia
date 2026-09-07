<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antecedente extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'antecedentes_personales', 'antecedentes_familiares','activo'];
}
