<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PMPuntaje extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'opcion_fila','activo'];
}
