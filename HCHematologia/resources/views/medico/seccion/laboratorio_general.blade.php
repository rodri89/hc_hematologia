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
<div id="seccion_lab_general">
      @if($nueva_consulta != 0)
      <form class="card background_panel_consulta_actual" id="laboratorio_general">  
            <div class="row margin_left_5px">
                  <h4><b><a onclick="clickLaboratorioGeneral()" type="button">Laboratorio General</a></b></h4>
            </div>
      @else
        <form id="laboratorio_general">  
            <div class="row margin_left_5px">
                  <h4><b><a onclick="clickLaboratorioGeneral()" type="button">Laboratorio General</a></b></h4>
            </div>
      @endif      
            <div id="seccion_laboratorio_general" hidden>         
                  
            <div class="table-responsive" style="height:500px; overflow-x: scroll;">
            @if($nueva_consulta != 0)
            <small>Ultimo registro guardado: {{$laboratorio_general_tabla_ultimo_registro}}</small>
            @endif
          <table class="table-condensed tabla_con_borde" id="tabla_laboratorio_general" name="tabla_laboratorio_general">
           <thead>        
              <tr>
                <th class="editText rodri_th" scope="col"></th>
                <!--<th class="editText rodri_th text_size"><input id="lgt_fecha" class="input_rodri" value="{{$date}}"></input></th>  -->
                @if($nueva_consulta != 0)
                  <th class="editText rodri_th text_size"><input type="text" class="form-control datepicker editText" name="lg_fecha" id="lg_fecha" value="{{str_replace('-','/',$date)}}" required autocomplete="off"></th>
                @endif
                
                @for($j=0; $j < ($laboratorio_general_tabla_tope); $j++)          
                  <?php $fecha_aux =  explode('-',$laboratorio_general_tabla_fechas[$j+1]); 
                        $_fecha = $fecha_aux[2].'/'.$fecha_aux[1].'/'.$fecha_aux[0];?>
                  <th class="editText rodri_th text_size">{{$_fecha}}</th>  
                @endfor                  
              </tr>
            </thead>
            <tbody id="laboratorio_general_list" name="laboratorio_general_list">
                  <?php $i = 0 ?>
                  @while($i < count($laboratorio_general_tabla))                  
                        <tr>  
                              <td class="rodri_th">{{$laboratorio_general_tabla[$i]}}</td>
                              @if($nueva_consulta != 0)
                                    <td><input class="input_rodri" id="lg_{{$laboratorio_general_tabla[$i]}}"></input></td>
                              @endif

                              @for($j=0; $j < ($laboratorio_general_tabla_tope); $j++)
                                    @if(($i+1) < count($laboratorio_general_tabla))
                                          <td><input tabindex="-1" readonly class="input_rodri" value="{{$laboratorio_general_tabla[++$i]}}"></input></td>
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
                <button hidden type="button" id="nuevoLaboratorioGeneral" onclick="nuevoLaboratorioGeneral()" class="rodri_button_aceptar">NUEVO</button>        

                <button type="button" id="guardarDatosLaboratorioGeneral" onclick="guardarLaboratorioGeneral()" class="rodri_button_aceptar">GUARDAR</button>        
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
      
    function clickLaboratorioGeneral(){
		seccionPrincipal = document.getElementById("seccion_laboratorio_general");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

      function guardarLaboratorioGeneral(){      
            var consulta = document.getElementById("consulta_id").value;
            var paciente = document.getElementById("paciente_id").value;
            
            var fecha = document.getElementById("lg_fecha").value;
            var hb = document.getElementById("lg_Hb (g/dL)").value;
            var hto = document.getElementById("lg_Hto (%)").value;
            var vcm = document.getElementById("lg_VCM (fl)").value;
            var rto = document.getElementById("lg_Rto GR (/mm3)").value;
            var hcm = document.getElementById("lg_HCM (pg)").value;
            var chcm = document.getElementById("lg_CHCM (g/dL)").value;
            var fsp = document.getElementById("lg_FSP").value;
            var gb = document.getElementById("lg_GB (/mm3)").value;
            var pqt = document.getElementById("lg_Pqt (/mm3)").value;
            var ldh = document.getElementById("lg_LDH (U/L)").value;
            var ers = document.getElementById("lg_ERS (mmh)").value;
            var b2 = document.getElementById("lg_B2 microglob").value;
            var urea = document.getElementById("lg_Urea (mg/dL)").value;
            var creatinina = document.getElementById("lg_Creatinina (mg/dL)").value;
            var tgo = document.getElementById("lg_TGO (U/L)").value;
            var tgp = document.getElementById("lg_TGP (U/L)").value;
            var fal = document.getElementById("lg_FAL (U/L)").value;
            var bb = document.getElementById("lg_Bb total (mg/dL)").value;
            var ferremia = document.getElementById("lg_Ferremia (mcg/dL)").value;
            var transferrina = document.getElementById("lg_Transferrina (mg/dL)").value;
            var sat_transferrina = document.getElementById("lg_Sat Transferrina (%)").value;
            var tibc = document.getElementById("lg_TIBC (mcg/dL)").value;
            var ferritina = document.getElementById("lg_Ferritina (ng/mL)").value;
            var vit_b12 = document.getElementById("lg_Vit B12 (pg/mL)").value;
            var folato = document.getElementById("lg_Folato (ng/mL)").value;
            var prot_totales = document.getElementById("lg_Prot Totales (g/dL)").value;
            var albumina = document.getElementById("lg_Albumina (g/dL)").value;
            var alfa = document.getElementById("lg_Alfa (g/dL)").value;
            var beta = document.getElementById("lg_Beta (g/dL)").value;
            var gamma = document.getElementById("lg_Gamma (g/dL)").value;
            var pico_monotonas = document.getElementById("lg_Pico Monoclonal (g/dL)").value;
            var lg_g = document.getElementById("lg_Ig G").value;
            var lg_a = document.getElementById("lg_Ig A").value;
            var lg_m = document.getElementById("lg_Ig M").value;
            var lg_e = document.getElementById("lg_Ig E").value;
            var lg_d = document.getElementById("lg_Ig D").value;
            var interpretacion = document.getElementById("lg_Interpretacion").value;
            var inmufijacion = document.getElementById("lg_Inmunofijacion").value;
            var cll = document.getElementById("lg_CLL").value;
            var kappa = document.getElementById("lg_Kappa").value;
            var lambda = document.getElementById("lg_Lambda").value;
            var calcio = document.getElementById("lg_Calcio (mg/dL)").value;
            var fosforo = document.getElementById("lg_Fosforo (mg/dL)").value;
            var proteinuria = document.getElementById("lg_Proteinuria (gr/24hs)").value;
            var tp_seg = document.getElementById("lg_TP (seg/%)").value;
            var rin = document.getElementById("lg_RIN").value;
            var aptt = document.getElementById("lg_APTT (seg)").value;
            var glucemia = document.getElementById("lg_Glucemia").value;
            
            guardarParcial();

            mostrarSnackbar('Guardando...');
            var botonGuardar = document.getElementById("guardarDatosLaboratorioGeneral");
            botonGuardar.disabled = true;
            botonGuardar.setAttribute('class', 'rodri_button_disabled');
                
            $.ajax({
                 type:'POST',
                 dataType:'JSON',
                 url:'/guardar_laboratorio_general',
                 data:{consulta:consulta, paciente:paciente, fecha:fecha, hb:hb, hto:hto, vcm:vcm, rto:rto, hcm:hcm, chcm:chcm, fsp:fsp, gb:gb, pqt:pqt, ldh:ldh, ers:ers, b2:b2, urea:urea, creatinina:creatinina, tgo:tgo, tgp:tgp, fal:fal, bb:bb, ferremia:ferremia, transferrina:transferrina, sat_transferrina:sat_transferrina, tibc:tibc, ferritina:ferritina, vit_b12:vit_b12, folato:folato, prot_totales:prot_totales, albumina:albumina, alfa:alfa, beta:beta, gamma:gamma, interpretacion:interpretacion, inmufijacion:inmufijacion, cll:cll, kappa:kappa, lambda:lambda, calcio:calcio, fosforo:fosforo, proteinuria:proteinuria, tp_seg:tp_seg, rin:rin, aptt:aptt, glucemia:glucemia, pico_monotonas:pico_monotonas,lg_g:lg_g, lg_a:lg_a, lg_m:lg_m, lg_e:lg_e, lg_d:lg_d, _token: '{{csrf_token()}}'},
                  success:function(data) {                  
                        //alert("Laboratorio Guardado");
                        mostrarSnackbar('Laboratorio General Guardado');
                        nuevoLaboratorioGeneral();
                  }
              });       
      }


      function nuevoLaboratorioGeneral(){        
        location.reload();
      }

</script>
