<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = ['medico_user_id', 'paciente_id', 'medico_id', 'tipo_consulta', 'es_foto', 'edad_mostrar', 'linfoma_hodgkin', 'linfoma_no_hodgkin', 'gammapatia_monoclonal', 'planilla_mielodisplasia', 'activo'];

    public function diagnosticos()
    {
        return $this->belongsToMany(Diagnostico::class, 'consulta_diagnostico');
    }
}
