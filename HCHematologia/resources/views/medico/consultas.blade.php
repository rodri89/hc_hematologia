
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

<input hidden class="form-control" type="text" name="modulo_1" id="modulo_1" value="{{$modulo_1}}" />   

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
      <div id="seccion_boton_linfoma_hodgkin">                                           
          <button onclick="mostrarEstudio(1)" class="btn btn-primary-outline img-responsive img_opcion_2">
            <img type="button" class="card-img-top " src="/img/iconos/linfoma_hodgkin_icono.png" alt="">
          </button>
          <div class="card-body">
            <h6 class="fontImage" align="center">Linfoma Hodgkin</h6>      
          </div>        
      </div>
    
      <div id="seccion_boton_linfoma_no_hodgkin">                                           
          <button onclick="mostrarEstudio(2)" type="button" class="btn btn-primary-outline img-responsive img_opcion_2">
            <img class="card-img-top " src="/img/iconos/linfoma_no_hodgkin_icono.png" alt="">
          </button>
          <div class="card-body">
            <h6 class="fontImage" align="center">Linfoma No Hodgkin</h6>      
          </div>        
      </div>
    
      <div id="seccion_boton_gammapatia_monoclonal">                                                           
          <button onclick="mostrarEstudio(3)" type="button" class="btn btn-primary-outline img-responsive img_opcion_2">
            <img class="card-img-top " src="/img/iconos/gammapatia_monoclonal_icono.png" alt="">
          </button>
          <div class="card-body">
            <h6 class="fontImage" align="center">Gammapatia Monoclonal</h6>      
          </div>        
      </div>
    
      <div id="seccion_boton_planilla_mielodisplasia">                                           
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
@include('medico.seccion.diagnostico')

@if($laboratorio_general_tabla_tope >0)
  @include('medico.seccion.laboratorio_general')
<br>
@endif

@if($control_anticoagulacion_tabla_tope >0)
  @include('medico.seccion.control_anticoagulacion')
  <br>
@endif

@if($trombofilia_tabla_tope >0)
  @include('medico.seccion.trombofilia')
  <br>
@endif

@if($trastorno_hemorragiparo_tabla_tope >0)
  @include('medico.seccion.trastorno_hemorragiparo')
  <br>
@endif

@include('medico.seccion.motivo_consulta')
<br>
<!-- @include('medico.seccion.examen_fisico')
<br>
@include('medico.seccion.impresion_diagnostica')
<br>
@include('medico.seccion.plan')
<br>-->
@include('medico.seccion.medicacion_actual')
<br>
@include('medico.seccion.evolucion')
<br>
@include('medico.seccion.resumen')
<br>
<div hidden>
  @include('medico.seccion.conductas')
  <br>
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
    
  }

  function getAntecedentesPersonales(){
    ocultarPaneles();    
    document.getElementById("seccion_antecedentes_personales").hidden = false;
    var a = document.getElementById("antecedentes_personales_a");
    a.setAttribute('class', 'nav-link nav_seleccionado');     
    
  }

  function getAntecedentesFamiliares(){
    ocultarPaneles();    
    document.getElementById("seccion_antecedentes_familiares").hidden = false;
    var a = document.getElementById("antecedentes_familiares_a");
    a.setAttribute('class', 'nav-link nav_seleccionado');    
    
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
  }


    function bajarRenglon(seccion){
      var ptitle_aux = document.createElement("P");
      ptitle_aux.setAttribute('class', 'rodri_bold');                 
      ptitle_aux.innerHTML = "";
      seccion.appendChild(ptitle_aux);
  }

  function addBr(seccion_resumen){
    var br = document.createElement("BR");
    seccion_resumen.appendChild(br);
  }

 $(document).on('input', 'textarea', function () {
        $(this).outerHeight(38).outerHeight(this.scrollHeight); // 38 or '1em' -min-height
    }); 

  function addTextArea(text, seccion_resumen){    
    var textArea = document.createElement("TextArea");    
    var arraytxt = text.split('\n');
    textArea.rows = arraytxt.length;
    textArea.innerHTML = text;    
    textArea.setAttribute('class', 'form-control');   
    textArea.disabled = true;
    // textArea.setAttribute("style", "border:none;background-color:white");                                    
    
    seccion_resumen.appendChild(textArea);
        
    var br = document.createElement("BR");
    seccion_resumen.appendChild(br);        
  }

  function do_resize(textbox) {
     var maxrows=5; 
      var txt=textbox.value;
      var cols=textbox.cols;

     var arraytxt=txt.split('\n');
     var rows=arraytxt.length; 

     for (i=0;i<arraytxt.length;i++){ 
      rows+=parseInt(arraytxt[i].length/cols);
      }

     if (rows>maxrows) textbox.rows=maxrows;
      else textbox.rows=rows;
     }

  function textAreaAdjust(element) {
    element.style.height = "1px";
    element.style.height = (25 + element.scrollHeight )+"px";
  }

  function textAreaStyle(){
    alert("style");
    const tx = document.getElementsByTagName("textarea");
    for (let i = 0; i < tx.length; i++) {
      tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
      tx[i].addEventListener("input", OnInput, false);
    }  
  }

  function OnInput() {
    this.style.height = "auto";
    this.style.height = (this.scrollHeight) + "px";
  }
  
    // text1: text2  + bajada de renlgon
  function addText(text1, text2, seccion_resumen){                    
      var ptitle_a1 = document.createElement("P");
      ptitle_a1.setAttribute('class', 'rodri_bold rodri_inline_margin');                 
      ptitle_a1.innerHTML = text1+": "; 
      seccion_resumen.appendChild(ptitle_a1);                                  
      var p_a1 = document.createElement("P");
      p_a1.innerHTML = text2;
      p_a1.setAttribute('class', 'rodri_resumen_p rodri_inline');                                   
      seccion_resumen.appendChild(p_a1);
      var br = document.createElement("BR");
      seccion_resumen.appendChild(br);
  }

  // text1 
  // text2  
  function addText2(text1, text2, seccion_resumen){                    
      var ptitle_a1 = document.createElement("P");
      var br = document.createElement("BR");
      ptitle_a1.setAttribute('class', 'rodri_bold margin_left_10px');                 
      ptitle_a1.innerHTML = text1+" "; 
      seccion_resumen.appendChild(ptitle_a1);                                                                          
      var p_a1 = document.createElement("P");
      p_a1.innerHTML = text2;
      p_a1.setAttribute('class', 'rodri_resumen_p margin_left_10px');                                   
      seccion_resumen.appendChild(p_a1);      
  }

  function addTitulo(text, seccion_resumen){
    var title = document.createElement("P");
    var br = document.createElement("BR");    
    title.setAttribute('class', 'rodri_bold font_size_resumen');
    title.innerHTML = text;    
    seccion_resumen.appendChild(title);             
  }

  function addTituloDescripcion(text1, text2, seccion_resumen){                    
    var title = document.createElement("P");
    var br = document.createElement("BR");
    var p = document.createElement("P");
    title.setAttribute('class', 'rodri_bold font_size_resumen');
    title.innerHTML = text1;
    p.innerHTML = text2;
    p.setAttribute('class', 'rodri_resumen_p margin_left_10px'); 
    seccion_resumen.appendChild(title);
    seccion_resumen.appendChild(p);       
    seccion_resumen.appendChild(br);       
  }

  function addDescripcion(text2, seccion_resumen){
    var p = document.createElement("P");
    p.innerHTML = text2;
    p.setAttribute('class', 'rodri_resumen_p margin_left_10px margin_top_5px');     
    seccion_resumen.appendChild(p);       
  }

  function borrarSeccion(seccion){
    var myNode = document.getElementById(seccion);
            while (myNode.firstChild) {
                   myNode.removeChild(myNode.firstChild);
            }
  }

  function cargarTitleHeader(){
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    document.getElementById("static_header").hidden = true;
    document.getElementById("static_header_2").innerHTML = "Consultas";
    document.getElementById("static_header_nombre").innerHTML = apellido+", "+nombre;    
  }

  // input 2021-05-10 00:00:00
  // output 10/05/2021
  function transformarFecha(fecha){
    var fecha_aux = fecha.split(" ");
    var fecha_aux2 = fecha_aux[0].split("-");
    return fecha_aux2[2]+"/"+fecha_aux2[1]+"/"+fecha_aux2[0];
  }

  function cargarEstudiosPrevios(){
    cargarConsultasPreviasLh();
    cargarConsultasPreviasLnh();
    cargarConsultasPreviasGm();
    cargarConsultasPreviasPm();    
  }

  function cargarConsultasPrevias(){    
    cargarMotivoConsultaConsulta();
    //cargarExamenFisicoConsulta();
    //cargarImpresionDiagnosticaConsulta();
    //cargarPlanConsulta();
    cargarEvolucionConsulta(true, "seccion_evolucion_consulta_2");
    cargarResumenConsulta();
    cargarMedicacionActualConsulta();
  }

  window.onload=function() {
    mostrarPanelPaciente(true);
    mostrarPanelHistoriaClinica(false);
    cargarTitleHeader();    
    calcularEdad();     
    cargarEstudiosPrevios();
    cargarAntecedentesPersonales();
    cargarAntecedentesFamiliares();
    cargarConsultasPrevias();
    cargarDiagnosticoConsulta();
    //cargarListadoDiagnostico();
    //cargarDiagnostico();
    document.getElementById("antecedentes_familiares_detalles_nuevo").hidden = true;
    document.getElementById("antecedentes_personales_detalles_nuevo").hidden = true;     
  }




</script>

@endsection