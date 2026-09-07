<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GMDiagnostico extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'descripcion', 'activo'];
}
 