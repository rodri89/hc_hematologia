<form class="card background_panel_consulta_actual" id="seccion_resumen_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickResumen()" type="button">Resumen</a></b></h4>
	</div>	
	<div id="seccion_resumen" hidden>		
		
		<div class="row margin_left_5px">		
			<textarea class="form-control width650px_cel" id="resumen_detalles" name="resumen_detalles" rows="6" cols="100"></textarea>	
		</div>

		<br>		
	</div>
</form>

<div class="margin_left_5px" id="seccion_resumen_consulta" hidden>	
	<h4><b>Resumen</b></h4><br>		
</div>


<script type="text/javascript">
	
	function clickResumen(){
		seccionPrincipal = document.getElementById("seccion_resumen");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	function guardarResumen(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var descripcion = document.getElementById("resumen_detalles").value;
		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_resumen',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			//alert("Guardado con exito actividades extra escolares");
            	} else {
            		mostrarSnackbar("RESUMEN FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });		
	}

	function cargarResumenConsulta(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		// borrarSeccion("seccion_examen_fisico_consulta");
		document.getElementById("seccion_resumen_nueva_consulta").hidden = true;		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_resumen',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){  
           		var modulo_1 = document.getElementById("modulo_1").value;        		
           		if(data.response_data != null && data.response == 1){              		           		           		
           			document.getElementById("seccion_resumen_consulta").hidden = true;
           			var seccion_resumen = document.getElementById("seccion_resumen_consulta");
           			var mostrarSeccion = false;
           			for (i = 0; i < data.response_data.length; i++){           		
           				var profesional = getProfesional(data.response_data[i].name);		           	
	           			var fecha = transformarFecha(data.response_data[i].created_at);
	           			if(data.response_data[i].descripcion.localeCompare("")!=0){
	           				if(modulo_1 == 1){
	           					addText(profesional+" - "+fecha, "", seccion_resumen);
	           					addTextArea(data.response_data[i].descripcion, seccion_resumen);
	           				} else {
	           					addText(profesional+" - "+fecha, data.response_data[i].descripcion, seccion_resumen);		
	           				}
	           				mostrarSeccion = true;
	           				
	           			}
           			}
           			if(mostrarSeccion){
           				document.getElementById("seccion_resumen_consulta").hidden = false;
           			}
            	} else {            		
            		document.getElementById("seccion_resumen_consulta").hidden = true;
            	}           	
            }
        });	
	}

	function getProfesional(nombre){
	    var nombreAux = nombre.split(",");
	    var apellido = nombreAux[0];
	    var nombre = nombreAux[1];
	    return apellido+", "+nombre.substring(0,2).toUpperCase();
	  }

	function cargarResumen(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;				
		var parcial = 1;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_resumen',
           data:{consulta:consulta, paciente:paciente, parcial:parcial,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){           		           		
           			document.getElementById("resumen_detalles").value = data.response_data[0].descripcion;           		
            	} 
            }
        });	
	}
</script>