<div class="modal fade" id="modalConsultasPrevias" 
     tabindex="-1" role="dialog" 
     aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
     
      <div class="modal-header">        
        <h4 class="modal-title"         
        id="modalTitleMensaje">Consultas Previas</h4>
      </div>      
       
      <div class="modal-body margin_left_60px">          
          <div class="row">
              <div class="col-md-9">
                <b>Fecha:</b><p id="modal_evolucion_fecha" class="margin_left_5px"></p>
                <p id="modal_evolucion_audio" class="margin_left_20px"></p>
              </div>
            
            <div class="col-md-3">
              <button type="button" onclick="modalEvolucionAnteriorSiguiente(0)" class="rodri_button_aceptar_si"><</button>
              <input id="modal_evolucion_actual_cantidad_evoluciones" disabled class="input_width_50px sinBackground" value="0/0"></input>
              <button type="button" onclick="modalEvolucionAnteriorSiguiente(1)" class="rodri_button_aceptar_si">></button>                
            </div>

          </div>                                     
          
          <div class="row">         
            <div class="col-md-12">    
              <b>Detalle:</b><p id="modal_evolucion_detalles"></p>            
            </div>                              
          </div>                           
          <input hidden id="modal_paciente_id" />
          <input hidden id="modal_consulta_id" />                                        

          <input hidden id="modal_evolucion_id" />
          <input hidden id="modal_evolucion_numero"/>
          <input hidden id="modal_evolucion_numero_consulta"/>
          <input hidden id="modal_evolucion_numero_foto" />
          
          <input hidden id="modal_evolucion_numero_evoluciones" />                      

          <div id="seccion_evolucion_fotos">
              <input type="hidden" id="modal_foto_evolucion_id" />
              <input type="hidden" id="modal_evolucion_cantidad_fotos" />                  
          </div>
          <br>

          <div class="row" id="modal_seccion_imagen">                  
            <a type="button" id="modal_evolucion_foto_1" class="card-img-top" alt="">
              <img id="modal_evolucion_foto" src="img/iconos/sin_imagen.jpg" class="card-img-top">
            </a>
          </div>                  
                  
          <div class="row contenedor3" id="modal_seccion_imagen_botones">
            <div class="contenido3">          
              <button type="button" onclick="modalEvolucionAnteriorSiguienteFoto(0)" class="rodri_button_aceptar_si"><</button>
              <input id="modal_evolucion_actual_cantidad_fotos" disabled class="input_width_50px sinBackground margin_left_20px" value="0/0"></input>
              <button type="button" onclick="modalEvolucionAnteriorSiguienteFoto(1)" class="rodri_button_aceptar_si">></button>  
              </div>                    
          </div>
              
      </div>          
      
      <div class="modal-footer">
        <button type="button" 
           class="rodri_button_aceptar" 
           data-dismiss="modal">Aceptar</button>              
      </div>

    </div>
  </div>
</div>


<script type="text/javascript">

      // input 2021-05-10 00:00:00
  // output 10/05/2021
  function transformarFecha(fecha){
    var fecha_aux = fecha.split(" ");
    var fecha_aux2 = fecha_aux[0].split("-");
    return fecha_aux2[2]+"/"+fecha_aux2[1]+"/"+fecha_aux2[0];
  }
  
  function cargarDatosEvolucionModal(consulta, paciente){    
    document.getElementById("modal_consulta_id").value = consulta;
    document.getElementById("modal_paciente_id").value = paciente;
    $.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_evolucion',
           data:{paciente:paciente, consulta:consulta,_token: '{{csrf_token()}}'},
            success:function(data){                             
              if(data.response_data != null && data.response == 1){
                var fecha = transformarFecha(data.response_data[0].updated_at); 
                document.getElementById("modal_evolucion_fecha").innerHTML = fecha;   
                document.getElementById("modal_evolucion_detalles").innerHTML = data.response_data[0].descripcion;   
                document.getElementById("modal_evolucion_audio").hidden = true;
                
                if(data.response_data[0].audio.localeCompare("")!=0){
                  document.getElementById("modal_evolucion_audio").hidden = false;
                  document.getElementById("modal_evolucion_audio").innerHTML = '<a target="_blank" href="'+data.response_data[0].audio+'">Audio</a>';
                }

                var tope_evoluciones = data.response_data.length;
                document.getElementById("modal_evolucion_actual_cantidad_evoluciones").value = tope_evoluciones+"/"+tope_evoluciones;
                document.getElementById("modal_evolucion_numero_evoluciones").value = tope_evoluciones;

                modalCargarEvolucionFoto(data.response_data[0].id);
              } 
            }
        }); 
  }


  function modalCargarEvolucionFoto(evolucion_id){
    $.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_evolucion_foto',
           data:{evolucion_id:evolucion_id,_token: '{{csrf_token()}}'},
            success:function(data){                             
              if(data.response_data != null && data.response == 1){                             
                document.getElementById("modal_seccion_imagen").hidden = false;
                document.getElementById("modal_seccion_imagen_botones").hidden = false;

                var modalImg = document.getElementById("modal_evolucion_foto");                
                modalImg.src = "img/"+data.response_data[0].foto;          
                var tope = data.response_data.length;
                document.getElementById("modal_evolucion_actual_cantidad_fotos").value = tope+"/"+tope;
                document.getElementById("modal_evolucion_id").value = evolucion_id;
                document.getElementById("modal_evolucion_numero_foto").value = tope;                                
              } else {
                document.getElementById("modal_seccion_imagen").hidden = true;
                document.getElementById("modal_seccion_imagen_botones").hidden = true;                
              } 
            }
        }); 
  }

  function modalEvolucionAnteriorSiguienteFoto(opcion) {     
    var evolucion_id = document.getElementById("modal_evolucion_id").value;
    var paciente = document.getElementById("modal_paciente_id").value;  
    
    var consultaActual = document.getElementById("modal_consulta_id").value;    
    
    var tope_aux = document.getElementById("modal_evolucion_actual_cantidad_evoluciones").value;
    var tope = tope_aux.split("/");
    tope = tope[1];

    var numero_actual = document.getElementById("modal_evolucion_numero_foto").value;   
    if(opcion == 1){ // avanzo      
      var numero = parseInt(numero_actual) + 1;
      if(numero > parseInt(tope))
        numero = tope;
    } else {      
      var numero = parseInt(numero_actual) - 1; 
      if(numero < 1)
        numero = 1;
    }

    $.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_evolucion_ant_sig_foto',
           data:{evolucion_id:evolucion_id, numero:numero ,_token: '{{csrf_token()}}'},
            success:function(data){     
                       
              if(data.response == 1){                                 
                                  
              document.getElementById("modal_evolucion_numero_foto").value = data.numero;
                                                      
              var valor = data.numero+"/"+data.evolucion_cantidad;
              document.getElementById("modal_evolucion_actual_cantidad_fotos").value = valor;                 
              
              if(data.evolucion.foto.localeCompare('') != 0) { 
                                                
                  var imagen = document.getElementById("modal_evolucion_foto");
                  $("#modal_evolucion_foto").attr("src", "img/"+data.evolucion.foto);

                } else {                    
                  $("#modal_evolucion_foto").attr("src", "img/iconos/sin_imagen.jpg");                                 
                }
              }
            }
        });
  }

  // debo agregar un boton previo y siguiente arriba a la derecha para avanzar en las evoluciones.


  function modalEvolucionAnteriorSiguiente(opcion) {     
    var evolucion_id = document.getElementById("modal_evolucion_id").value;
    var paciente = document.getElementById("modal_paciente_id").value;  
    
    var consultaActual = document.getElementById("modal_consulta_id").value;    
    
    var tope_aux = document.getElementById("modal_evolucion_actual_cantidad_evoluciones").value;
    var tope = tope_aux.split("/");
    tope = tope[1];

    var numero_actual = document.getElementById("modal_evolucion_numero_evoluciones").value;   
    if(opcion == 1){ // avanzo      
      var numero = parseInt(numero_actual) + 1;
      if(numero > parseInt(tope))
        numero = tope;
    } else {      
      var numero = parseInt(numero_actual) - 1; 
      if(numero < 1)
        numero = 1;
    }

    $.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_evolucion_ant_sig',
           data:{paciente_id:paciente, numero:numero ,_token: '{{csrf_token()}}'},
            success:function(data){     
                       
              if(data.response == 1){                                                                 
                document.getElementById("modal_evolucion_numero_evoluciones").value = data.numero;
                                                        
                var valor = data.numero+"/"+data.evolucion_cantidad;
                document.getElementById("modal_evolucion_actual_cantidad_evoluciones").value = valor;                 
                    
                var fecha = transformarFecha(data.evolucion.updated_at); 
                document.getElementById("modal_evolucion_fecha").innerHTML = fecha;   
                document.getElementById("modal_evolucion_detalles").innerHTML = data.evolucion.descripcion;   
                document.getElementById("modal_evolucion_audio").hidden = true;
                
                if(data.evolucion.audio.localeCompare("")!=0){
                  document.getElementById("modal_evolucion_audio").hidden = false;
                  document.getElementById("modal_evolucion_audio").innerHTML = '<a target="_blank" href="'+data.evolucion.audio+'">Audio</a>';
                }
                modalCargarEvolucionFoto(data.evolucion.id);                
              }
            }
        });
  }


</script>