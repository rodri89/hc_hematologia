<div class="modal fade" id="claveAccesoModal" 
     tabindex="-1" role="dialog" 
     aria-labelledby="favoritesModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
     
        <div class="modal-header">      	
          <h4 class="modal-title"         
          id="ca_modalTitleMensaje">Clave Acceso</h4>
        </div>      
            
        <div class="modal-body">
        	<p>Para ingresar en esta sección por favor ingresar la clave de acceso</p>      	
          <input type="password" name="clave_acceso" id="clave_acceso" class="form-control">
    	   <label id="clave_incorrecta_label" hidden style="color: red">La clave ingresada es incorrecta.</label>
        </div>
      
        <div class="modal-footer">
        <button id="modal_aviso_continuar" type="button" 
           class="rodri_button_aceptar" 
           onclick="validarClave()" >Continuar</button>           
        </div>
      </div>
    </div>
</div>


  <script type="text/javascript">

    function showModalClaveAcceso() {
      $('#claveAccesoModal').modal('show');
    }

    function hideModalClaveAcceso() {
      $('#claveAccesoModal').modal('hide');
    }

  	
  	function validarClave() {
      var claveIngresada = document.getElementById("clave_acceso").value;
      if(claveIngresada == "123") {
        hideModalClaveAcceso();
        document.getElementById("clave_incorrecta_label").hidden = true;
        location.href = '/alta_diagnostico';
      } else {
        document.getElementById("clave_incorrecta_label").hidden = false;
      }
  	}

  </script>