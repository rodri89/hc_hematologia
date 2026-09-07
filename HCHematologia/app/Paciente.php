<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
     protected $fillable = ['nombre', 'apellido', 'dni','telefono','domicilio','localidad','mail','fecha_nacimiento','obra_social','numero_afiliado','obra_social_plan','obra_social_opcional','numero_afiliado_opcional','obra_social_plan_opcional','activo'];
}
