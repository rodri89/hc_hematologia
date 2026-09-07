<div class="card background_panel_consulta_actual" id="seccion_audio_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickAudio()" type="button">Audio</a></b></h4>
	</div>	
	<div id="seccion_audio" hidden>						
			<label>Seleccione un microfono y luego click en grabar.</label>
	        <select class="form-control width450px_cel" name="listaDeDispositivos" id="listaDeDispositivos"></select>
	        <br><br>
	        <p id="duracion"></p>
	        <br>
	        <button class="rodri_button_aceptar" id="btnComenzarGrabacion">GRABAR</button>
	        <button class="rodri_button_cancelar" id="btnDetenerGrabacion">DETENER</button>
		<br>		
	</div>
</div>


<script src="{{asset('js/grabar_microfono.js')}}"> </script>
<script type="text/javascript">
	function clickAudio(){
		seccionPrincipal = document.getElementById("seccion_audio");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}	
	
</script>