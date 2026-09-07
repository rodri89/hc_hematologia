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
<div id="seccion_tromb">
      @if($nueva_consulta != 0)
      <form class="card background_panel_consulta_actual" id="trombofilia">  
            <div class="row margin_left_5px">
                  <h4><b><a onclick="clickTrombofilia()" type="button">Trombofilia</a></b></h4>
            </div>
      @else
        <form id="trombofilia">  
            <div class="row margin_left_5px">
                  <h4><b><a onclick="clickTrombofilia()" type="button">Trombofilia</a></b></h4>
            </div>
      @endif      
            <div id="seccion_trombofilia" hidden>         
                  
            <div class="table-responsive" style="height:500px; overflow-x: scroll;">
          @if($nueva_consulta != 0)
            <small>Ultimo registro guardado: {{$trombofilia_tabla_ultimo_registro}}</small>
          @endif
          <table class="table-condensed tabla_con_borde" id="tabla_trombofilia" name="tabla_trombofilia">
           <thead>        
              <tr>
                <th class="editText rodri_th" scope="col"></th>
                <!--<th class="editText rodri_th text_size"><input id="lgt_fecha" class="input_rodri" value="{{$date}}"></input></th>  -->
                @if($nueva_consulta != 0)
                  <th class="editText rodri_th text_size"><input type="text" class="form-control datepicker editText" name="t_fecha" id="t_fecha" value="{{str_replace('-','/',$date)}}" required autocomplete="off"></th>
                @endif
                
                @for($j=0; $j < ($trombofilia_tabla_tope); $j++)          
                  <?php $fecha_aux =  explode('-',$trombofilia_tabla_fechas[$j+1]); 
                        $_fecha = $fecha_aux[2].'/'.$fecha_aux[1].'/'.$fecha_aux[0];?>
                  <th class="editText rodri_th text_size">{{$_fecha}}</th>  
                @endfor                  
              </tr>
            </thead>
            <tbody id="trombofilia_list" name="trombofilia_list">
                  <?php $i = 0 ?>
                  @while($i < count($trombofilia_tabla))                  
                        <tr>  
                              <td class="rodri_th">{{$trombofilia_tabla[$i]}}</td>
                              @if($nueva_consulta != 0)
                                    <td><input class="input_rodri" id="t_{{$trombofilia_tabla[$i]}}"></input></td>
                              @endif

                              @for($j=0; $j < ($trombofilia_tabla_tope); $j++)
                                    @if(($i+1) < count($trombofilia_tabla))
                                          <td><input tabindex="-1" readonly class="input_rodri" value="{{$trombofilia_tabla[++$i]}}"></input></td>
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
                <button hidden type="button" id="nuevoTrombofilia" onclick="nuevoTrombofilia()" class="rodri_button_aceptar">NUEVO</button>        

                <button type="button" id="guardarDatosTrombofilia" onclick="guardarTrombofilia()" class="rodri_button_aceptar">GUARDAR</button>        
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
      
    function clickTrombofilia(){
		seccionPrincipal = document.getElementById("seccion_trombofilia");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}


      function guardarTrombofilia(){      
            var consulta = document.getElementById("consulta_id").value;
            var paciente = document.getElementById("paciente_id").value;
            
            var fecha = document.getElementById("t_fecha").value;
            var tp = document.getElementById("t_TP (seg/%)").value;
            var rin = document.getElementById("t_RIN").value;
            var aptt = document.getElementById("t_APTT (seg)").value;
            var tt = document.getElementById("t_TT (seg)").value;
            var ts = document.getElementById("t_TS (min)").value;
            var f_viii = document.getElementById("t_F VIII").value;
            var pc = document.getElementById("t_PC").value;
            var ps = document.getElementById("t_PS").value;
            var rpca = document.getElementById("t_RPCA").value;
            var ac_anti_b2_gp_igg = document.getElementById("t_Ac Anti B2 GP IgG").value;
            var ac_anti_b2_gp_igm = document.getElementById("t_Ac Anti B2 GP IgM").value;
            var ac_anti_cardiolipina_igg = document.getElementById("t_Ac Anti Cardiolipina IgG").value;
            var ac_anti_cardiolipina_igm = document.getElementById("t_Ac Anti Cardiolipina IgM").value;
            var anticoagulante_lupico = document.getElementById("t_Anticoagulante Lupico").value;
            var mutacion_fv_leiden = document.getElementById("t_Mutacion FV Leiden").value;
            var mutacion_pt_20210 = document.getElementById("t_Mutacion PT 20210").value;
            var homocisteinemia = document.getElementById("t_Homocisteinemia").value;
            var antitrombina = document.getElementById("t_Antitrombina III").value;
            
            guardarParcial();
            
            mostrarSnackbar('Guardando...');
            var botonGuardar = document.getElementById("guardarDatosTrombofilia");
            botonGuardar.disabled = true;
            botonGuardar.setAttribute('class', 'rodri_button_disabled');

            $.ajax({
                 type:'POST',
                 dataType:'JSON',
                 url:'/guardar_trombofilia',
                 data:{consulta:consulta, paciente:paciente, fecha:fecha, tp:tp, rin:rin, aptt:aptt,tt:tt, ts:ts, f_viii:f_viii, pc:pc, ps:ps, rpca:rpca, ac_anti_b2_gp_igg:ac_anti_b2_gp_igg, ac_anti_b2_gp_igm:ac_anti_b2_gp_igm, ac_anti_cardiolipina_igg:ac_anti_cardiolipina_igg, ac_anti_cardiolipina_igm:ac_anti_cardiolipina_igm, anticoagulante_lupico:anticoagulante_lupico, mutacion_fv_leiden:mutacion_fv_leiden, mutacion_pt_20210:mutacion_pt_20210, homocisteinemia:homocisteinemia, antitrombina:antitrombina, _token: '{{csrf_token()}}'},
                  success:function(data) {                  
                        //alert("Laboratorio Guardado");
                        mostrarSnackbar('Trombofilia Guardado');
                        nuevoTrombofilia();
                  }
              });       
      }


      function nuevoTrombofilia(){
            location.reload();
      }

</script>
