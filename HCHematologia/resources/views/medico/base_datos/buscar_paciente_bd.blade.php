@extends('plantillas/plantilla_medico')

@section('title_header','Buscar Paciente')

@section('contenedor')

@include('modal.snackbar')

<head>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/jquery.min.js')}}"> </script>
</head>

<input hidden id="medico_id" name="medico_id" value="{{Auth::user()->id}}"/>

<h2 hidden> Pacientes:</h2>
 <div id="seccion_buscar_paciente_listado_bd" class="container">
  <div class="table-responsive" style="height:700px; overflow-y: scroll;">
  <table class="table table-striped" id="laravel_datatable"> 
               <thead class="fondoNav text-white">
                  <tr>                    
                    <th class="editText">Diagnostico</th>
                    <th class="editText">Apellido</th>
                    <th class="editText">Nombre</th>
                    <th class="editText">DNI</th>
                    <th class="editText">Localidad</th>                                      
                    <th class="editText">Obra Social</th>                               
                    <th class="editText">Seleccionar</th> 
                  </tr>
               </thead>
            </table>
         </div>
      </div>
   <script>
   
   $(document).ready( function () {
    $('#laravel_datatable').DataTable({
           language: {
              "decimal": "",
              "emptyTable": "No hay información",
              "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
              "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
              "infoFiltered": "(Filtrado de _MAX_ total entradas)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar _MENU_ Entradas",
              "loadingRecords": "Cargando...",
              "processing": "Procesando...",
              "search": "Buscar:",
              "zeroRecords": "Sin resultados encontrados",
              "paginate": {
                  "first": "Primero",
                  "last": "Ultimo",
                  "next": "Siguiente",
                  "previous": "Anterior"
              },
           },
           processing: false,
           serverSide: false,
           ajax: "{{ url('pacientes_listado_buscar_bd') }}",
           columns: [
                    { data: 'diagnostico', name: 'diagnostico' },
                    { data: 'apellido', name: 'apellido' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'dni', name: 'dni' },
                    { data: 'localidad', name: 'localidad' },                                       
                    { data: 'obra_social', name: 'obra_social', orderable: true, searchable: true},                    
                    { data: 'seleccionar', name: 'seleccionar', orderable: false, searchable: false}
                    // { data: 'action', name: 'action', orderable: false, searchable: false}                                       
                 ]
        });
     });
    
  </script>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function seleccionarPaciente(id) {
      var medico_id = document.getElementById("medico_id").value;
      document.getElementById("paciente_seleccionado_id").value = id;
      
      mostrarPanelPaciente(true);
      mostrarPanelHistoriaClinica(false);
      $.ajax({
         type:'POST',
         dataType:'JSON',
         url:'/get_paciente_id',
         data:{paciente_id :id, medico_id:medico_id,_token: '{{csrf_token()}}'},
         success:function(data) {               
            mostrarSnackbar('Paciente Seleccionado');
            document.getElementById('seccion_buscar_paciente_listado_bd').hidden = true;
            document.getElementById("static_header").innerHTML = data.paciente.apellido+", "+data.paciente.nombre;
         }
      });
  }

  function verComentario(turnoRegistradoId){
       $.ajax({
         type:'POST',
         dataType:'JSON',
         url:'/get_turno_registrado_id',
         data:{turnoRegistradoId: turnoRegistradoId, _token: '{{csrf_token()}}'},
         success:function(data){   
            var titulo = document.getElementById('modalMensajeTitulo');
            var texto = document.getElementById('modalMensajeTexto');       
            titulo.innerHTML = "";
            texto.innerHTML = "";
            if(data.turno != null){              
              titulo.innerHTML = "Detalles";
              var fecha_aux = data.turno.updated_at.split(" "); //2021-04-12
              var fecha_aux_2 = fecha_aux[0].split("-");
              var fecha = fecha_aux_2[2]+"/"+fecha_aux_2[1]+"/"+fecha_aux_2[0];
              texto.innerHTML = data.turno.comentario+" el dia "+fecha+".";
              $('#modalMensaje').modal();
            }
         }
      });
  }

</script>

@endsection