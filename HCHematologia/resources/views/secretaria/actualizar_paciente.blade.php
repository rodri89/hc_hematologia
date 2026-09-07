
@extends('plantillas/plantilla_secretaria')

@section('title_header','Actualizar Paciente')

@section('contenedor')

@include('modal.modal_buscar_paciente_secretaria')

@include('medico_secretaria.actualizar_paciente_compartido')

@endsection