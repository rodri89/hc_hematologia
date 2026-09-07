<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanillaControlMM extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'fecha', 'hto_hb', 'vcm', 'gb_pmn', 'plaquetas', 'ldh', 'ferremia', 'ferritina', 'transferrina', 'sat_transf', 'n_ugr', 'p_coombs_d', 'n_unidades_pqt', 'dosaje_epo', 'epo_ui_sem','ahm_dosis_diaria', 'g_csf_dosis_semanal', 'agonistas_trombopoy','activo'];
}
