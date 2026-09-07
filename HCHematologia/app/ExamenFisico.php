<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenFisico extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'linfoma_hodgkin', 'linfoma_no_hodgkin', 'gammapatia_monoclonal', 'foto','activo'];
}
