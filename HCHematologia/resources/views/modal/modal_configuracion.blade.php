 <div class="modal fade" id="configuracionModal" 
     tabindex="-1" role="dialog" 
     aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-header">      	
        <h4 class="modal-title"         
        id="modalTitleMensaje">Configuracion</h4>
      </div>      
      
      <div class="modal-body">   
     <div class="modal-body">    	
    	   <div>
           <label for="text" class="col-sm-0 control-label editText">¿Desea ver las consultas con la caja de texto?</label>      <br>                  
            <div class="form-check">                        
              <label class="form-check-label editText" for="materialUnchecked">Si</label>
              <input type="radio" id="check_si" name="radio" value="1" required>
                          
              <label class="form-check-label editText" for="materialChecked">No</label>
              <input type="radio" id="check_no" name="radio" value="0" required>
            </div>    	
          </div>      
          <br>
          <div>
            <label for="text" class="control-label editText">Seleccione las secciones que desea ver</label><br>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check_diagnostico" name="secciones[]" value="check_diagnostico">
              <label class="form-check-label editText" for="check_diagnostico">Diagnostico</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check_motivo" name="secciones[]" value="check_motivo">
              <label class="form-check-label editText" for="check_motivo">Motivo Consulta</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check_lab" name="secciones[]" value="check_lab">
              <label class="form-check-label editText" for="check_lab">Laboratorio General</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check_control_anticoagulacion" name="secciones[]" value="check_control_anticoagulacion">
              <label class="form-check-label editText" for="check_control_anticoagulacion">Control Anticoagulacion</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check_trombofilia" name="secciones[]" value="check_trombofilia">
              <label class="form-check-label editText" for="check_trombofilia">Trombofilia</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check_transtorno_hemorragiparo" name="secciones[]" value="check_transtorno_hemorragiparo">
              <label class="form-check-label editText" for="check_transtorno_hemorragiparo">Trastorno Hemorragíparo</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check_medicacion_actual" name="secciones[]" value="check_medicacion_actual">
              <label class="form-check-label editText" for="check_medicacion_actual">Medicacion Actual</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check_evolucion" name="secciones[]" value="check_evolucion">
              <label class="form-check-label editText" for="check_evolucion">Evolucion</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check_audio" name="secciones[]" value="check_audio">
              <label class="form-check-label editText" for="check_audio">Audio</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check_resumen" name="secciones[]" value="check_resumen">
              <label class="form-check-label editText" for="check_resumen">Resumen</label>
            </div>
          </div>

      </div>
      
      <div class="modal-footer">
        <button id="modal_aviso_continuar" type="button" 
           class="rodri_button_aceptar" 
           onclick="guardarModalSeccionesVer()" 
           data-dismiss="modal">Aceptar</button>           
      </div>
    </div>
  </div>
</div>
</div>

  <script type="text/javascript">
  	
  	function mostrarConfiguracion() {    
      var modulo = 1;            
  		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_config',
           data:{modulo:modulo,_token: '{{csrf_token()}}'},
           	success:function(data) {
              if(data.medicoSecciones != null) {
                cargarCheck(data.medicoSecciones.valor_string);

                document.getElementById("check_si").checked = false;
                document.getElementById("check_no").checked = true;
                if(data.medicoConfig != null){
                  if(data.medicoConfig.activo == 1){
                    document.getElementById("check_si").checked = true;
                    document.getElementById("check_no").checked = false;
                  } 
               }  
              }                 
           		 
           		 $('#configuracionModal').modal();  
            }
        });	
  	}

    function cargarCheck(listChecks) {      
      if(listChecks !== "") {
        const arrayChecks = listChecks.split(','); // separa por coma
        arrayChecks.forEach(check_id => {
          document.getElementById(check_id).checked = true;
        });
      }
    }

    function guardarModalSeccionesVer() {
      var modulo = 2;
      var activo = 1;
      const checkboxes = document.querySelectorAll('input[name="secciones[]"]:checked');      
      const seccionesSeleccionadas = Array.from(checkboxes).map(cb => cb.value).join(',');
      
      $.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_config_secciones',
           data:{modulo:modulo, activo:activo, seccionesSeleccionadas:seccionesSeleccionadas ,_token: '{{csrf_token()}}'},
            success:function(data) {
                
            }
        }); 
    }

    function actualizarConfiguracion() {
      var modulo = 1;   
      var activo = 0;
      if(document.getElementById("check_si").checked)
        activo = 1;

      guardarModalSeccionesVer();
      $.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_config',
           data:{modulo:modulo, activo:activo ,_token: '{{csrf_token()}}'},
            success:function(data){
                var esNuevaConsulta = document.getElementById("es_nueva_consulta").value;                
                if(esNuevaConsulta == 1) {
                  guardarParcial();
                }
                location.reload();
            }
        }); 
    }

  </script>