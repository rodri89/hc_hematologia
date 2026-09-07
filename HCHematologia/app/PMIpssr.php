<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PMIpssr extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'fila_1_opcion', 'fila_2_opcion', 'fila_3_opcion', 'fila_4_opcion','fila_5_opcion','activo'];
}
        