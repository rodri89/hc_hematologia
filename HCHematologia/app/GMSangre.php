<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GMSangre extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'hto_hb_vcm', 'leucocitos', 'plaquetas', 'urea_creatinina', 'ci_creat_ml_min', 'calcemia', 'vsg', 'ldh', 'b2_microglobulina', 'proteinograma_prot_totales', 'proteinograma_albumina', 'proteinograma_alfa', 'proteinograma_beta', 'proteinograma_gamma', 'proteinograma_obs', 'opcion_issr', 'dosaje_igg', 'dosaje_iga', 'dosaje_igm', 'dosaje_igd', 'dosaje_ige', 'inmunofijacion', 'k_libre_l_libre', 'componente_m', 'b_cross_laps', 'activo'];
}
