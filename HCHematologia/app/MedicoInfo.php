<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicoInfo extends Model
{
    protected $fillable = ['medico_user_id', 'consulta_id', 'es_nueva_consulta', 'paciente_id', 'es_foto', 'edad_mostrar', 'activo'];
}        