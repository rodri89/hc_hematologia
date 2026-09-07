<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    protected $fillable = ['medico_user_id', 'fecha_expiracion', 'fecha_aviso', 'importe', 'activo'];
}
   