<form class="card background_panel" id="seccion_antecedentes_personales_nueva_consulta">		
	<br>
	<div id="seccion_antecedentes_personales">			
		<div class="row margin_left_5px">		
			<textarea disabled class="form-control" style="width:550px" id="antecedentes_personales_detalles" name="antecedentes_personales_detalles" rows="6" cols="100"></textarea>

			<textarea class="form-control margin_left_5px" style="width:550px" id="antecedentes_personales_detalles_nuevo" name="antecedentes_personales_detalles_nuevo" rows="6" cols="100" placeholder="Escriba aqui su nuevo antecedente"></textarea>	
		</div>
		<br>		
	</div>
</form>

<div class="margin_left_5px" id="seccion_antecedentes_personales_consulta" hidden>			
</div>


<script type="text/javascript">

	function guardarAntecedentesPersonales(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var descripcion = document.getElementById("antecedentes_personales_detalles_nuevo").value;
		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_antecedentes_personales',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			cargarAntecedentesPersonales();

            	} else {
            		mostrarSnackbar("ANTECEDENTES PERSONALES FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });		
	}

	function cargarAntecedentesPersonales(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;				
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_antecedentes',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){     

           		if(data.response_data != null && data.response == 1){           		          
           			var texto = "";
           			for (i = 0; i < data.response_data.length; i++){
           				if(data.response_data[i].antecedentes_personales.localeCompare("") != 0){
           					texto = texto + "["+ fechaMostrar(data.response_data[i].created_at) + " | "+data.response_data[i].name +"] - " + data.response_data[i].antecedentes_personales +"\n";
           				}
           			} 		
           			document.getElementById("antecedentes_personales_detalles").value = texto;
            	}
            }
        });	
	}

	function cargarAntecedentesPersonalesNuevo(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_antecedentes',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){           		          
           			var texto = "";
           			for (i = 0; i < data.response_data.length; i++){
           				if(data.response_data[i].antecedentes_personales.localeCompare("") != 0) {
           					if(data.response_data[i].consulta_id == consulta)
           					texto = data.response_data[i].antecedentes_personales;
           				}
           			} 		
           			document.getElementById("antecedentes_personales_detalles_nuevo").value = texto;
            	}
            }
        });	
	}

	function fechaMostrar(fecha){
		var fechaArray = fecha.split(" ");
		var fechaArray2 = fechaArray[0].split("-");
		return fechaArray2[2]+"/"+fechaArray2[1]+"/"+fechaArray2[0];
	}

</script>