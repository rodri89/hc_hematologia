<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $fillable = ['nombre', 'activo'];

    public function consultas()
    {
        return $this->belongsToMany(Consulta::class, 'consulta_diagnostico');
    }
}
