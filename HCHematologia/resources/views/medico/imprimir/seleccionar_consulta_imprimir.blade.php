
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

<style type="text/css">
  .print_text_area {
  color: red;
  }
</style>

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

@if($tipo_consulta!=null)
<input hidden class="form-control" type="text" name="tipo_consulta" id="tipo_consulta" value="{{$consulta->tipo_consulta}}" />   
@else
<input hidden class="form-control" type="text" name="tipo_consulta" id="tipo_consulta" value="-1" />   

@endif
<input hidden class="form-control" type="text" id="nombre" value="{{$paciente->nombre}}" />

<input hidden class="form-control" type="text" id="apellido" value="{{$paciente->apellido}}" />

<br>

<table class="table table-condensed" id="tabla_pacientes" name="tabla_pacientes">
     <thead class="fondoNav text-white">
        <tr>
          <th class="editText" scope="col">#</th>          
          <th class="editText">Fecha</th>                  
          <th class="editText">Resumen</th>                  
          <th class="editText">Seleccionar</th>                              
        </tr>
      </thead>
      <tbody id="pacientes-list" name="pacientes-list">
          <?php $cont = 1; ?>
          @foreach($listadoResumenes as $c)
            <tr>
            <th scope="row">{{$cont++}}</th>
            <?php 
              $fechaMostrarArray1 = explode(" ", $c->created_at);
              $fechaMostrarArray2 = explode("-", $fechaMostrarArray1[0]);
              $fechaMostrar = $fechaMostrarArray2[2].'/'.$fechaMostrarArray2[1].'/'.$fechaMostrarArray2[0];
             ?>
            <td>{{$fechaMostrar}}</td>
            <td>{{$c->descripcion}}</td>
            <td><button onclick="mostrarConsultaSeleccionada('{{$c->consulta_id}}')" class="rodri_button_aceptar_si">></button></td>
          @endforeach
      </tbody>
</table>


<div id="modal_resumen_consulta_paciente" class="modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-body"> 
        <div class="modal-header">       
          <h4 class="modal-title"         
            id="modalTitleMensaje">Imprimir Consulta</h4><p id="edad_mostrar" class="margin_right_5px cel_size_input"></p>
        </div> 
        <div id="seccion_resumen margin_left_20px">  
            <br>          
            <h5>Antecedentes Personales:</h5>            
            <textarea class="form-control margin_left_5px" style="width:750px" id="modal_antecedentes_personales_detalle_imprimir_id" rows="6" cols="100"></textarea>
            <br>
            <h5>Antecedentes Familiares:</h5>            
            <textarea class="form-control margin_left_5px" style="width:750px" id="modal_antecedentes_familiares_detalle_imprimir_id" rows="6" cols="100"></textarea>
            <br>            
            <h5>Evolucion:</h5>            
            <div id="seccion_evolucion_imprimir"></div>
            <!-- <textarea class="form-control margin_left_5px" style="width:750px" id="modal_evolucion_detalle_imprimir_id" rows="6" cols="100" placeholder="Escriba aqui si tiene alguna observacion"></textarea> -->
            <br>
            <h5>Resumen:</h5>                      
            <textarea class="form-control margin_left_5px" style="width:750px" id="modal_resumen_id" rows="6" cols="100" placeholder="Escriba aqui si tiene alguna observacion"></textarea>
            <br>
            <h5>Observacion:</h5>
            <textarea class="form-control margin_left_5px" style="width:750px" id="modal_observacion_id" rows="6" cols="100" placeholder="Escriba aqui si tiene alguna observacion"></textarea>
            <br>  
            <div id="seccion_tabla_laboratorio"></div>
            <div id="seccion_tabla_control_anticoagulacion"></div>
            <div id="seccion_tabla_trombofilia"></div>            
            <div id="seccion_tabla_transtorno_hemorragiparo"></div>
            <br>
        <div class="modal-footer">            
             <button type="button" 
             class="rodri_button_volver"             
             data-dismiss="modal">Volver</button>             

             <button type="button" 
             class="rodri_button_aceptar"             
             data-dismiss="modal"
             onclick="imprimir()">Imprimir</button>             
        </div>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">  

  function mostrarConsultaSeleccionada(consulta_id) {
    borrarSeccion("seccion_tabla_laboratorio");
    borrarSeccion("seccion_tabla_control_anticoagulacion");
    borrarSeccion("seccion_tabla_trombofilia");
    borrarSeccion("seccion_tabla_transtorno_hemorragiparo");

    // document.getElementById("modal_evolucion_detalle_imprimir_id").value = "";
    document.getElementById("modal_resumen_id").value = "";
    document.getElementById("modal_observacion_id").value = "";

    var paciente_id = document.getElementById('paciente_id').value;
    document.getElementById("consulta_id").value = consulta_id;
    $.ajax({
         type:'POST',
         dataType:'JSON',
         url:'/get_informacion_imprimir',
         data:{paciente_id :paciente_id, consulta_id:consulta_id,_token: '{{csrf_token()}}'},
         success:function(data) {    
            if(data.antecedentes.length > 0){
              var textoAntFamiliares = "";
              var textoAntPersonales = "";
              for (i = 0; i < data.antecedentes.length; i++){
                if(data.antecedentes[i].antecedentes_familiares.localeCompare("") != 0){
                  textoAntFamiliares = textoAntFamiliares + data.antecedentes[i].antecedentes_familiares +"\n";
                }
                if(data.antecedentes[i].antecedentes_personales.localeCompare("") != 0){
                  textoAntPersonales = textoAntPersonales + data.antecedentes[i].antecedentes_personales +"\n";
                }                  
              }
              document.getElementById("modal_antecedentes_familiares_detalle_imprimir_id").value = textoAntFamiliares;
              document.getElementById("modal_antecedentes_personales_detalle_imprimir_id").value = textoAntPersonales;
            }
            if(data.resumen != null){
              document.getElementById("modal_resumen_id").value = data.resumen.descripcion;
            }
            if(data.evoluciones != null){
              for (i = 0; i < data.evoluciones.length; i++){
                if(data.evoluciones[i].descripcion.localeCompare("")!=0){
                  agregarEvolucionCheck(data.evoluciones[i].id, data.evoluciones[i].descripcion, data.evoluciones[i].created_at);  
                }              
              // document.getElementById("modal_evolucion_detalle_imprimir_id").value = data.evolucion.descripcion;              
              }
            }
            if(data.laboratorioGeneralArraySize > 0){                            
              crearTablaLaboratorio2("Laboratorio General:",data.laboratorioGeneralCantidadConsultas.length, data.laboratorioGeneralCantidadConsultas, data.laboratorioGeneralArraySize, data.laboratorioGeneralArray,"seccion_tabla_laboratorio");
            }
            if(data.controlAnticoagulacionArraySize > 0 ){
              crearTablaLaboratorio2("Control Anticoagulacion:",data.controlAnticoagulacionCantidadConsultas.length, data.controlAnticoagulacionCantidadConsultas, data.controlAnticoagulacionArraySize, data.controlAnticoagulacionArray, "seccion_tabla_control_anticoagulacion");            
            }
            if(data.trombofiliaArraySize > 0 ){
              crearTablaLaboratorio2("Trombofilia:",data.trombofiliaCantidadConsultas.length, data.trombofiliaCantidadConsultas, data.trombofiliaArraySize, data.trombofiliaArray, "seccion_tabla_trombofilia");            
            }
            if(data.transtornoHemorragiparoArraySize > 0 ){
              crearTablaLaboratorio2("Transtorno Hemorragiparo:",data.transtornoHemorragiparoCantidadConsultas.length, data.transtornoHemorragiparoCantidadConsultas, data.transtornoHemorragiparoArraySize, data.transtornoHemorragiparoArray, "seccion_tabla_transtorno_hemorragiparo");            
            }

            $('#modal_resumen_consulta_paciente').modal('show');           
         }
      });    
  }

  function crearTablaLaboratorio2(titulo, tope, fechas, arraySize, array, seccion_resumen){    
      //alert(fechas[fe].fecha);
    var div = document.getElementById(seccion_resumen);    
    var br1 = document.createElement("br");
    div.appendChild(br1);

    var checkboxImp = document.createElement("INPUT");
    checkboxImp.setAttribute("type", "checkbox");        
    checkboxImp.style.marginRight = "10px";    
    checkboxImp.id = titulo+"check_imp_id";         
    checkboxImp.checked = true;
    div.appendChild(checkboxImp);

    var label_informativo2 = document.createElement("SMALL");            
    label_informativo2.style.marginLeft = "5px";
    label_informativo2.innerHTML = "¿Desea imprimir este laboratorio?";  
    div.appendChild(label_informativo2);

    div.appendChild(br1);
    
    var checkbox = document.createElement("INPUT");
    checkbox.setAttribute("type", "checkbox");        
    checkbox.style.marginRight = "10px";    
    checkbox.id = titulo+"check_id";  
    div.appendChild(checkbox);

    var input_checkbox = document.createElement("INPUT");
    input_checkbox.setAttribute("type", "numeric");    
    input_checkbox.id = titulo+"input_check_id";
    input_checkbox.style.width = "50px";
    input_checkbox.value = 0;  
    div.appendChild(input_checkbox);

    var label_informativo = document.createElement("SMALL");            
    label_informativo.style.marginLeft = "5px";
    label_informativo.innerHTML = "(El valor ingresado sera para adicionar espacios en blanco al momento de imprimir)";  
    div.appendChild(label_informativo);

    var title = document.createElement("h5");
    title.innerHTML = titulo;    
    title.setAttribute("margin-bottom", "15px");
    div.appendChild(title);
    
    var tabla   = document.createElement("table");

    var thead = document.createElement("thead");    
    th = document.createElement("th");    
    th.innerHTML = "";
    thead.appendChild(th);
    for (var j = 0; j < 5; j++) {
      th = document.createElement("th");    
      if(fechas[j] != null){
        th.innerHTML = transformarFecha(fechas[j].fecha);
        thead.appendChild(th);    
      }      
    }    

    var tblBody = document.createElement("tbody");
    var tr = document.createElement("tr");    
    var th = document.createElement("th");    
    tr.appendChild(th);    
    /* for (var i = 0; i < tope; i++) {
      th = document.createElement("th");    
      th.innerHTML = fechas[fe].fecha;
      tr.appendChild(th);    
    } */
    var cont = 0;
    tblBody.appendChild(tr);
    tr = document.createElement("tr");
    for (var i = 0; i <= arraySize; i++) {
      if(cont++ <= tope){
        th = document.createElement("th");    
        th.innerHTML = array[i];
        tr.appendChild(th);    
      } else {
        cont = 0;
        tblBody.appendChild(tr);
        tr = document.createElement("tr");
        i -= 1;
      }
    }
    if(tope == 1){
      tabla.setAttribute("width", "200px");
    } else {
    if(tope == 2){
      tabla.setAttribute("width", "250px");
    } else {
      if(tope == 3){
        tabla.setAttribute("width", "300px");
      } else {
      if(tope == 4){
        tabla.setAttribute("width", "350px");
      } else {
        if(tope == 5){
          tabla.setAttribute("width", "400px");
        } else {
          if(tope == 6){
            tabla.setAttribute("width", "450px");
          } else {
              tabla.setAttribute("width", "100%");
              }
            }
          }
        }
      }
    }
    tabla.appendChild(thead);
    tabla.appendChild(tblBody);
    div.appendChild(tabla);
   
  }

  function crearTablaLaboratorio(titulo, tope, fecha, arraySize, array, seccion_resumen){
    var div = document.getElementById(seccion_resumen);    
    var br1 = document.createElement("br");
    div.appendChild(br1);
    
    var checkbox = document.createElement("INPUT");
    checkbox.setAttribute("type", "checkbox");        
    checkbox.style.marginRight = "10px";    
    checkbox.id = titulo+"check_id";  
    div.appendChild(checkbox);

    var input_checkbox = document.createElement("INPUT");
    input_checkbox.setAttribute("type", "numeric");    
    input_checkbox.id = titulo+"input_check_id";
    input_checkbox.style.width = "50px";
    input_checkbox.value = 0;  
    div.appendChild(input_checkbox);

    var label_informativo = document.createElement("SMALL");            
    label_informativo.style.marginLeft = "5px";
    label_informativo.innerHTML = "(El valor ingresado sera para adicionar espacios en blanco al momento de imprimir)";  
    div.appendChild(label_informativo);

    var title = document.createElement("h5");
    title.innerHTML = titulo;    
    title.setAttribute("margin-bottom", "15px");
    div.appendChild(title);
    
    var tabla   = document.createElement("table");
    var tblBody = document.createElement("tbody");
    var tr = document.createElement("tr");    
    var th = document.createElement("th");    
    tr.appendChild(th);    
    for (var i = 0; i < tope; i++) {
      th = document.createElement("th");    
      th.innerHTML = fecha;
      tr.appendChild(th);    
    }
    var cont = 0;
    tblBody.appendChild(tr);
    tr = document.createElement("tr");
    for (var i = 0; i <= arraySize; i++) {
      if(cont++ <= tope){
        th = document.createElement("th");    
        th.innerHTML = array[i];
        tr.appendChild(th);    
      } else {
        cont = 0;
        tblBody.appendChild(tr);
        tr = document.createElement("tr");
        i -= 1;
      }
    }
    if(tope == 1){
      tabla.setAttribute("width", "200px");
    } else {
    if(tope == 2){
      tabla.setAttribute("width", "250px");
    } else {
      if(tope == 3){
        tabla.setAttribute("width", "300px");
      } else {
      if(tope == 4){
        tabla.setAttribute("width", "350px");
      } else {
        if(tope == 5){
          tabla.setAttribute("width", "400px");
        } else {
          if(tope == 6){
            tabla.setAttribute("width", "450px");
          } else {
              tabla.setAttribute("width", "100%");
              }
            }
          }
        }
      }
    }
    tabla.appendChild(tblBody);
    div.appendChild(tabla);
  }

  function fechaMostrar(fecha){
    var fechaArray = fecha.split("-");
    return fechaArray[2]+"/"+fechaArray[1]+"/"+fechaArray[0];
  }

function imprimir() {
    var paciente_id = document.getElementById('paciente_id').value;
    var consulta_id = document.getElementById("consulta_id").value;

    $.ajax({
         type:'POST',
         dataType:'JSON',
         url:'/get_informacion_imprimir',
         data:{paciente_id :paciente_id, consulta_id:consulta_id,_token: '{{csrf_token()}}'},
         success:function(data) {               
            if(data.resumen != null){
              //document.getElementById("resumen_consulta_modal").innerHTML = data.resumen.descripcion;
              // crearTablaLaboratorio(data);  
              var ventana = window.open(' ', 'popimpr');                            
              ventana.document.write( '<label style="font-size:1.3rem;"><b>Resumen de consulta </b></label>'); 
              ventana.document.write( '<div style="margin-bottom:15px;margin-top:15px">' );
              ventana.document.write( '<h5 style="font-size:1.2rem;"><u>Datos Paciente:</u></h5>' ); 
                ventana.document.write( '<div style="margin-top:5px">' );                  
                  ventana.document.write( '<label style="font-size:1.0rem;"><b>Nombre y Apellido: </b></label>'); 
                  ventana.document.write( '<label style="font-size:1.0rem;">'+data.paciente.nombre+', </label>');                   
                  ventana.document.write( '<label style="font-size:1.0rem;">'+data.paciente.apellido+'</label>'); 
                  ventana.document.write( '<label style="font-size:1.0rem;margin-left:5px"><b>DNI: </b></label>');
                  ventana.document.write( '<label style="font-size:1.0rem;">'+data.paciente.dni+'</label>');  
                  ventana.document.write( '<label style="font-size:1.0rem;margin-left:5px"><b>Fec. Nacimiento: </b></label>');
                  ventana.document.write( '<label style="font-size:1.0rem;">'+fechaMostrar(data.paciente.fecha_nacimiento)+'</label>');  
                ventana.document.write( '</div>' );

                ventana.document.write( '<div style="margin-top:5px">' );
                var tieneCont = 0;
                  if(data.paciente.localidad.localeCompare("") !=0 ){                  
                    tieneCont++;
                    ventana.document.write( '<label style="font-size:1.0rem;"><b>Localidad: </b></label>'); 
                    ventana.document.write( '<label style="font-size:1.0rem;">'+data.paciente.localidad+'</label>'); 
                  }
                  if(data.paciente.domicilio.localeCompare("") !=0 ){                  
                    tieneCont++;
                    if(tieneCont == 1){
                      ventana.document.write( '<label style="font-size:1.0rem;margin-left:0px"><b>Dirección: </b></label>'); 
                    } else {
                      ventana.document.write( '<label style="font-size:1.0rem;margin-left:5px"><b>Dirección: </b></label>'); 
                    }
                    
                    ventana.document.write( '<label style="font-size:1.0rem;">'+data.paciente.domicilio+'</label>'); 
                  }
                  if(data.paciente.mail.localeCompare("") !=0 ){                  
                    tieneCont++;
                    if(tieneCont == 1){
                      ventana.document.write( '<label style="font-size:1.0rem;margin-left:0px"><b>Mail: </b></label>');
                    } else {
                      ventana.document.write( '<label style="font-size:1.0rem;margin-left:5px"><b>Mail: </b></label>');
                    }
                    
                    ventana.document.write( '<label style="font-size:1.0rem;">'+data.paciente.mail+'</label>');  
                  }
                  if(data.paciente.telefono.localeCompare("") !=0 ){
                    if(tieneCont < 3){
                      if(tieneCont == 1){
                        ventana.document.write( '<label style="font-size:1.0rem;margin-left:0px"><b>Teléfono: </b></label>');
                      } else {
                        ventana.document.write( '<label style="font-size:1.0rem;margin-left:5px"><b>Teléfono: </b></label>');
                      }                                                                 
                      ventana.document.write( '<label style="font-size:1.0rem;">'+data.paciente.telefono+'</label>');  
                    }                                        
                  }
                ventana.document.write( '</div>' );

                if(tieneCont == 3){
                  ventana.document.write( '<div style="margin-top:5px">' );
                  ventana.document.write( '<label style="font-size:1.0rem;margin-left:0px"><b>Teléfono: </b></label>');
                  ventana.document.write( '<label style="font-size:1.0rem;">'+data.paciente.telefono+'</label>');  
                  ventana.document.write( '</div>' );
                }

              ventana.document.write( '</div>' );


           
              // var certificado_observacion = document.getElementById("certificado_observacion");
              var fecha_firma = document.getElementById("fecha_imprimir");         
              var fecha = document.getElementById("fecha");     

              var textoAntFamiliares = "";
              var textoAntPersonales = "";
              for (i = 0; i < data.antecedentes.length; i++){
                if(data.antecedentes[i].antecedentes_familiares.localeCompare("") != 0){
                  textoAntFamiliares = textoAntFamiliares + data.antecedentes[i].antecedentes_familiares +"<br>";
                }
                if(data.antecedentes[i].antecedentes_personales.localeCompare("") != 0){
                  textoAntPersonales = textoAntPersonales + data.antecedentes[i].antecedentes_personales +"<br>";
                }                  
              }
              if(textoAntFamiliares.localeCompare('') != 0){
                ventana.document.write( '<h5 style="font-size:1.2rem;">Antecedentes Familiares</h5>' ); 
                ventana.document.write('<p style="font-size:0.8rem;margin-top:-30px">'+textoAntFamiliares+'</p>');
              }
              if(textoAntPersonales.localeCompare('') != 0){
                ventana.document.write( '<h5 style="font-size:1.2rem;">Antecedentes Personales</h5>' ); 
                ventana.document.write('<p style="font-size:0.8rem;margin-top:-30px">'+textoAntPersonales+'</p>');
              }

              
              var resumen_detalle = document.getElementById("modal_resumen_id");       
              

              if(hayEvolucionSeleccionada(data.evoluciones)){
                ventana.document.write( '<h5 style="font-size:1.2rem;margin-bottom: 15px">Evolución</h5>' ); 
                var cont = 0;    
                while (cont < data.evoluciones.length){
                  var checkbox_id = "checkbox_evolucion_"+data.evoluciones[cont].id;      
                  if(document.getElementById(checkbox_id) != null && document.getElementById(checkbox_id).checked == true){  
                    var fechaEvo = transformarFecha(data.evoluciones[cont].created_at);
                    var textoEvo = document.getElementById("evolucion_"+data.evoluciones[cont].id).innerHTML;
                    // 77                       
                    var arraytxt = textoEvo.split('\n');
                    var lines = 1;
                    var aux = 0;
                    for(var ll = 0; ll < arraytxt.length; ll++) {                         
                      if(arraytxt[ll].length == 0) {
                        lines = lines + 1;
                      } else {
                        aux = arraytxt[ll].length / 75;
                        let redondeado = Math.ceil(aux);
                        lines = lines + redondeado;
                      }                      
                    }                    
                    
                    ventana.document.write('<b style="font-size:1.0rem;margin-top:-15px">'+fechaEvo+'</b>');
                    ventana.document.write('<textarea style="width:100%; border:none; font-family: inherit; font-size: 1rem;" rows="'+lines+'">'+ textoEvo +'</textarea>');
                    //ventana.document.write('<p style="font-size:0.8rem;margin-top:-15px">'+fechaEvo+' - '+ textoEvo +'</p>');
                  }
                  cont++;
                }                                
              }               

              if(resumen_detalle != null && resumen_detalle.value.localeCompare("") !=0 ){
                ventana.document.write( '<h5 style="font-size:1.2rem;margin-top:0px">Resumen</h5>' ); 
                ventana.document.write('<p style="font-size:0.8rem;margin-top:-30px">'+resumen_detalle.value+'</p>');
              }

              var observacion = document.getElementById("modal_observacion_id");
              if(observacion != null && observacion.value.localeCompare("") !=0 ){
                ventana.document.write( '<h5 style="font-size:1.2rem;margin-top:0px">Observación</h5>' ); 
                ventana.document.write('<p style="font-size:0.8rem; margin-top:-30px">'+observacion.value+'</p>');
              }
              
              //ventana.document.write( '<p style="font-size:1.2rem;">Observaciones:</p>' );    
              //ventana.document.write('<p style="font-size:1.2rem; padding-bottom:20px">'+certificado_observacion.value+'</p>');                              
              agregarLaboratorioParaImprimir(ventana, "Laboratorio General", data.laboratorioGeneralArraySize, data.laboratorioGeneralArray, data.laboratorioGeneralCantidadConsultas.length, data.laboratorioGeneralCantidadConsultas);              

              agregarLaboratorioParaImprimir(ventana, "Control Anticoagulacion", data.controlAnticoagulacionArraySize, data.controlAnticoagulacionArray, data.controlAnticoagulacionCantidadConsultas.length, data.controlAnticoagulacionCantidadConsultas);

              agregarLaboratorioParaImprimir(ventana, "Trombofilia", data.trombofiliaArraySize, data.trombofiliaArray, data.trombofiliaCantidadConsultas.length, data.trombofiliaCantidadConsultas);
              
              agregarLaboratorioParaImprimir(ventana, "Transtorno Hemorragiparo", data.transtornoHemorragiparoArraySize, data.transtornoHemorragiparoArray, data.transtornoHemorragiparoCantidadConsultas.length, data.transtornoHemorragiparoCantidadConsultas);

              ventana.document.write( '<br>' );   
              ventana.document.write( '<br>' );

              //ventana.document.write('<p style="margin-left:150px;">'+fecha.value+'</p>');
              ventana.document.write( '<div style="margin-top:100px;">' );    
              ventana.document.write('<p style=";margin-left:100px; display: inline;">.......................................</p><p style="margin-left:220px; display: inline;">.......................................</p>');
              ventana.document.write( '<br>' );   
              ventana.document.write('<p style="margin-left:150px; display: inline;">Fecha</p><p style="margin-left:300px; display: inline;">Firma y Sello Médico</p>');
              ventana.document.write( '</div>' );    

              ventana.document.close();
              ventana.print( );
              ventana.close();          
            }
         }
      }); 
}


  function hayEvolucionSeleccionada(evoluciones){    
    var cont = 0;    
    while (cont < evoluciones.length){
      var checkbox_id = "checkbox_evolucion_"+evoluciones[cont].id;      
      if(document.getElementById(checkbox_id) != null && document.getElementById(checkbox_id).checked == true){        
        return true;
      }
      cont++;
    }
    return false;
  }
  
  // <div id="seccion_evolucion_imprimir"></div>
            //<textarea class="form-control margin_left_5px" style="width:750px" id="modal_evolucion_detalle_imprimir_id" rows="6" cols="100" placeholder="Escriba aqui si tiene alguna observacion"></textarea>
function agregarEvolucionCheck(evolucion_id, texto, fecha){
  var seccion_evolucion = document.getElementById("seccion_evolucion_imprimir");
  var div = document.createElement("div");      
  
  var checkbox = document.createElement("input");
  checkbox.type = 'checkbox';  
  checkbox.id = "checkbox_evolucion_"+evolucion_id;  

  var label = document.createElement("label");
  label.setAttribute('class', 'margin_left_10px');   
  label.innerHTML = transformarFecha(fecha);

  div.appendChild(checkbox);
  div.appendChild(label);

  var textArea = document.createElement("TextArea");    
  var arraytxt = texto.split('\n');
  textArea.rows = arraytxt.length;
  textArea.innerHTML = texto;    
  textArea.setAttribute('class', 'form-control margin_top_5px margin');   
  textArea.disabled = true;
  textArea.id = "evolucion_"+evolucion_id;

  div.appendChild(textArea);
  seccion_evolucion.appendChild(div);
}

function agregarLaboratorioParaImprimir(ventana, titulo, arraySize, array, tope, arryaCantidadConsultas){
    var checkIdImpLab = titulo+":check_imp_id";
    var checkImprimirLab = document.getElementById(checkIdImpLab);         
    
    if(checkImprimirLab != null && checkImprimirLab.checked) {

      if(arraySize > 0){
          var checkbox_id = titulo+":check_id";  
          var checkbox = document.getElementById(checkbox_id);
          if(checkbox != null && checkbox.checked == true){
            var input_checkbox_id = titulo+":input_check_id";  
            var input_checkbox = document.getElementById(input_checkbox_id).value;
            if(input_checkbox == null || input_checkbox < 0)
              input_checkbox = 0;
            for(var j = 0; j<input_checkbox; j++)
              ventana.document.write( '<br>' );          
          }
          ventana.document.write( '<br>' );
          ventana.document.write( '<h5 style="font-size:1.2rem; margin-top:0px">'+titulo+'</h5>' ); 
          ventana.document.write( '<html><style> td,th{border: 1px solid #e3e6f0; @page {size: 210mm 297mm;margin: 5mm 5mm 5mm 5mm;orphans: 0;widows: 0;}} </style><table style="width:300px;margin-top:-10px">' );                  
          
          ventana.document.write( '<tbody>' ); 
          ventana.document.write( '<tr>' ); 
        
          ventana.document.write( '<th></th>' ); 
          // tr.appendChild(th);    
          for (var i = 0; i < tope; i++) {
            ventana.document.write( '<th>'+fechaMostrar(arryaCantidadConsultas[i].fecha)+'</th>' )                     
            //tr.appendChild(th);    
          }
          ventana.document.write( '</tr>' ); 
          var cont = 0;              
          ventana.document.write( '<tr>' );
          for (var i = 0; i <= arraySize; i++) {
            if(cont == 0)
              ventana.document.write( '<tr>' );
            if(cont++ <= tope){
              ventana.document.write( '<th>'+array[i]+'</th>' );
            } else {
              cont = 0;                  
              ventana.document.write( '</tr>' );
              if(i < arraySize)                                      
                i -= 1;
            }
          }
          ventana.document.write( '</tbody>' );
          ventana.document.write( '</table>' ); 
        }
    }
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
    document.getElementById("static_header_2").innerHTML = "Imprimir Consulta";
    document.getElementById("static_header_nombre").innerHTML = apellido+", "+nombre;    
  }

  // input 2021-05-10 00:00:00
  // output 10/05/2021
  function transformarFecha(fecha){
    if(fecha != null && fecha.localeCompare("") != 0){
      var fecha_aux = fecha.split(" ");
      var fecha_aux2 = fecha_aux[0].split("-");
      return fecha_aux2[2]+"/"+fecha_aux2[1]+"/"+fecha_aux2[0];
    } else {
      return "";
    }
  } 

  window.onload=function() {
    mostrarPanelPaciente(true);
    mostrarPanelHistoriaClinica(false);
    cargarTitleHeader();        
  }




</script>

@endsection