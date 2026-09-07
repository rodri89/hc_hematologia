<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboratorioGeneral extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'fecha', 'hb_g_dl' , 'hto' , 'vcm_fl' , 'rto_gr' , 'hcm' , 'chcm' , 'fsp' , 'gb' , 'pqt' , 'ldh' , 'ers' , 'b2_microglob' , 'urea' , 'creatinina' , 'tgo' , 'tgp' , 'fal' , 'bb_total' , 'ferremia' , 'transferrina' , 'sat_transferrina' , 'tibc' , 'ferritina' , 'vit_b12' , 'folato' , 'prot_totales' , 'albumina'  , 'alfa' , 'beta' , 'gamma' , 'interpretacion' , 'inmunofijacion' , 'cll' , 'kappa' , 'lambda' , 'calcio' , 'fosforo' , 'proteinuria' , 'tp' , 'rin' , 'aptt','glucemia', 'pico_monotomas', 'lg_g','lg_a','lg_m','lg_e','lg_d' ,'activo'];
}
