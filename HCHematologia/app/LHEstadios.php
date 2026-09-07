<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LHEstadios extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'ann_arbor', 'opcion_favorable_desfavorable', 'texto_favorable_desfavorable', 'opcion_bajo_inter_alto', 'texto_bajo_inter_alto','activo'];
}
     