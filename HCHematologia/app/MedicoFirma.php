<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicoFirma extends Model
{
    protected $fillable = ['medico_user_id', 'firma', 'activo'];
}
