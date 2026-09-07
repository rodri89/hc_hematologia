<form class="card background_panel_consulta_actual" id="seccion_examen_fisico_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickExamenFisico()" type="button">Exámen Físico</a></b></h4>
	</div>	
	<div id="seccion_examen_fisico" hidden>		
		
		<div class="row margin_left_5px">		
			<textarea class="form-control width650px_cel" id="examen_fisico_detalles" name="examen_fisico_detalles" rows="6" cols="100"></textarea>	
		</div>

		<br>		
	</div>
</form>

<div class="margin_left_5px" id="seccion_examen_fisico_consulta" hidden>	
	<h4><b>Exámen Físico</b></h4><br>		
</div>


<script type="text/javascript">
	
	function clickExamenFisico(){
		seccionPrincipal = document.getElementById("seccion_examen_fisico");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	function guardarExamenFisico(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var descripcion = document.getElementById("examen_fisico_detalles").value;
		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_examen_fisico_texto',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			//alert("Guardado con exito actividades extra escolares");
            	} else {
            		mostrarSnackbar("EXAMEN FISICO FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });		
	}

	function cargarExamenFisicoConsulta(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		// borrarSeccion("seccion_examen_fisico_consulta");
		document.getElementById("seccion_examen_fisico_nueva_consulta").hidden = true;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_examen_fisico_texto',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){  
           		if(data.response_data != null && data.response == 1){              		           		           		
           			document.getElementById("seccion_examen_fisico_consulta").hidden = true;
           			var seccion_resumen = document.getElementById("seccion_examen_fisico_consulta");
           			var mostrarSeccion = false;
           			for (i = 0; i < data.response_data.length; i++){           		
           				var profesional = getProfesional(data.response_data[i].name);		           	
	           			var fecha = transformarFecha(data.response_data[i].created_at);
	           			if(data.response_data[i].descripcion.localeCompare("")!=0){
	           				mostrarSeccion = true;
	           				addText(profesional+" - "+fecha, data.response_data[i].descripcion, seccion_resumen);
	           			}
           			}
           			if(mostrarSeccion){
           				document.getElementById("seccion_examen_fisico_consulta").hidden = false;
           			}
            	} else {            		
            		document.getElementById("seccion_examen_fisico_consulta").hidden = true;
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

	function cargarExamenFisico(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;				
		var parcial = 1;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_examen_fisico_texto',
           data:{consulta:consulta, paciente:paciente, parcial:parcial,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){           		           		
           			document.getElementById("examen_fisico_detalles").value = data.response_data[0].descripcion;           		
            	} 
            }
        });	
	}
</script>