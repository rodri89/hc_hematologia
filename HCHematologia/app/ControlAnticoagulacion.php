<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlAnticoagulacion extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'fecha', 'tp', 'rin', 'aptt','activo'];
}
