<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LHSangre extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'hto_hb_vcm', 'leucocitos', 'pqts', 'urea_creatinina', 'ci_creat_ml_min', 'tgo_tgp_fal_bb', 'uricemia', 'vsg', 'ldh', 'b2_microglobulina', 'proteinograma', 'serologia_hbv', 'serologia_hcv', 'serologia_hzv', 'serologia_cmv', 'serologia_hiv_4', 'serologia_vdrl','activo'];
}      