<input hidden id="guardado_parcial" value="0" />
<div class="card background_panel_consulta_actual" id="seccion_evolucion_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickEvolucion()" type="button">Evolucion</a></b></h4>
	</div>

	<div id="seccion_evolucion" hidden>				

		<div class="margin_left_20px" id="seccion_evolucion_consulta" hidden>		
			<h6><b>Evoluciones Previas</b></h6>			
		</div>
		<br>
		<form id="evolucion_nueva_consulta" method="post" action="{{ route('guardarevolucionfotos') }}" enctype="multipart/form-data">
			@csrf 
		<div class="row">							 	
			<div class="col-md-6"> 		
				<textarea class="form-control" id="evolucion_detalles" onchange="guardarEvolucion()" name="evolucion_detalles" rows="8"></textarea>	
			</div>				
			<div class="col-md-6"> 									
				<input hidden id="evolucion_id" name="evolucion_id" />
				<input hidden id="evolucion_numero" name="evolucion_numero"/>
				<input hidden id="evolucion_numero_consulta" name="evolucion_numero_consulta"/>
				<input hidden id="evolucion_numero_foto" name="evolucion_numero_foto"/>

				<label id="evolucion_agregar_foto_text">Agregar Foto:</label><br>

				<div id="seccion_evolucion_fotos">
	        <input type="hidden" id="foto_evolucion_id" name="foto_evolucion_id" />
	        <input type="hidden" id="evolucion_cantidad_fotos" name="evolucion_cantidad_fotos" />
	        <input type="file" id="evolucion_foto_1" name="evolucion_foto_1" /> 
			  </div>
          		<br>
          		 		
          		<button id="agregarBotonNuevaFotoEvolucionId" onclick="agregarBotonNuevaFoto()" type="button" class="rodri_button_aceptar">AGREGAR</button> 			
          		<button id="botonGuardarFotoEvolucionId" type="submit" class="rodri_button_aceptar margin_left_20px_cel">GUARDAR</button>

          		<div id="seccion_evolucion_fotos_mostrar">
	          		<div id="seccion_evolucion_ver_fotos" class="margin_top_12px">
						<a type="button" id="evolucion_foto_1" class="card-img-top img_little botonImage" alt="">
		          			<img id="evolucion_foto" src="img/iconos/sin_imagen.jpg" class="card-img-top img_little botonImage">
		          		</a>
						<div class="row margin_top_12px margin_left_60px">					
			    			<button type="button" onclick="evolucionAnteriorSiguienteFoto(0)" class="rodri_button_aceptar_si"><</button>
					    	<input id="evolucion_actual_cantidad_fotos" disabled class="input_width_50px sinBackground margin_left_20px" value="0/0"></input>
					    	<button type="button" onclick="evolucionAnteriorSiguienteFoto(1)" class="rodri_button_aceptar_si">></button>				    					
						</div>
					</div>		
				</div>
			</form>
			</div>			
		<br>		
		<br>		
		</div>
	</div>		
</div>


<div class="margin_left_5px" id="seccion_evolucion_consulta_2" hidden>		
	<h4><b>Evolucion</b></h4>			
</div>


<div class="modal" tabindex="-2" role="dialog" id="modalImagenesEvolucion" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div id="modal_body_id" class="modal-body"> 
				<div class="modal-header">       
					<h4 class="modal-title" id="modalTitleMensaje2">Evolucion Imagen</h4>
				</div>
				<br>
				<div id="container" class="table-responsive">				
					<img id="img_src_evolucion" src="" class="card-img-top">
				</div>			
			</div>
		</div>
	</div>
</div>	

<script type="text/javascript">
	
	function clickEvolucion(){		
		var guardadoParcial = document.getElementById("guardado_parcial");
		if(guardadoParcial.value == 0){
			guardarParcial();
			guardadoParcial.value = 1;
		}
		var seccionPrincipal = document.getElementById("seccion_evolucion");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}		
	}

	function guardarEvolucion(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var descripcion = document.getElementById("evolucion_detalles").value;
		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_evolucion',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			//alert("Guardado con exito actividades extra escolares");
            	} else {
            		mostrarSnackbar("EVOLUCION FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });		
	}

	function cargarEvolucionConsulta(value, seccion){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		// borrarSeccion("seccion_evolucion_consulta");
		document.getElementById("seccion_evolucion_nueva_consulta").hidden = value;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_evolucion',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){              		           		
           		var modulo_1 = document.getElementById("modulo_1");        		
           		if(modulo_1 != null){
           			modulo_1 = document.getElementById("modulo_1").value;
           		} else {
           			modulo_1 = 0;
           		}
           		var mostrarSeccionBoolean = false; 
           		var seccion_resumen = document.getElementById(seccion);           		
           		for (i = 0; i < data.evoluciones.length; i++){
           			//data.evoluciones[i].horario
           			var agregar = false;
           			var fecha = transformarFecha(data.evoluciones[i].fecha);
           			var texto = "";
           			if(data.evoluciones[i].descripcion.localeCompare("")!=0){
           				texto = data.evoluciones[i].descripcion;
           				agregar = true;           				
           			}
           			var audio = "";
           			if(data.evoluciones[i].audio.localeCompare("")!=0){
           				audio = '<a target="_blank" href="'+data.evoluciones[i].audio+'">Audio</a>';	           	
           				agregar = true;
           			}
           			var imagen = '<img id="evolucion_foto_"'+i+' src="img/iconos/sin_imagen.jpg" class="card-img-top small botonImage">';
           				if(data.evoluciones[i].imagen.localeCompare("") != 0){	           		           				
           					agregar = true;           					
           					imagen = '<img id="evolucion_foto_"'+i+' src="img/'+data.evoluciones[i].imagen+'" class="card-img-top small botonImage" onclick="clickEvolucionImagen('+data.evoluciones[i].evolucion_id+')">';           					         				
           				}
         				var profesional = data.evoluciones[i].profesional;         				
           			if(agregar){
           				if(modulo_1 == 1){
           					
           					addText(profesional+" - "+fecha, audio+" "+imagen, seccion_resumen);
           					addTextArea(texto, seccion_resumen);
           					
           				} else {
           					
           					addText(profesional+" - "+fecha, audio+" "+imagen +" "+texto, seccion_resumen);           				
           				}
           				
           				mostrarSeccionBoolean = true;
           			}
           		}           		           		
           		if(mostrarSeccionBoolean){
           			document.getElementById(seccion).hidden = false;
           		} else {
           			document.getElementById(seccion).hidden = true;
           		}          		           		    
            }
        });	
	}

		

	// input 2021-05-10 00:00:00
  // output 10/05/2021
  function transformarFecha(fecha){
    var fecha_aux = fecha.split(" ");
    var fecha_aux2 = fecha_aux[0].split("-");
    return fecha_aux2[2]+"/"+fecha_aux2[1]+"/"+fecha_aux2[0];
  }

  // text1: text2  + bajada de renlgon
  function addText(text1, text2, seccion_resumen) {                    
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

	function clickEvolucionImagen(evolucion_id){		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_evolucion_foto',
           data:{evolucion_id:evolucion_id,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null){           		           		
           			var modalImg = document.getElementById("img_src");
					modalImg.src = "img/"+data.response_data[0].foto;
					document.getElementById("cantidad_fotos_modal_ncf").hidden = false;
					var tope = data.response_data.length;
					document.getElementById("cantidad_fotos_modal_ncf").value = tope+"/"+tope;
					document.getElementById("evolucion_id").value = evolucion_id;
					document.getElementById("evolucion_numero_foto").value = tope;
					document.getElementById("manipular_image_id").value = 1;
					$('#myModalImagenes').modal('show');
            	} 
            }
        });	
	}

	function cargarEvolucion(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;				
		var parcial = 1;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_evolucion',
           data:{consulta:consulta, paciente:paciente, parcial:parcial,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){           		           		
           			document.getElementById("evolucion_detalles").value = data.response_data[0].descripcion;   
           			if(data.response_data[0].audio.localeCompare("")!=0){
           				document.getElementById("duracion").innerHTML = '<a target="_blank" href="'+data.response_data[0].audio+'">Click aqui para reproducir</a>';
           			}
           			cargarEvolucionFotos();
            	} 
            }
        });	
	}	

	function agregarBotonNuevaFoto(){
	    var cantidadFotos = document.getElementById("evolucion_cantidad_fotos").value;  //1      
	    var viejoValor = parseInt(cantidadFotos); // 1
	    var nuevoValor = parseInt(cantidadFotos) + 1;      
	  //  var btn = document.getElementById("foto-"+viejoValor);
	    var ultimoFile = document.getElementById("evolucion_foto_"+viejoValor);	    
	    var f = ultimoFile.value;	    
	    if(f.localeCompare('') != 0){
	      $('#evolucion_cantidad_fotos').val(nuevoValor);
	      var seccion = document.getElementById("seccion_evolucion_fotos");                  
	      var input = document.createElement("INPUT");
	      input.type = 'file';
	      input.id = 'evolucion_foto_'+nuevoValor;
	      input.name = 'evolucion_foto_'+nuevoValor;
	      seccion.appendChild(input);	      
	    }
  	}

  	function cargarEvolucionFotos(){  						
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_evolucion_fotos',
           data:{ _token: '{{csrf_token()}}'},
           	success:function(data) {              	           		           		
           		if(data.response == 1) {             		           		
           			if(data.ultimaFotoEvolucion != null && data.ultimaFotoEvolucion.foto.localeCompare('') != 0) {	
           			 	document.getElementById("evolucion_id").value = data.ultimaFotoEvolucion.evolucion_id;
           			 	
		                var imagen = document.getElementById("evolucion_foto");
		                $("#evolucion_foto").attr("src", "img/"+data.ultimaFotoEvolucion.foto);						

						imagen.onclick = function() {                                                  
		                  onClickVerMI(data.ultimaFotoEvolucion.foto, 1);
		                  document.getElementById("panelAvanzarMI").hidden = false;
		                  document.getElementById("panelCantidadMI").hidden = false;
		                } 		                   
		                document.getElementById("evolucion_numero_foto").value = data.cantidadFotos;
		                var valorFoto = data.cantidadFotos+"/"+data.cantidadFotos;
	           			document.getElementById("evolucion_actual_cantidad_fotos").value = valorFoto;
	           			document.getElementById("cantidad_fotos_modal_ncf").value = valorFoto;			                       		                
		              } else {		              			                		                
		                $("#evolucion_foto").attr("src", "img/iconos/sin_imagen.jpg");                                
		                document.getElementById("evolucion_actual_cantidad_fotos").value = "0/0";
		                document.getElementById("cantidad_fotos_modal_ncf").value = "0/0";	
		              }
            	} else {
            		$("#evolucion_foto").attr("src", "img/iconos/sin_imagen.jpg");                                
		            document.getElementById("evolucion_actual_cantidad_fotos").value = "0/0";
		            
            	}        	
            }
        });
  	}

  	function evolucionAnteriorSiguienteFoto(opcion) { 		
		var evolucion_id = document.getElementById("evolucion_id").value;
		var paciente = document.getElementById("paciente_id").value;	
		
		var consultaActual = document.getElementById("consulta_id").value;		
		
		var tope_aux = document.getElementById("evolucion_actual_cantidad_fotos").value;
		var tope = tope_aux.split("/");
		tope = tope[1];

		var numero_actual = document.getElementById("evolucion_numero_foto").value;		
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
           			           				
       				document.getElementById("evolucion_numero_foto").value = data.numero;
        			        				        								
					var valor = data.numero+"/"+data.evolucion_cantidad;
           			document.getElementById("evolucion_actual_cantidad_fotos").value = valor;	
           			document.getElementById("cantidad_fotos_modal_ncf").value = valor;		   			
           			
           			if(data.evolucion.foto.localeCompare('') != 0) { 
           			               		                
		                var imagen = document.getElementById("evolucion_foto");
		                 $("#evolucion_foto").attr("src", "img/"+data.evolucion.foto);
						
						imagen.onclick = function() {                                                  
		                  onClickVerMI(data.evolucion.foto, 1);
		                  document.getElementById("panelAvanzarMI").hidden = false;
		                  document.getElementById("panelCantidadMI").hidden = false;
		                } 	
		              } else {		              	
		                $("#evolucion_foto").attr("src", "img/iconos/sin_imagen.jpg");                                 
		              }
           		}
            }
        });
	}


	function evolucionFotoAnteriorSiguienteFotoModal(opcion){
		var evolucion_id = document.getElementById("evolucion_id").value;
		var paciente = document.getElementById("paciente_id").value;	
		
		var consultaActual = document.getElementById("consulta_id").value;		
		
		var tope_aux = document.getElementById("evolucion_actual_cantidad_fotos").value;
		var tope = tope_aux.split("/");
		tope = tope[1];

		var numero_actual = document.getElementById("evolucion_numero_foto").value;		
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
           data:{evolucion_id:evolucion_id ,numero:numero ,_token: '{{csrf_token()}}'},
           	success:function(data){        

           		if(data.response == 1){           			           			
           			           				
       				document.getElementById("evolucion_numero_foto").value = data.numero;
        			        				        								
					var valor = data.numero+"/"+data.evolucion_cantidad;
           			document.getElementById("evolucion_actual_cantidad_fotos").value = valor;	
           			document.getElementById("cantidad_fotos_modal_ncf").value = valor;		   			
           			
           			if(data.evolucion.foto.localeCompare('') != 0) { 
           			               		                
		                var imagen = document.getElementById("evolucion_foto");
		                 $("#evolucion_foto").attr("src", "img/"+data.evolucion.foto);
						 $("#img_src").attr("src", "img/"+data.evolucion.foto); 
						imagen.onclick = function() {                                                  
		                  onClickVerMI(data.evolucion.foto, 1);
		                  document.getElementById("panelAvanzarMI").hidden = false;
		                  document.getElementById("panelCantidadMI").hidden = false;
		                } 	
		              } else {		              	
		                $("#evolucion_foto").attr("src", "img/iconos/sin_imagen.jpg");     
		                $("#img_src").attr("src", "img/iconos/sin_imagen.jpg");                         
		              }
           		}           		
            }
        });
	}


	function mostrarModalConsultasPrevias(){
		var paciente_id = document.getElementById("paciente_id").value;
		var consulta_id = document.getElementById("consulta_id").value;
		cargarDatosEvolucionModal(consulta_id, paciente_id);
		$('#modalConsultasPrevias').modal();
	}

</script>

