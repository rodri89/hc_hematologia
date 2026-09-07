<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LHImagenes extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'fecha_tc', 'tc', 'fecha_pet', 'pet','activo'];
}
