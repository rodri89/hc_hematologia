<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LNHEstadios extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'ann_arbor', 'lugano', 'murphy','activo'];
}
