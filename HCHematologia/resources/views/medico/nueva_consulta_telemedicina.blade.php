
@extends('plantillas/plantilla_medico')

@section('contenedor')

@include('modal.snackbar')

@include('utils.manipular_imagenes')

<head>        
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Datepicker Files -->
    <link rel="stylesheet" href="{{asset('datePicker/css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('datePicker/css/bootstrap-datepicker.standalone.css')}}">
    <script src="{{asset('datePicker/js/bootstrap-datepicker.js')}}"></script>
    <!-- Languaje -->
    <script src="{{asset('datePicker/locales/bootstrap-datepicker.es.min.js')}}"></script>
    
</head>


@if($consulta!=null)
  <input hidden class="form-control" type="text" name="consulta_id" id="consulta_id" value="{{$consulta->id}}" />   
@else
  <input hidden class="form-control" type="text" name="consulta_id" id="consulta_id" value="-1" />   
@endif

@if($paciente!=null)
  <input hidden class="form-control" type="text" name="paciente_id" id="paciente_id" value="{{$paciente->id}}" />   
@else
  <input hidden class="form-control" type="text" name="paciente_id" id="paciente_id" value="-1" />   
@endif
<input hidden class="form-control" type="text" name="es_nueva_consulta" id="es_nueva_consulta" value="{{$nueva_consulta}}" />   

<input hidden class="form-control" type="text" name="tipo_consulta" id="tipo_consulta" value="{{$consulta->tipo_consulta}}" />   

<br>

<div id="seccion_datos_paciente">  
  <ul class="nav nav-tabs letrasblancas">
  <li class="nav-item">
    <a id="datos_a" onclick="getDatos()" type="button" class="nav-link nav_seleccionado">Datos</a>
  </li>  
  <li class="nav-item">
    <a id="antecedentes_personales_a" onclick="getAntecedentesPersonales()" type="button" class="nav-link nav_no_seleccionado">Antec. Personales</a>
  </li>
  <li class="nav-item">
    <a id="antecedentes_familiares_a" onclick="getAntecedentesFamiliares()" type="button" class="nav-link nav_no_seleccionado">Antec. Familiares</a>
  </li>
</ul>
<div id="seccion_info_paciente">
  @include('medico.seccion.info_paciente')
</div>

<div id="seccion_antecedentes_personales" hidden>
  @include('medico.seccion.antecedentes_personales')
</div>

<div id="seccion_antecedentes_familiares" hidden>
  @include('medico.seccion.antecedentes_familiares')
</div>

<br>
<div class="row contenedor3">
    <button id="guardarDatosButtonId" onclick="guardarDatos()" class="rodri_button contenido3">GUARDAR</button>
</div>
<br>
</div>

<br>
@include('medico.seccion.datos_subjetivos')
<br>
@include('medico.seccion.evolucion')
<br>
@include('medico.seccion.conductas')
<br>


<div class="row contenedor3">
  <div class="contenido3">
    <button id="guardarDatosDosButtonId" onclick="guardarConsulta()" class="rodri_button">GUARDAR</button>        
  </div>
</div>
<br>

<script type="text/javascript">  

  function getDatos(){
    ocultarPaneles();    
    document.getElementById("seccion_info_paciente").hidden = false;  
    var a = document.getElementById("datos_a");
    a.setAttribute('class', 'nav-link nav_seleccionado');
    document.getElementById("guardarDatosButtonId").hidden = false;
  }

    function getAntecedentesPersonales(){
    ocultarPaneles();    
    document.getElementById("seccion_antecedentes_personales").hidden = false;
    var a = document.getElementById("antecedentes_personales_a");
    a.setAttribute('class', 'nav-link nav_seleccionado');     
    document.getElementById("guardarDatosButtonId").hidden = false;
  }

  function getAntecedentesFamiliares(){
    ocultarPaneles();    
    document.getElementById("seccion_antecedentes_familiares").hidden = false;
    var a = document.getElementById("antecedentes_familiares_a");
    a.setAttribute('class', 'nav-link nav_seleccionado');    
    document.getElementById("guardarDatosButtonId").hidden = false;
  }

   function ocultarPaneles(){
    document.getElementById("seccion_info_paciente").hidden = true;
    var datos_a = document.getElementById("datos_a");
    datos_a.setAttribute('class', 'nav-link nav_no_seleccionado');

    document.getElementById("seccion_antecedentes_personales").hidden = true;
    var antecedentes_personales_a = document.getElementById("antecedentes_personales_a");
    antecedentes_personales_a.setAttribute('class', 'nav-link nav_no_seleccionado');    

    document.getElementById("seccion_antecedentes_familiares").hidden = true;
    var antecedentes_familiares_a = document.getElementById("antecedentes_familiares_a");
    antecedentes_familiares_a.setAttribute('class', 'nav-link nav_no_seleccionado');    

    document.getElementById("guardarDatosButtonId").hidden = true;
  }

  function guardarDatos(){
    guardarAntecedentesPersonales();
    guardarAntecedentesFamiliares();
    mostrarSnackbar("DATOS GUARDADOS");       
  }

  function guardarConsulta(){
    guardarConductas();
    guardarEvolucion();
    guardarDatosSubjetivos();

    establecerActivo(); 
    mostrarSnackbar("DATOS GUARDADOS");       
  }
  

  function establecerActivo(){    
    var consulta_id = document.getElementById("consulta_id").value;
    var paciente_id = document.getElementById("paciente_id").value;  
    //var edad_mostrar = document.getElementById("edad").value;        
    var edad_mostrar = "1 año";

    mostrarSnackbar("GUARDADANDO...");       
        
    $.ajax({
             type:'POST',
             dataType:'JSON',
             url:'/establecer_activo',
             data:{paciente_id:paciente_id, consulta_id:consulta_id, edad:edad_mostrar,_token: '{{csrf_token()}}'},
             success:function(data) { 
                mostrarSnackbar("CONSULTA GUARDADA");                   
                window.location.href = "/medico_home"; 
              }
          });     
  }  

  function cargarTitleHeader(){
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    document.getElementById("static_header").hidden = true;
    document.getElementById("static_header_2").innerHTML = "Nueva Consulta Telemedicina";
    document.getElementById("static_header_nombre").innerHTML = apellido+", "+nombre;    
  }


  window.onload=function() {
    mostrarPanelPaciente(true);
    mostrarPanelHistoriaClinica(false);
    cargarTitleHeader();    
    calcularEdad();           
    cargarAntecedentesPersonales();
    cargarAntecedentesFamiliares();     
  }

</script>

@endsection