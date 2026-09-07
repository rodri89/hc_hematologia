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
<div id="seccion_p_control_mensual_m">
      @if($nueva_consulta != 0)
      <form class="card background_panel_consulta_actual" id="planilla_control_mensual_m">  
            <div class="row margin_left_5px">
                  <h4><b><a onclick="clickTrastornoHemorragiparo()" type="button">Trastorno Hemorragíparo</a></b></h4>
            </div>
      @else
        <form id="planilla_control_mensual_m">  
            <div class="row margin_left_5px">
                  <h4><b><a onclick="clickTrastornoHemorragiparo()" type="button">Trastorno Hemorragíparo</a></b></h4>
            </div>
      @endif      
            <div id="seccion_trastorno_hemorragiparo" hidden>         
                  
            <div class="table-responsive" style="height:500px; overflow-x: scroll;">
            @if($nueva_consulta != 0)
                  <small>Ultimo registro guardado: {{$trastorno_hemorragiparo_tabla_ultimo_registro}}</small>
            @endif
          <table class="table-condensed tabla_con_borde" id="tabla_trastorno_hemorragiparo" name="tabla_trastorno_hemorragiparo">
           <thead>        
              <tr>
                <th class="editText rodri_th" scope="col"></th>
                <!--<th class="editText rodri_th text_size"><input id="lgt_fecha" class="input_rodri" value="{{$date}}"></input></th>  -->
                @if($nueva_consulta != 0)
                  <th class="editText rodri_th text_size"><input type="text" class="form-control datepicker editText" name="th_fecha" id="th_fecha" value="{{str_replace('-','/',$date)}}" required autocomplete="off"></th>
                @endif
                
                @for($j=0; $j < ($trastorno_hemorragiparo_tabla_tope); $j++)          
                  <?php $fecha_aux =  explode('-',$trastorno_hemorragiparo_tabla_fechas[$j+1]); 
                        $_fecha = $fecha_aux[2].'/'.$fecha_aux[1].'/'.$fecha_aux[0];?>
                  <th class="editText rodri_th text_size">{{$_fecha}}</th>  
                @endfor                  
              </tr>
            </thead>
            <tbody id="trastorno_hemorragiparo_list" name="trastorno_hemorragiparo_list">
                  <?php $i = 0 ?>
                  @while($i < count($trastorno_hemorragiparo_tabla))                  
                        <tr>  
                              <td class="rodri_th">{{$trastorno_hemorragiparo_tabla[$i]}}</td>
                              @if($nueva_consulta != 0)
                                    <td><input class="input_rodri" id="th_{{$trastorno_hemorragiparo_tabla[$i]}}"></input></td>
                              @endif

                              @for($j=0; $j < ($trastorno_hemorragiparo_tabla_tope); $j++)
                                    @if(($i+1) < count($trastorno_hemorragiparo_tabla))
                                          <td><input tabindex="-1" readonly class="input_rodri" value="{{$trastorno_hemorragiparo_tabla[++$i]}}"></input></td>
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
                <button hidden type="button" id="nuevoTrastornoHemorragiparo" onclick="nuevoTrastornoHemorragiparo()" class="rodri_button_aceptar">NUEVO</button>        

                <button type="button" id="guardarDatosTrastornoHemorragiparo" onclick="guardarTrastornoHemorragiparo()" class="rodri_button_aceptar">GUARDAR</button>        
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
      
    function clickTrastornoHemorragiparo(){
		seccionPrincipal = document.getElementById("seccion_trastorno_hemorragiparo");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}


      function guardarTrastornoHemorragiparo(){      
            var consulta = document.getElementById("consulta_id").value;
            var paciente = document.getElementById("paciente_id").value;
            
            var fecha = document.getElementById("th_fecha").value;
            var plaquetas = document.getElementById("th_Plaquetas (/mm3)").value;
            var tp = document.getElementById("th_TP (seg/%)").value;
            var rin = document.getElementById("th_RIN").value;
            var aptt = document.getElementById("th_APTT (seg)").value;
            var factor_v = document.getElementById("th_Factor V").value;
            var fibrinogeno = document.getElementById("th_Fibrinogeno").value;
            var tt = document.getElementById("th_TT (seg)").value;
            var ts = document.getElementById("th_TS (min)").value;
            var retraccion_del_coagulo = document.getElementById("th_Retracción del coagulo").value;
            var factor_vw = document.getElementById("th_Factor de VW (Ag)").value;
            var coafactor = document.getElementById("th_Cofactor de Ristocetina").value;
            var tp_correccion = document.getElementById("th_TP Correccion").value;
            var aptt_correccion = document.getElementById("th_APTT Correccion").value;
            var factor_ii = document.getElementById("th_Factor II").value;
            var factor_vii = document.getElementById("th_Factor VII").value;
            var factor_viii = document.getElementById("th_Factor VIII").value;
            var factor_ix = document.getElementById("th_Factor IX").value;
            var factor_x = document.getElementById("th_Factor X").value;
            var inh_viii = document.getElementById("th_Inh. VIII").value;
            var inh_ix = document.getElementById("th_Inh. IX").value;
            
            guardarParcial();
            
            mostrarSnackbar('Guardando...');
            var botonGuardar = document.getElementById("guardarDatosTrastornoHemorragiparo");
            botonGuardar.disabled = true;
            botonGuardar.setAttribute('class', 'rodri_button_disabled');

            $.ajax({
                 type:'POST',
                 dataType:'JSON',
                 url:'/guardar_trastorno_hemorragiparo',
                 data:{consulta:consulta, paciente:paciente, fecha:fecha, plaquetas:plaquetas, tp:tp, rin:rin, aptt:aptt, factor_v:factor_v, fibrinogeno:fibrinogeno, tt:tt, ts:ts, retraccion_del_coagulo:retraccion_del_coagulo, factor_vw:factor_vw, coafactor:coafactor, tp_correccion:tp_correccion, aptt_correccion:aptt_correccion, factor_ii:factor_ii, factor_vii:factor_vii, factor_viii:factor_viii, factor_ix:factor_ix, factor_x:factor_x, inh_viii:inh_viii, inh_ix:inh_ix, _token: '{{csrf_token()}}'},
                  success:function(data) {                  
                        //alert("Laboratorio Guardado");
                        mostrarSnackbar('Trastorno Hemorragíparo Guardado');
                        nuevoTrastornoHemorragiparo();
                  }
              });       
      }


      function nuevoTrastornoHemorragiparo(){
            location.reload();
      }

</script>
