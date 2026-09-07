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

@if($nueva_consulta != 0)
<form class="card background_panel_consulta_actual">  
      <div class="row margin_left_5px">
            <h4><b><a onclick="clickPlanillaControlMensualMielodisplasia()" type="button">Planilla Control Mensual Mielodisplasia</a></b></h4>
      </div>
@else
  <form id="planilla_control_mensual_m">  
      <div class="row margin_left_5px">
            <h4><b><a onclick="clickPlanillaControlMensualMielodisplasia()" type="button">Planilla Control Mensual Mielodisplasia</a></b></h4>
      </div>
@endif      
      <div id="seccion_planilla_control_mensual_mielodisplasia" hidden>         
            
      <div class="table-responsive" style="height:700px; overflow-x: scroll;">

    <table class="table-condensed tabla_con_borde" id="tabla_planilla_control_mm" name="tabla_planilla_control_mm">
     <thead>        
        <tr>
          <th class="editText rodri_th" scope="col"></th>
          <!--<th class="editText rodri_th text_size"><input id="lgt_fecha" class="input_rodri" value="{{$date}}"></input></th>  -->
          @if($nueva_consulta != 0)
            <th class="editText rodri_th text_size"><input type="text" class="form-control datepicker editText" name="pcmm_fecha" id="pcmm_fecha" value="{{str_replace('-','/',$date)}}" required autocomplete="off"></th>
          @endif
          
          @for($j=0; $j < ($planilla_control_mm_tabla_tope); $j++)          
            <?php $fecha_aux =  explode('-',$planilla_control_mm_tabla_fechas[$j+1]); 
                  $_fecha = $fecha_aux[2].'/'.$fecha_aux[1].'/'.$fecha_aux[0];?>
            <th class="editText rodri_th text_size">{{$_fecha}}</th>  
          @endfor                  
        </tr>
      </thead>
      <tbody id="pacientes-list" name="pacientes-list">
            <?php $i = 0 ?>
            @while($i < count($planilla_control_mm_tabla))                  
                  <tr>  
                        <td class="rodri_th">{{$planilla_control_mm_tabla[$i]}}</td>
                        @if($nueva_consulta != 0)
                              <td><input class="input_rodri" id="pcmm_{{$planilla_control_mm_tabla[$i]}}"></input></td>
                        @endif

                        @for($j=0; $j < ($planilla_control_mm_tabla_tope); $j++)
                              @if(($i+1) < count($planilla_control_mm_tabla))
                                    <td><input tabindex="-1" readonly class="input_rodri" value="{{$planilla_control_mm_tabla[++$i]}}"></input></td>
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
          <button type="button" id="nuevoPlanillaControlMM" onclick="nuevoPlanillaControlMM()" class="rodri_button_aceptar">NUEVO</button>        

          <button type="button" id="guardarDatosPlanillaControlMM" onclick="guardarPlanillaControlMM()" class="rodri_button_aceptar">GUARDAR</button>        
        </div>
      </div>
      @endif

      </div>

</form>

<script type="text/javascript">

      $('.datepicker').datepicker({
          weekStart: 0,
          language: "es",
          //startDate: '-3d',
          keyboardNavigation: false,
          forceParse: false,
          autoclose: true,          
        }).attr('readonly','readonly');
      
    function clickPlanillaControlMensualMielodisplasia(){
		seccionPrincipal = document.getElementById("seccion_planilla_control_mensual_mielodisplasia");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}


      function guardarPlanillaControlMM(){      
            var consulta = document.getElementById("consulta_id").value;
            var paciente = document.getElementById("paciente_id").value;
            
            var fecha = document.getElementById("pcmm_fecha").value;
            var hto_hb = document.getElementById("pcmm_Hto/Hb").value;
            var vcm = document.getElementById("pcmm_VCM").value;
            var gb_pmn = document.getElementById("pcmm_GB/PMN").value;
            var plaquetas = document.getElementById("pcmm_Plaquetas").value;
            var ldh = document.getElementById("pcmm_LDH").value;
            var ferremia = document.getElementById("pcmm_Ferremia").value;
            var ferritina = document.getElementById("pcmm_Ferritina").value;
            var transferrina = document.getElementById("pcmm_Transferrina").value;
            var sat_transf = document.getElementById("pcmm_Sat. Transf.").value;
            var n_ugr = document.getElementById("pcmm_NºUGR").value;
            var p_coombs_d = document.getElementById("pcmm_P. Coombs D").value;
            var n_unidades_pqt = document.getElementById("pcmm_Nº Unidades PQT").value;
            var dosaje_epo = document.getElementById("pcmm_Dosaje EPO").value;
            var epo_ui_sem = document.getElementById("pcmm_EPO (ui/sem)").value;
            var ahm_dosis_diaria = document.getElementById("pcmm_AHM (dosis diaria)").value;
            var g_csf_dosis_semanal = document.getElementById("pcmm_G - CSF (dosis semanal)").value;
            var agonistas_trombopoy = document.getElementById("pcmm_Agonistas Trombopoy").value;
            
            
            $.ajax({
                 type:'POST',
                 dataType:'JSON',
                 url:'/guardar_planilla_control_mm',
                 data:{consulta:consulta, paciente:paciente, fecha:fecha, hto_hb:hto_hb, vcm:vcm, gb_pmn:gb_pmn, plaquetas:plaquetas, ldh:ldh, ferremia:ferremia, ferritina:ferritina, transferrina:transferrina, sat_transf:sat_transf, n_ugr:n_ugr, p_coombs_d:p_coombs_d, n_unidades_pqt:n_unidades_pqt, dosaje_epo:dosaje_epo, epo_ui_sem:epo_ui_sem, ahm_dosis_diaria:ahm_dosis_diaria, g_csf_dosis_semanal:g_csf_dosis_semanal, agonistas_trombopoy:agonistas_trombopoy, _token: '{{csrf_token()}}'},
                  success:function(data) {                  
                        //alert("Laboratorio Guardado");
                        mostrarSnackbar('Planilla Control Guardada');
                  }
              });       
      }


      function nuevoPlanillaControlMM(){
            location.reload();
      }

</script>
