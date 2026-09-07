
@extends('plantillas/plantilla_medico')

@section('title_header','Seleccionar Tipo Consulta')

@section('contenedor')

<div class="row contenedor3 margin_top_150px">
  <div class="row contenido3 ">    
    <form method="post" action="{{ route('crearnuevaconsulta') }}">                   
        @csrf          
        <input hidden text id="tipo_consulta" name="tipo_consulta" value="1"/>   
        <input hidden text id="consulta_foto" name="consulta_foto" value="0"/>   
        <button  class="btn btn-primary-outline img-responsive img_opcion">
          <img type="submit" class="card-img-top " src="/img/iconos/icono_consulta.png" alt="">
        </button>
        <div class="card-body">
          <h6 class="fontImage" align="center">Control</h6>      
        </div>        
    </form>

    <form method="post" action="{{ route('crearnuevaconsulta') }}">                   
        @csrf          
        <input hidden text id="tipo_consulta" name="tipo_consulta" value="3"/>   
        <input hidden text id="consulta_foto" name="consulta_foto" value="0"/>           
        <button type="submit" class="btn btn-primary-outline img-responsive img_opcion">
          <img class="card-img-top " src="/img/iconos/telemedicina.png" alt="">
        </button>
        <div class="card-body">
          <h6 class="fontImage" align="center">Telemedicina</h6>      
        </div>        
    </form>
</div>
</div>

<script type="text/javascript">
   window.onload=function() {
    mostrarPanelPaciente(true);
      mostrarPanelHistoriaClinica(false);
   }
</script>

@endsection