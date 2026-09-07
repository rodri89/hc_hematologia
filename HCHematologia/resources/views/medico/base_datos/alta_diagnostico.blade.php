@extends('plantillas/plantilla_medico')

@section('title_header','Alta Diagnostico')

@section('contenedor')

@include('modal.snackbar')

<input hidden id="medico_id" name="medico_id" value="{{Auth::user()->id}}"/>			

<div id="seccion_buscar_paciente">
	<div class="row">
		<div class="col-md-3 text-center">          
			<h5 class="editText">Ingresar nuevo valor de diagnostico:</h5>		  		  
			<input type="text" name="valor_diagnostico" id="valor_diagnostico" class="form-control">
			<br>
			<button class="rodri_button" onclick="guardarNuevoDiagnostico()">Guardar</button>
		</div>
		<div class="col-md-1"></div>
		<div class="col-md-3 text-center">          
    <h5 class="editText">Listado de diagnósticos:</h5>		  		  
    
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>Diagnóstico</th>
        </tr>
      </thead>
      <tbody>
        @foreach($diagnosticos as $diagnostico)
          <tr>
            <td>{{ $diagnostico->nombre }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    
  </div>
	</div>
</div>


<script type="text/javascript">

function guardarNuevoDiagnostico() {
	var diagnostico = document.getElementById("valor_diagnostico").value;

	$.ajax({
		type: 'POST',
		dataType: 'JSON',
		url: '/guardar_nuevo_diagnostico',
		data: { diagnostico: diagnostico, _token: '{{csrf_token()}}' },
		success: function(data) {
			mostrarSnackbar("Nuevo diagnóstico guardado");

			// Limpiar el input
			document.getElementById("valor_diagnostico").value = "";

			// Agregar nuevo diagnóstico a la tabla
			var newRow = `<tr><td>${data.d.nombre}</td></tr>`;
			$('table tbody').append(newRow);
		}
	});
}


</script>
@endsection