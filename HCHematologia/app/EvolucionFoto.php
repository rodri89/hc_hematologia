<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvolucionFoto extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'evolucion_id','foto','activo'];
}
