<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trombofilia extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'fecha', 'tp', 'rin', 'aptt', 'tt', 'ts', 'f_viii', 'pc', 'ps', 'rpca', 'ac_anti_b2_gp_igg', 'ac_anti_b2_gp_igm', 'ac_anti_cardiolipina_igg', 'ac_anti_cardiolipina_igm', 'anticoagulante_lupico', 'mutacion_fv_leiden', 'mutacion_pt_20210', 'homocisteinemia', 'antitrombina_iii' ,'activo'];
}
