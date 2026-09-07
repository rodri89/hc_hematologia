<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicoConfig extends Model
{
    protected $fillable = ['medico_id','modulo', 'valor_string', 'valor_integer','activo'];
}
