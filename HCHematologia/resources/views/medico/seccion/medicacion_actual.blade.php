<div class="card background_panel_consulta_actual" id="seccion_medicacion_actual_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickMedicacionActual()" type="button">Medicacion Actual</a></b></h4>
	</div>	
	<div id="seccion_medicacion_actual" hidden>		
		<div class="row margin_left_5px">					
			<textarea class="form-control width650px_cel" id="medicacion_actual_detalles" name="medicacion_actual_detalles" rows="6" cols="100"></textarea>
		</div>
		<br>	
	</div>
</div>

<div id="seccion_medicacion_actual_consulta" class="margin_left_5px" hidden>		
	<h4><b>Medicacion Actual</b></h4><br>	
</div>

<script type="text/javascript">
	
	function clickMedicacionActual(){
		seccionPrincipal = document.getElementById("seccion_medicacion_actual");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	function guardarMedicacionActual(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var descripcion = document.getElementById("medicacion_actual_detalles").value;
		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_medicacion_actual',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			//alert("Guardado con exito actividades extra escolares");
            	} else {
            		mostrarSanckbar("MOTIVO CONSULTA FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });		
	}

	function cargarMedicacionActualConsulta(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		//borrarSeccion("seccion_motivo_consulta_consulta");
		document.getElementById("seccion_medicacion_actual_nueva_consulta").hidden = true;				
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_medicacion_actual',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){             	
           		if(data.response_data != null && data.response == 1){              		           		           			
           			document.getElementById("seccion_medicacion_actual_consulta").hidden = true;
           			var seccion_resumen = document.getElementById("seccion_medicacion_actual_consulta");
           			var mostrarSeccion = false;
           			
           			for (i = 0; i < data.response_data.length; i++){           				           	
           				var fecha = transformarFecha(data.response_data[i].created_at);           			
           				var profesional = getProfesional(data.response_data[i].name);		
           				if(data.response_data[i].descripcion.localeCompare("")!=0){
           					mostrarSeccion = true;
	           				addText(profesional+" - "+fecha, data.response_data[i].descripcion, seccion_resumen);
           				}
           			}
           			
           			if(mostrarSeccion)
           				document.getElementById("seccion_medicacion_actual_consulta").hidden = false;
            	} else {            		
            		document.getElementById("seccion_medicacion_actual_consulta").hidden = true;
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

	function cargarMedicacionActual(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
    	var parcial = 1;				
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_medicacion_actual',
           data:{consulta:consulta, paciente:paciente, parcial:parcial,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){           		           		
           			document.getElementById("medicacion_actual_detalles").value = data.response_data[0].descripcion;           		
            	} 
            }
        });	
	}

</script>