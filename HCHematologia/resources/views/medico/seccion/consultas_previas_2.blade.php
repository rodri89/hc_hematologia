
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

</div>

<div class="row contenedor3">
  <div class="row contenido3 ">    
    <div >                                           
        <button onclick="mostrarEstudio(1)" class="btn btn-primary-outline img-responsive img_opcion_2">
          <img type="button" class="card-img-top " src="/img/iconos/linfoma_hodgkin_icono.png" alt="">
        </button>
        <div class="card-body">
          <h6 class="fontImage" align="center">Linfoma Hodgkin</h6>      
        </div>        
    </div>

    <div>                                            
        <button onclick="mostrarEstudio(2)" type="button" class="btn btn-primary-outline img-responsive img_opcion_2">
          <img class="card-img-top " src="/img/iconos/linfoma_no_hodgkin_icono.png" alt="">
        </button>
        <div class="card-body">
          <h6 class="fontImage" align="center">Linfoma No Hodgkin</h6>      
        </div>        
    </div>

    <div >                                           
        <button onclick="mostrarEstudio(3)" type="button" class="btn btn-primary-outline img-responsive img_opcion_2">
          <img class="card-img-top " src="/img/iconos/gammapatia_monoclonal_icono.png" alt="">
        </button>
        <div class="card-body">
          <h6 class="fontImage" align="center">Gammapatia Monoclonal</h6>      
        </div>        
    </div>

    <div>                                                     
        <button onclick="mostrarEstudio(4)" type="button" class="btn btn-primary-outline img-responsive img_opcion_2">
          <img class="card-img-top " src="/img/iconos/planilla_mielodisplasia_icono.png" alt="">
        </button>
        <div class="card-body">
          <h6 class="fontImage" align="center">Planilla Mielodisplasia</h6>      
        </div>        
    </div>
</div>
</div>

<br>
<div hidden id="seccion_linfoma_hodgkin_nc">
  @include('medico.seccion.linfoma_hodgkin')
  <br>
</div>
<div hidden id="seccion_linfoma_no_hodgkin_nc">
  @include('medico.seccion.linfoma_no_hodgkin')
  <br>
</div>
<div hidden id="seccion_gammapatia_monoclonal_nc">
  @include('medico.seccion.gammapatia_monoclonal')
  <br>
</div>
<div hidden id="seccion_planilla_mielodisplasia_nc">
  @include('medico.seccion.planilla_mielodisplasia')
  <br>
</div>
<div hidden>
  @include('medico.seccion.planilla_control_mensual_mielodisplasia')
  <br>
</div>
@include('medico.seccion.motivo_consulta')
<br>
@include('medico.seccion.examen_fisico')
<br>
@include('medico.seccion.laboratorio_general')
<br>
@include('medico.seccion.control_anticoagulacion')
<br>
@include('medico.seccion.trombofilia')
<br>
@include('medico.seccion.trastorno_hemorragiparo')
<br>
@include('medico.seccion.impresion_diagnostica')
<br>
@include('medico.seccion.plan')
<br>
@include('medico.seccion.evolucion')
<br>
<div hidden>
  @include('medico.seccion.conductas')
  <br>
</div>



<div class="row contenedor3">
  <div class="contenido3">
    <button id="guardarDatosDosButtonId" onclick="guardarConsulta()" class="rodri_button">GUARDAR</button>        
  </div>
</div>
<br>

<script type="text/javascript">  

  function mostrarEstudio(opcion){
    if(opcion == 1){
      var seccion_lh = document.getElementById("seccion_linfoma_hodgkin_nc");
      var aux = seccion_lh.hidden;
      seccion_lh.hidden = !aux;      
      document.getElementById("seccion_linfoma_hodgkin").hidden = !aux;      

      if(aux){
        $('html, body').animate({
          scrollTop: $("#seccion_linfoma_hodgkin_nc").offset().top
          }, 2000);
      }
    }

    if(opcion == 2){
      var seccion_lnh = document.getElementById("seccion_linfoma_no_hodgkin_nc");
      var aux = seccion_lnh.hidden;
      seccion_lnh.hidden = !aux;      
      document.getElementById("seccion_linfoma_no_hodgkin").hidden = !aux;

      if(aux){
        $('html, body').animate({
          scrollTop: $("#seccion_linfoma_no_hodgkin_nc").offset().top
          }, 2000);
      }
    }

    if(opcion == 3){
      var seccion_gm = document.getElementById("seccion_gammapatia_monoclonal_nc");
      var aux = seccion_gm.hidden;
      seccion_gm.hidden = !aux;      
      document.getElementById("seccion_gammapatia_monoclonal").hidden = !aux;

      if(aux){
        $('html, body').animate({
          scrollTop: $("#seccion_gammapatia_monoclonal_nc").offset().top
          }, 2000);
      }
    }

    if(opcion == 4){
      var seccion_pm = document.getElementById("seccion_planilla_mielodisplasia_nc");
      var aux = seccion_pm.hidden;
      seccion_pm.hidden = !aux;      
      document.getElementById("seccion_planilla_mielodisplasia").hidden = !aux;

      if(aux){        
        $('html, body').animate({
          scrollTop: $("#seccion_planilla_mielodisplasia_nc").offset().top
          }, 2000);
      }
    }

  }

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
    guardarExamenFisico();
    guardarPlan();
    guardarImpresionDiagnostica();
    guardarMotivoConsulta();
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
    document.getElementById("static_header_2").innerHTML = "Consultas";
    document.getElementById("static_header_nombre").innerHTML = apellido+", "+nombre;    
  }

  /**
    Va a guardar en consulta el tipo de estudio pasado, cuando le doy guardar
    a un tipo de estudio esta informacion se va a guardar en la consulta,
    lo voy a utilizar para luego saber si debo mostrarlo o no al cargar una consulta previa.
   1 - Linfoma de Hodgkin 
   2 - Linfoma No Hodgkin
   3 - Gammapatia Monoclonal
   4 - Planilla Mielodisplasia
  */
  function guardarTipoEstudioConsulta(tipo_estudio){
    var consulta_id = document.getElementById("consulta_id").value;

    $.ajax({
             type:'POST',
             dataType:'JSON',
             url:'/guardar_tipo_estudio_consulta',
             data:{tipo_estudio:tipo_estudio, consulta_id:consulta_id, _token: '{{csrf_token()}}'},
             success:function(data) { 
                  // tipo estudio guardado                
              }
          });
  }

  function cargarEstudiosPrevios(){
    cargarConsultasPreviasLh();
    cargarConsultasPreviasLnh();
    cargarConsultasPreviasGm();
    cargarConsultasPreviasPm();
  }

  window.onload=function() {
    /*mostrarPanelPaciente(true);
    mostrarPanelHistoriaClinica(false);
    cargarTitleHeader();    
    calcularEdad();     
    cargarEstudiosPrevios();
    cargarAntecedentesPersonales();
    cargarAntecedentesFamiliares();
    var es_nueva_consulta = document.getElementById("es_nueva_consulta").value;
    if(es_nueva_consulta == 5){      
      clickLinfomaHodgkin();
      cargarDatosLinfomaHodkin();
      cargarDatosLinfomaNoHodkin();
      cargarDatosGammapatiaMonoclonal();
      habilitarBotonesCuerpo(true);    
    }

    if(es_nueva_consulta == 6){      
      clickLinfomaNoHodgkin();
      cargarDatosLinfomaHodkin();
      cargarDatosLinfomaNoHodkin();
      cargarDatosGammapatiaMonoclonal();
      habilitarBotonesCuerpoLnh(true);    
    }
    if(es_nueva_consulta == 7){      
      clickGammapatiaMonoclonal();
      cargarDatosLinfomaHodkin();
      cargarDatosLinfomaNoHodkin();
      cargarDatosGammapatiaMonoclonal();
      habilitarBotonesCuerpoGm(true);    
    }    */ 
  }

</script>

@endsection