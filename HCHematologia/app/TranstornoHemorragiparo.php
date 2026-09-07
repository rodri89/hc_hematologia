<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TranstornoHemorragiparo extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'fecha' , 'plaquetas', 'tp', 'rin', 'aptt', 'factor_v', 'fibrinogeno', 'tt', 'ts', 'retraccion_del_coagulo', 'factor_de_vw','cofactor_de_ristocetina','tp_correccion', 'aptt_correccion', 'factor_ii', 'factor_vii', 'factor_viii', 'factor_ix', 'factor_x', 'inh_viii', 'inh_ix','activo'];
}
