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
      table td:first-child {        
        font-size: 1.2rem;
        width: 180px;
      }

      table td: {        
        font-size: 1.2rem;
        width: 100px;
      }

      .text_size{
            width: 80px;
            font-size: 1.0rem;
      }

      .input_rodri{
      font-size: 1.0rem;
       width: 110px;     
      }

</style>
<div id="seccion_c_anticoagulacion">
      @if($nueva_consulta != 0)
      <form class="card background_panel_consulta_actual" id="control_anticoagulacion">  
            <div class="row margin_left_5px">
                  <h4><b><a onclick="clickControlAnticoagulacion()" type="button">Control Anticoagulacion</a></b></h4>
            </div>
      @else
        <form id="control_anticoagulacion">  
            <div class="row margin_left_5px">
                  <h4><b><a onclick="clickControlAnticoagulacion()" type="button">Control Anticoagulacion</a></b></h4>
            </div>
      @endif      
            <div id="seccion_control_anticoagulacion" hidden>         
                  
            <div class="table-responsive" style="height:180px; overflow-x: scroll;">
          @if($nueva_consulta != 0)
            <small>Ultimo registro guardado: {{$control_anticoagulacion_tabla_ultimo_registro}}</small>
          @endif
          <table class="table-condensed tabla_con_borde" id="tabla_contro_anticoagulacion" name="tabla_contro_anticoagulacion">
           <thead>        
              <tr>
                <th class="editText rodri_th" scope="col"></th>
                <!--<th class="editText rodri_th text_size"><input id="lgt_fecha" class="input_rodri" value="{{$date}}"></input></th>  -->
                @if($nueva_consulta != 0)
                  <th class="editText rodri_th text_size"><input type="text" class="form-control datepicker editText" name="ca_fecha" id="ca_fecha" value="{{str_replace('-','/',$date)}}" required autocomplete="off"></th>
                @endif
                
                @for($j=0; $j < ($control_anticoagulacion_tabla_tope); $j++)          
                  <?php $fecha_aux =  explode('-',$control_anticoagulacion_tabla_fechas[$j+1]); 
                        $_fecha = $fecha_aux[2].'/'.$fecha_aux[1].'/'.$fecha_aux[0];?>
                  <th class="editText rodri_th text_size">{{$_fecha}}</th>  
                @endfor                  
              </tr>
            </thead>
            <tbody id="control_anticoagulacion_list" name="control_anticoagulacion_list">
                  <?php $i = 0 ?>
                  @while($i < count($control_anticoagulacion_tabla))                  
                        <tr>  
                              <td class="rodri_th">{{$control_anticoagulacion_tabla[$i]}}</td>
                              @if($nueva_consulta != 0)
                                    <td><input class="input_rodri" id="ca_{{$control_anticoagulacion_tabla[$i]}}"></input></td>
                              @endif

                              @for($j=0; $j < ($control_anticoagulacion_tabla_tope); $j++)
                                    @if(($i+1) < count($control_anticoagulacion_tabla))
                                          <td><input tabindex="-1" readonly class="input_rodri" value="{{$control_anticoagulacion_tabla[++$i]}}"></input></td>
                                    @else
                                          <?php $i++;?>
                                    @endif
                              @endfor                        
                              <?php $i++;?>
                        </tr>                  
                  @endwhile           
            </tbody>
            </table>      
            </div>
            <br>
            
            @if($nueva_consulta != 0)
            <div class="row contenedor3">
              <div class="contenido3">
                <button hidden type="button" id="nuevoControlAnticoagulacion" onclick="nuevoControlAnticoagulacion()" class="rodri_button_aceptar">NUEVO</button>        

                <button type="button" id="guardarDatosControlAnticoagulacion" onclick="guardarControlAnticoagulacion()" class="rodri_button_aceptar">GUARDAR</button>        
              </div>
            </div>
            @endif

            </div>
      </form>
</div>

<script type="text/javascript">

      $('.datepicker').datepicker({
          weekStart: 0,
          language: "es",
          //startDate: '-3d',
          keyboardNavigation: false,
          forceParse: false,
          autoclose: true,          
        }).attr('readonly','readonly');
      
    function clickControlAnticoagulacion(){
		seccionPrincipal = document.getElementById("seccion_control_anticoagulacion");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}


      function guardarControlAnticoagulacion(){      
            var consulta = document.getElementById("consulta_id").value;
            var paciente = document.getElementById("paciente_id").value;
            
            var fecha = document.getElementById("ca_fecha").value;
            var tp = document.getElementById("ca_TP(seg%)").value;
            var rin = document.getElementById("ca_RIN").value;
            var aptt = document.getElementById("ca_APTT (seg)").value;            
            
            guardarParcial();
            
            mostrarSnackbar('Guardando...');
            var botonGuardar = document.getElementById("guardarDatosControlAnticoagulacion");
            botonGuardar.disabled = true;
            botonGuardar.setAttribute('class', 'rodri_button_disabled');

            $.ajax({
                 type:'POST',
                 dataType:'JSON',
                 url:'/guardar_control_anticoagulacion',
                 data:{consulta:consulta, paciente:paciente, fecha:fecha, tp:tp, rin:rin, aptt:aptt, _token: '{{csrf_token()}}'},
                  success:function(data) {                  
                        //alert("Laboratorio Guardado");
                        mostrarSnackbar('Control Anticoagulacion Guardado');
                        nuevoControlAnticoagulacion();
                  }
              });       
      }


      function nuevoControlAnticoagulacion(){
            location.reload();
      }

</script>
