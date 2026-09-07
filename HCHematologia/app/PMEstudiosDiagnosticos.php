<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PMEstudiosDiagnosticos extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'fecha1', 'fecha2', 'hto_hb', 'hiv', 'biopsia_mo', 'vcm', 'vdrl', 'gb_pmn', 'hbv', 'citogenetico', 'plaquetas', 'hcv', 'albumina', 'otro', 'categoria_who_2016', 'ldh', 'gyf', 'puntaje_ipss_r', 'ers', 'pcd', 'mortalidad', 'ferremia', 'pci', 'progresion_leucemia', 'ferritina', 'score_charlson', 'transferrina', 'sat_transf', 'comorbilidades', 'dosaje_epo', 'activo'];
}
