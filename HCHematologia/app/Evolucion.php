<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evolucion extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'audio','descripcion','activo'];
}
