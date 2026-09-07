@if($nueva_consulta == 0)
	<form id="seccion_diagnostico_nueva_consulta">	
@else
	<form class="card background_panel_consulta_actual" id="seccion_diagnostico_nueva_consulta">		
@endif
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickDiagnostico()" type="button">Diagnostico</a></b></h4>
	</div>	
@if($nueva_consulta == 0)
	<div id="seccion_diagnostico">		
@else
	<div id="seccion_diagnostico" hidden>		
@endif
		
		<div class="row margin_left_5px">		
			<div id="contenedorDiagnosticos">
			  <!-- Aquí se insertarán los checkboxes -->
			</div>			
		</div>
		<br>		
	</div>
</form>

<script type="text/javascript">
	
	function clickDiagnostico() {
		//cargarListadoDiagnostico();
		seccionPrincipal = document.getElementById("seccion_diagnostico");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	function cargarListadoDiagnostico() {		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_listado_diagnostico',
           data:{_token: '{{csrf_token()}}'},
           	success:function(data){              
           		console.log("listado diagnosticos");
       			const contenedor = document.getElementById('contenedorDiagnosticos');
				contenedor.innerHTML = ''; // Limpiar contenido anterior

			  	data.diagnosticos.forEach(diagnostico => {
			    const div = document.createElement('div');
			    div.classList.add('form-check');

			    div.innerHTML = `
			      <input class="form-check-input" type="checkbox" value="${diagnostico.id}" id="diag_${diagnostico.id}">
			      <label class="form-check-label" for="diag_${diagnostico.id}">
			        ${diagnostico.nombre}
			      </label>
			    `;

			    contenedor.appendChild(div);
			  });            	 
            }
        });		
	}

	function guardarDiagnostico() {
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

		const checkboxes = document.querySelectorAll('#contenedorDiagnosticos input[type="checkbox"]:checked');
	  	const seleccionados = Array.from(checkboxes).map(cb => cb.value);
		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_diagnosticos',
           data:{consulta:consulta, paciente:paciente, diagnosticos:seleccionados ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			//alert("Guardado con exito actividades extra escolares");
           			console.log("Diagnostico Guardados")
            	} else {
            		mostrarSanckbar("DIAGNOSTICO FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });		
	}

	function cargarDiagnosticoConsulta() {
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		
		$.ajax({
	       type: 'POST',
	       dataType: 'JSON',
	       url: '/cargar_diagnosticos',
	       data: { consulta: consulta, paciente: paciente, _token: '{{csrf_token()}}' },
	       	success: function(data) {
	       		if (data.diagnosticosListado && data.diagnosticosListado.length > 0) {
	       			const contenedor = document.getElementById('contenedorDiagnosticos');
					contenedor.innerHTML = '';

					// Extraer SOLO los IDs
					const diagnosticosSeleccionados = (data.diagnosticos || []).map(d => String(d.id));

				  	data.diagnosticosListado.forEach(diagnostico => {
					    const div = document.createElement('div');
					    div.classList.add('form-check');

					    const checked = diagnosticosSeleccionados.includes(String(diagnostico.id)) ? 'checked' : '';

					    div.innerHTML = `
					      <input class="form-check-input" type="checkbox" value="${diagnostico.id}" id="diag_${diagnostico.id}" ${checked}>
					      <label class="form-check-label" for="diag_${diagnostico.id}">
					        ${diagnostico.nombre}
					      </label>
					    `;

					    contenedor.appendChild(div);           		
	            	});
	        	} else {
	        		document.getElementById("seccion_diagnostico_consulta").hidden = true;
	        	}
	        }
	    });	
	}



	function cargarDiagnostico() {
	    var consulta = document.getElementById("consulta_id").value;
	    var paciente = document.getElementById("paciente_id").value;                
	    $.ajax({
	       type:'POST',
	       dataType:'JSON',
	       url:'/cargar_diagnosticos',
	       data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
	        success:function(data){                         
	            console.log("cargar diagnosticos", data);
	            if(data.diagnosticos != null) {
	                let asignados = data.diagnosticos; // acá accedo al array correcto

	                $('.form-check-input').prop('checked', false); // desmarco todo

	                asignados.forEach(function(diag) {
	                    $('#diag_' + diag.id).prop('checked', true);
	                });
	            } 
	        }
	    }); 
	}


</script>