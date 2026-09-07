<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GMOrina extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'proteinuria', 'proteinograma', 'if_orina', 'comp_m_bence_jones', 'activo'];
}
   