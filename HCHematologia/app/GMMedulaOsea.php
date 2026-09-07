<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GMMedulaOsea extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'cmf_plasmocitos', 'cmf_aberrantes', 'citogenetico_bandeo_g', 'citogenetico_fish_17p','citogenetico_fish_1q','citogenetico_fish_14q_32','biopsia_plasmocitos', 'activo'];
}
