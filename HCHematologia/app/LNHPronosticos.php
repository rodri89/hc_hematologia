<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LNHPronosticos extends Model
{
    protected $fillable = ['consulta_id', 'paciente_id', 'ecog', 'ldh', 'testiculo', 'extra_nodal_renal', 'snc', 'edad_60', 'doble_hit', 'sintomas_b', 'm_osea', 'bulky', 'hiv', 'opcion_ripi', 'opcion_flipi', 'opcion_mipi_edad', 'opcion_mipi_ecog', 'opcion_mipi_ldh', 'opcion_mipi_leucocitos','activo'];
}
