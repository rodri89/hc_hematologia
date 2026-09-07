@if($nueva_consulta != 0)
<div class="card background_panel_consulta_actual" id="seccion_linfoma_hodgkin_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickLinfomaHodgkin()" type="button">Linfoma de Hodgkin</a></b></h4>
	</div>	
@else
	<div id="seccion_linfoma_hodgkin_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickLinfomaHodgkin()" type="button">Linfoma de Hodgkin</a></b></h4>
	</div>	
@endif	
	<input type="hidden" id="guardar_opcion_lh">
	<div id="seccion_linfoma_hodgkin" hidden>		
		<br>
		<div class="row">			
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-md-6"> 
				<div class="col-md-12"> 
					<div id="seccion_tabla_lh_sangre" class="table-responsive margin_top_5px" style="height:900px;">
				      <table class="table table-sm" id="lh_tabla_sangre" name="lh_tabla_sangre">
				       <thead class="fondoNav text-white">
				          <tr>				            
				            <th class="editText table_sin_borde td_size">SANGRE</th>                              
				            <th class="table_sin_borde"></th>                              
				          </tr>
				        </thead>
					    <tbody id="lh_tabla_sangre_tbody" name="lh_tabla_sangre_tbody">
							<tr>
								<th class="td_size letrasNegras">Hto/Hb/VCM</th>
								<th><input id="lh_sangre_hto_hb_vcm" type="text" class="form-control input_width_250px td_size"></th>
							</tr>				          

							<tr>
								<th class="td_size letrasNegras">Leucocitos</th>
								<td><input id="lh_sangre_leucocitos" type="text" class="form-control input_width_250px"></td>
							</tr>				          

							<tr>
								<th class="td_size letrasNegras">PQTs</th>
								<td><input id="lh_sangre_pqts" type="text" class="form-control input_width_250px"></td>
							</tr>

							<tr>
								<th class="td_size letrasNegras">Urea / Creatinina</th>
								<td><input id="lh_sangre_urea_creatinina" type="text" class="form-control input_width_250px"></td>
							</tr>				          				          

							<tr>
								<th class="td_size letrasNegras">CI Creat ml/min</th>
								<td><input id="lh_sangre_ci_creat_ml_min" type="text" class="form-control input_width_250px"></td>
							</tr>				          				          

							<tr>
								<th class="td_size letrasNegras">TGO/TGP/FAL/Bb</th>
								<td><input id="lh_sangre_tgo_tgp_fal_bb" type="text" class="form-control input_width_250px"></td>
							</tr>				          				          

							<tr>
								<th class="td_size letrasNegras">Uricemia</th>
								<td><input id="lh_sangre_uricemia" type="text" class="form-control input_width_250px"></td>
							</tr>				          				          

							<tr>
								<th class="td_size letrasNegras">VSG</th>
								<td><input id="lh_sangre_vsg" type="text" class="form-control input_width_250px"></td>
							</tr>				          	

							<tr>
								<th class="td_size letrasNegras">LDH</th>
								<td><input id="lh_sangre_ldh" type="text" class="form-control input_width_250px"></td>
							</tr>				          	

							<tr>
								<th class="td_size letrasNegras">B2 Microglobulina</th>
								<td><input id="lh_sangre_b2_microglobulina" type="text" class="form-control input_width_250px"></td>
							</tr>				          				  

							<tr>
								<th class="td_size letrasNegras">Proteinograma</th>
								<td><input id="lh_sangre_proteinograma" type="text" class="form-control input_width_250px"></td>
							</tr>

							<tr>
								<th class="td_size letrasNegras" colspan="2"><b>Serologia</b></th>								
							</tr>			          				                  			          			          

							<tr>
								<th class="td_size letrasNegras">HBV</th>
								<td><input id="lh_sangre_hbv" type="text" class="form-control input_width_250px"></td>
							</tr>

							<tr>
								<th class="td_size letrasNegras">HCV</th>
								<td><input id="lh_sangre_hcv" type="text" class="form-control input_width_250px"></td>
							</tr>

							<tr>
								<th class="td_size letrasNegras">HZV</th>
								<td><input id="lh_sangre_hzv" type="text" class="form-control input_width_250px"></td>
							</tr>

							<tr>
								<th class="td_size letrasNegras">CMV</th>
								<td><input id="lh_sangre_cmv" type="text" class="form-control input_width_250px"></td>
							</tr>

							<tr>
								<th class="td_size letrasNegras">HIV º4</th>
								<td><input id="lh_sangre_hiv_4" type="text" class="form-control input_width_250px"></td>
							</tr>

							<tr>
								<th class="td_size letrasNegras">VDRL</th>
								<td><input id="lh_sangre_vdrl" type="text" class="form-control input_width_250px"></td>
							</tr>

				        </tbody>
				    </table>
				</div>
				
				<div class="col-md-12"> 
					<h4>Examen Fisico</h4>					
					@include('medico.dibujos.linfoma_hodgkin_dibujo')
				</div>		

					</div>				
			</div> <!-- FIN COLUMNA IZQUIERDA -->

			<!-- COLUMNA DERECHA -->
			<div class="col-md-6"> 
				<div class="col-md-12"> 
					<div id="seccion_tabla_lh_imagenes" class="table-responsive margin_top_5px" style="height:400px;">
				      <table class="table table-sm" id="lh_tabla_imagenes" name="lh_tabla_imagenes">
				       <thead class="fondoNav text-white">
				          <tr>				            
				            <th class="editText table_sin_borde td_size" colspan="2">IMAGENES</th>                              
				          </tr>
				        </thead>
					    <tbody id="lh_tabla_imagenes_tbody" name="lh_tabla_imagenes_tbody">
							<tr>
								<th class="td_size letrasNegras">TC</th>								
								<td><input type="text" class="form-control datepicker editText" name="lh_tc_fecha" id="lh_tc_fecha" value="{{str_replace('-','/',$date)}}" required autocomplete="off"></td>						
							</tr>				          														

							<tr>
								<td colspan="2">
									<textarea class="form-control width450px_cel margin_left_5px" id="lh_imagenes_tc_descripcion" name="lh_imagenes_tc_descripcion" rows="4" cols="30" placeholder="Escriba aqui una descripcion"></textarea>			
								</td>
							</tr>

							<tr>
								<th class="td_size letrasNegras">PET</th>								
								<td><input type="text" class="form-control datepicker editText" name="lh_pet_fecha" id="lh_pet_fecha" value="{{str_replace('-','/',$date)}}" required autocomplete="off"></td>						
							</tr>				          														

							<tr>
								<td colspan="2">
									<textarea class="form-control width450px_cel margin_left_5px" id="lh_imagenes_pet_descripcion" name="lh_imagenes_pet_descripcion" rows="4" cols="30" placeholder="Escriba aqui una descripcion"></textarea>			
								</td>
							</tr>

				        </tbody>
				      </table>
					</div>				

					<div id="seccion_tabla_lh_biopsia" class="table-responsive margin_top_5px" style="height:180px;">
				      <table class="table table-sm" id="lh_tabla_biopsia" name="lh_tabla_biopsia">
				       <thead class="fondoNav text-white">
				          <tr>				            
				            <th class="editText table_sin_borde td_size" colspan="2">BIOPSIA</th>                              
				          </tr>
				        </thead>
					    <tbody id="lh_tabla_biopsia_tbody" name="lh_tabla_biopsia_tbody">							
							<tr>
								<td colspan="2">
									<textarea class="form-control width450px_cel margin_left_5px" id="lh_biopsia_descripcion" name="lh_biopsia_descripcion" rows="4" cols="30" placeholder="Escriba aqui una descripcion"></textarea>			
								</td>
							</tr>						

				        </tbody>
				      </table>
					</div>

					<div id="seccion_tabla_lh_estadio" class="table-responsive margin_top_5px" style="height:500px;">
				      <table class="table table-sm" id="lh_tabla_estadio" name="lh_tabla_estadio">
				       <thead class="fondoNav text-white">
				          <tr>				            
				            <th class="editText table_sin_borde td_size" colspan="2">ESTADIO</th>
				            <input hidden value="0" id="opcion_riesgo_favorable_desfavorable" >                              
				            <input hidden value="0" id="opcion_riesgo_bajo_inter_alto" >                              
				          </tr>
				        </thead>
					    <tbody id="lh_tabla_estadio_tbody" name="lh_tabla_estadio_tbody">							
							<tr>
								<th class="td_size letrasNegras">Ann Arbor</th>
								<td><input id="lh_estadio_ann_arbor" type="text" class="form-control input_width_250px"></td>
							</tr>

							<tr>
								<td>
									<table class="table table-sm" id="lh_subtabla_estadio_riesgo_1" name="lh_subtabla_estadio_riesgo_1">
									<tbody id="lh_tabla_estadio_riesgo_1_tbody" name="lh_tabla_estadio_riesgo_1_tbody">		
										<tr><th class="td_size letrasNegras" onclick="deseleccionarRiesgos(1)"><b>Riesgo desfavorable para enf. Localizada E I y II (NCCN)</b></th></tr>
										<tr><th id="td_estadio_riesgo_favorable" onclick="seleccionarEstadioRiesgo(1, 1)" class="td_size letrasNegras">Favorable 0</th></tr>
										<tr><th id="td_estadio_riesgo_desfavorable" onclick="seleccionarEstadioRiesgo(2, 1)" class="td_size letrasNegras">Desfavorable 1 o más</th></tr>						
									</tbody>	
								</table>
								</td>

								<td>
									<table class="table table-sm" id="lh_subtabla_estadio_riesgo_1" name="lh_subtabla_estadio_riesgo_1">
									<tbody id="lh_tabla_estadio_riesgo_1_tbody" name="lh_tabla_estadio_riesgo_1_tbody">	
										<tr><th class="td_size letrasNegras">Masa mediastinal > 1/3 diametro torax</th></tr>
										<tr><th class="td_size letrasNegras">ERS > 50 mmH</th></tr>
										<tr><th class="td_size letrasNegras">Sintomas B</th></tr>
										<tr><th class="td_size letrasNegras">3 o mas áreas nodales</th></tr>					
									</tbody>	
								</table>
								</td>
							</tr>

							<tr>
								<td>
									<table class="table table-sm" id="lh_subtabla_riesgo_2" name="lh_subtabla_riesgo_2">
									<tbody id="lh_tabla_riesgo_2_tbody" name="lh_tabla_riesgo_2_tbody">					
										<tr><th class="td_size letrasNegras" onclick="deseleccionarRiesgos(2)"><b>Riesgo desfavorable para enf. Avanzada E III y IV (Hasenclever)</b></th></tr>
										<tr><th id="td_estadio_riesgo_bajo" onclick="seleccionarEstadioRiesgo(1, 2)" class="td_size letrasNegras">Bajo: 0 - 1</th></tr>
										<tr><th id="td_estadio_riesgo_intermedio" onclick="seleccionarEstadioRiesgo(2, 2)" class="td_size letrasNegras">Intermedio: 2 - 3</th></tr>
										<tr><th id="td_estadio_riesgo_alto" onclick="seleccionarEstadioRiesgo(3, 2)" class="td_size letrasNegras">Alto: 4 - 7</th></tr>
									</tbody>	
								</table>
								</td>

								<td>
									<table class="table table-sm" id="lh_subtabla_riesgo_2" name="lh_subtabla_riesgo_2">
									<tbody id="lh_tabla_riesgo_2_tbody" name="lh_tabla_riesgo_2_tbody">					
										<tr><th class="td_size letrasNegras">Albumina <4 g/dl</th></tr>
										<tr><th class="td_size letrasNegras">Hb < 10,5 g/dl</th></tr>
										<tr><th class="td_size letrasNegras">Sexo Masculino</th></tr>
										<tr><th class="td_size letrasNegras">Edad > 45 años</th></tr>					
										<tr><th class="td_size letrasNegras">Leucocitosis > 15 mil</th></tr>					
										<tr><th class="td_size letrasNegras">Linfocitopenia < 8% o 600 mm3</th></tr>			
										<tr><th class="td_size letrasNegras">E IV</th></tr>			
									</tbody>	
								</table>
								</td>
							</tr>

				        </tbody>
				      </table>
					</div>

					<div id="seccion_tabla_lh_antecedentes" class="table-responsive margin_top_5px" style="height:700px;">
				      <table class="table table-sm" id="lh_tabla_antecedentes" name="lh_tabla_antecedentes">
				       <thead class="fondoNav text-white">
				          <tr>				            
				            <th class="editText table_sin_borde td_size" colspan="3">ANTECEDENTES</th>
				          </tr>
				        </thead>
					    <tbody id="lh_tabla_antecedentes_tbody" name="lh_tabla_antecedentes_tbody">							
							<tr>
								<th class="td_size letrasNegras">Inmunización</th>
								<td colspan="2">
								<table class="table table-sm" id="lh_subtabla_antecedentes" name="lh_subtabla_antecedentes">
									<tbody id="lh_subtabla_antecedentes_tbody" name="lh_subtabla_antecedentes_tbody">				<tr>
											<th class="td_size letrasNegras">Antigripal</th>
											<td class="td_size letrasNegras">
												<div class="custom-control custom-radio r_inline">
												  <input type="radio" id="lh_antigripal_si" name="lh_antigripal_group" class="custom-control-input">
												  <label class="custom-control-label td_size letrasNegras" for="lh_antigripal_si">SI</label>
											</div>
											<div class="custom-control custom-radio r_inline">
												 
												 <input type="radio" id="lh_antigripal_no" name="lh_antigripal_group" class="
												 custom-control-input">												 
												 <label class="custom-control-label td_size letrasNegras" for="lh_antigripal_no">NO</label>
											</div>
											</td>
										</tr>	
										<tr>
											<th class="td_size letrasNegras">Antineumococica</th>
											<td class="td_size letrasNegras">
												<div class="custom-control custom-radio r_inline">
												  <input type="radio" id="lh_antineumococica_si" name="lh_antineumococica_group" class="custom-control-input">
												  <label class="custom-control-label td_size letrasNegras" for="lh_antineumococica_si">SI</label>
											</div>
											<div class="custom-control custom-radio r_inline">
												 
												 <input type="radio" id="lh_antineumococica_no" name="lh_antineumococica_group" class="
												 custom-control-input">												 
												 <label class="custom-control-label td_size letrasNegras" for="lh_antineumococica_no">NO</label>
											</div>
											</td>
										</tr>	
																												
									</tbody>	
								</table>
								</td>							
							</tr>						

							<tr>
								<th class="td_size letrasNegras" onclick="deseleccionarEcog()">ECOG Performance<br>Status</th>
								<input hidden id="lh_opcion_antecedentes_ecog" value="-1">
								<td colspan="2">
								<table class="table table-sm" id="lh_subtabla_antecedentes" name="lh_subtabla_antecedentes">
									<tbody id="lh_subtabla_antecedentes_tbody" name="lh_subtabla_antecedentes_tbody">				<tr>
											<th id="ecog_performance_status_0" onclick="selectedECOGPerformanceStatus(0)" class="td_size letrasNegras">0</th>
											<th class="td_size letrasNegras">Sin repercusion</th>
										</tr>															
										<tr>
											<th id="ecog_performance_status_1" onclick="selectedECOGPerformanceStatus(1)" class="td_size letrasNegras">1</th>
											<th class="td_size letrasNegras">Tolera actividad diaria</th>
										</tr>					
										<tr>
											<th id="ecog_performance_status_2" onclick="selectedECOGPerformanceStatus(2)" class="td_size letrasNegras">2</th>
											<th class="td_size letrasNegras">< de la mitad del tiempo<br>despierto en silla o cama</th>
										</tr>					
										<tr>
											<th id="ecog_performance_status_3" onclick="selectedECOGPerformanceStatus(3)" class="td_size letrasNegras">3</th>
											<th class="td_size letrasNegras">> de la mitad del tiempo<br>despierto en silla o cama</th>
										</tr>					
										<tr>
											<th id="ecog_performance_status_4" onclick="selectedECOGPerformanceStatus(4)" class="td_size letrasNegras">4</th>
											<th class="td_size letrasNegras">Confinado a silla o cama</th>
										</tr>					
										<tr>
											<th id="ecog_performance_status_5" onclick="selectedECOGPerformanceStatus(5)" class="td_size letrasNegras">5</th>
											<th class="td_size letrasNegras">Muerte</th>
										</tr>					
									</tbody>	
								</table>
								</td>
							</tr>													

							<tr>
								<th class="td_size letrasNegras">Antecedentes de<br>enfermedad</th>
								<td colspan="2">
								<table class="table table-sm" id="lh_subtabla_antecedentes" name="lh_subtabla_antecedentes">
									<tbody id="lh_subtabla_antecedentes_tbody" name="lh_subtabla_antecedentes_tbody">				<tr>
											<th class="td_size letrasNegras">Insuficiencia Cardiaca</th>
											<td class="td_size letrasNegras">
												<div class="custom-control custom-radio r_inline margin_left_5px">
												  <input type="radio" id="lh_insuficiencia_cardiaca_si" name="lh_insuficiencia_cardiaca_group" class="custom-control-input">
												  <label class="custom-control-label td_size letrasNegras" for="lh_insuficiencia_cardiaca_si">SI</label>
											</div>
											<div class="custom-control custom-radio r_inline">
												 
												 <input type="radio" id="lh_insuficiencia_cardiaca_no" name="lh_insuficiencia_cardiaca_group" class="
												 custom-control-input">												 
												 <label class="custom-control-label td_size letrasNegras" for="lh_insuficiencia_cardiaca_no">NO</label>
											</div>
											</td>
										</tr>															
										<tr>
											<th class="td_size letrasNegras">Epoc</th>
											<td class="td_size letrasNegras">
												<div class="custom-control custom-radio r_inline margin_left_5px">
												  <input type="radio" id="lh_epoc_si" name="lh_epoc_group" class="custom-control-input">
												  <label class="custom-control-label td_size letrasNegras" for="lh_epoc_si">SI</label>
											</div>
											<div class="custom-control custom-radio r_inline">
												 
												 <input type="radio" id="lh_epoc_no" name="lh_epoc_group" class="
												 custom-control-input">												 
												 <label class="custom-control-label td_size letrasNegras" for="lh_epoc_no">NO</label>
											</div>
											</td>
										</tr>					
										<tr>
											<th class="td_size letrasNegras">Insuficiencia renal</th>
											<td class="td_size letrasNegras">
												<div class="custom-control custom-radio r_inline margin_left_5px">
												  <input type="radio" id="lh_insuficiencia_renal_si" name="lh_insuficiencia_renal_group" class="custom-control-input">
												  <label class="custom-control-label td_size letrasNegras" for="lh_insuficiencia_renal_si">SI</label>
											</div>
											<div class="custom-control custom-radio r_inline">
												 
												 <input type="radio" id="lh_insuficiencia_renal_no" name="lh_insuficiencia_renal_group" class="
												 custom-control-input">												 
												 <label class="custom-control-label td_size letrasNegras" for="lh_insuficiencia_renal_no">NO</label>
											</div>
											</td>
										</tr>					
										<tr>
											<th class="td_size letrasNegras">Hep</th>
											<td class="td_size letrasNegras">
												<div class="custom-control custom-radio r_inline margin_left_5px">
												  <input type="radio" id="lh_hep_si" name="lh_hep_group" class="custom-control-input">
												  <label class="custom-control-label td_size letrasNegras" for="lh_hep_si">SI</label>
											</div>
											<div class="custom-control custom-radio r_inline">
												 
												 <input type="radio" id="lh_hep_no" name="lh_hep_group" class="
												 custom-control-input">												 
												 <label class="custom-control-label td_size letrasNegras" for="lh_hep_no">NO</label>
											</div>
											</td>
										</tr>					
										<tr>
											<th class="td_size letrasNegras">Diabetes</th>
											<td class="td_size letrasNegras">
												<div class="custom-control custom-radio r_inline margin_left_5px">
												  <input type="radio" id="lh_diabetes_si" name="lh_diabetes_group" class="custom-control-input">
												  <label class="custom-control-label td_size letrasNegras" for="lh_diabetes_si">SI</label>
											</div>
											<div class="custom-control custom-radio r_inline">
												 
												 <input type="radio" id="lh_diabetes_no" name="lh_diabetes_group" class="
												 custom-control-input">												 
												 <label class="custom-control-label td_size letrasNegras" for="lh_diabetes_no">NO</label>
											</div>
											</td>
										</tr>					
										<tr>
											<th class="td_size letrasNegras">HIV</th>
											<td class="td_size letrasNegras">
												<div class="custom-control custom-radio r_inline margin_left_5px">
												  <input type="radio" id="lh_hiv_si" name="lh_hiv_group" class="custom-control-input">
												  <label class="custom-control-label td_size letrasNegras" for="lh_hiv_si">SI</label>
											</div>
											<div class="custom-control custom-radio r_inline">
												 
												 <input type="radio" id="lh_hiv_no" name="lh_hiv_group" class="
												 custom-control-input">												 
												 <label class="custom-control-label td_size letrasNegras" for="lh_hiv_no">NO</label>
											</div>
											</td>
										</tr>					
									</tbody>	
								</table>
								</td>
							</tr>													


							<tr>
								<th class="td_size letrasNegras">Score de Charlson</th>
								<th class="td_size letrasNegras">Puntaje</th>
								<td><input class="form-control" type="text" id="lh_score_charlson_puntaje"></td>
							</tr>					

				        </tbody>
				      </table>
					</div>


				</div>
			</div>	
		</div>
		@if($nueva_consulta != 0)
		<br>
		<div class="row contenedor3">
		  <div class="contenido3">
		    <button type="button" id="btn_id_guardarLinfomaHodgkin" onclick="guardarDatosLinfomaHodgkin(1)" class="rodri_button">GUARDAR</button>
		  </div>
		</div>		
		<br>	
		@endif
	</div>
</div>

<div id="seccion_linfoma_hodgkin_consulta" hidden>			
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
	
	function clickLinfomaHodgkin(){
		seccionPrincipal = document.getElementById("seccion_linfoma_hodgkin");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	function guardarDatosLinfomaHodgkin(opcion){		
		document.getElementById("guardar_opcion_lh").value = opcion;
		guardarSangre();
		guardarImagenes();
		guardarBiopsia();
		guardarEstadio();
		guardarAntecedentes();
		if(opcion == 1)
			guardarTipoEstudioConsulta(1);		
	}

	function cargarLinfomaHodgkin(){
		var consulta_id = document.getElementById("consulta_id").value;
		var tipo_estudio = 1;
		$.ajax({
             type:'POST',
             dataType:'JSON',
             url:'/cargar_tipo_estudio_consulta',
             data:{tipo_estudio:tipo_estudio, consulta_id:consulta_id, _token: '{{csrf_token()}}'},
             success:function(data) { 
             	if(data.response == 1){
             		document.getElementById("seccion_linfoma_hodgkin_nueva_consulta").hidden = false;
             		cargarSangreLh();
					cargarImagenesLh();
					cargarBiopsiaLh();
					cargarEstadioLh();
					cargarAntecedentesLh();						
             	} else {
             		document.getElementById("seccion_linfoma_hodgkin_nueva_consulta").hidden = true;             		
             	}		
              }
          });		
	}

	function cargarDatosLinfomaHodkin(){
		cargarSangreLh();
		cargarImagenesLh();
		cargarBiopsiaLh();
		cargarEstadioLh();
		cargarAntecedentesLh();
	}

	function selectedECOGPerformanceStatus(option){
		deseleccionarEcog();
		if(option == 0){
			$("#ecog_performance_status_0").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lh_opcion_antecedentes_ecog").value = 0;
		}
		if(option == 1){
			$("#ecog_performance_status_1").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lh_opcion_antecedentes_ecog").value = 1;
		}
		if(option == 2){
			$("#ecog_performance_status_2").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lh_opcion_antecedentes_ecog").value = 2;
		}
		if(option == 3){
			$("#ecog_performance_status_3").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lh_opcion_antecedentes_ecog").value = 3;
		}
		if(option == 4){
			$("#ecog_performance_status_4").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lh_opcion_antecedentes_ecog").value = 4;
		}
		if(option == 5){
			$("#ecog_performance_status_5").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lh_opcion_antecedentes_ecog").value = 5;
		}
	}

	function deseleccionarEcog(){
		$("#ecog_performance_status_0").attr("class", "td_size letrasNegras unselected_item");
		$("#ecog_performance_status_1").attr("class", "td_size letrasNegras unselected_item");
		$("#ecog_performance_status_2").attr("class", "td_size letrasNegras unselected_item");
		$("#ecog_performance_status_3").attr("class", "td_size letrasNegras unselected_item");
		$("#ecog_performance_status_4").attr("class", "td_size letrasNegras unselected_item");
		$("#ecog_performance_status_5").attr("class", "td_size letrasNegras unselected_item");
		document.getElementById("lh_opcion_antecedentes_ecog").value = -1;
	}

	function deseleccionarRiesgos(riesgo){
		if(riesgo == 1){
			$("#td_estadio_riesgo_favorable").attr("class", "td_size letrasNegras unselected_item");
			$("#td_estadio_riesgo_desfavorable").attr("class", "td_size letrasNegras unselected_item");
			document.getElementById("opcion_riesgo_favorable_desfavorable").value = 0;
		}
		if(riesgo == 2){
			$("#td_estadio_riesgo_bajo").attr("class", "td_size letrasNegras unselected_item");
			$("#td_estadio_riesgo_intermedio").attr("class", "td_size letrasNegras unselected_item");
			$("#td_estadio_riesgo_alto").attr("class", "td_size letrasNegras unselected_item");
			document.getElementById("opcion_riesgo_bajo_inter_alto").value = 0;
		}
	}

	function seleccionarEstadioRiesgo(option, riesgo){
		deseleccionarRiesgos(riesgo);		
		
		if(riesgo == 1){
			if(option == 1){
				$("#td_estadio_riesgo_favorable").attr("class", "td_size letrasNegras selected_item");	
				document.getElementById("opcion_riesgo_favorable_desfavorable").value = 1;
			}
			if(option == 2){
				document.getElementById("opcion_riesgo_favorable_desfavorable").value = 2;
				$("#td_estadio_riesgo_desfavorable").attr("class", "td_size letrasNegras selected_item");	
			}
		}
		if(riesgo == 2){
			if(option == 1){
				$("#td_estadio_riesgo_bajo").attr("class", "td_size letrasNegras selected_item");	
				document.getElementById("opcion_riesgo_bajo_inter_alto").value = 1;
			}
			if(option == 2){
				$("#td_estadio_riesgo_intermedio").attr("class", "td_size letrasNegras selected_item");	
				document.getElementById("opcion_riesgo_bajo_inter_alto").value = 2;
			}
			if(option == 3){
				$("#td_estadio_riesgo_alto").attr("class", "td_size letrasNegras selected_item");	
				document.getElementById("opcion_riesgo_bajo_inter_alto").value = 3;
			}
		}
	}


	function guardarSangre(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

		var hto_hb_vcm = document.getElementById("lh_sangre_hto_hb_vcm").value;
		var leucocitos = document.getElementById("lh_sangre_leucocitos").value;
		var pqts = document.getElementById("lh_sangre_pqts").value;
		var urea_creatinina = document.getElementById("lh_sangre_urea_creatinina").value;
		var ci_creat_ml_min = document.getElementById("lh_sangre_ci_creat_ml_min").value;
		var tgo_tgp_fal_bb = document.getElementById("lh_sangre_tgo_tgp_fal_bb").value;
		var uricemia = document.getElementById("lh_sangre_uricemia").value;
		var vsg = document.getElementById("lh_sangre_vsg").value;
		var ldh = document.getElementById("lh_sangre_ldh").value;
		var b2_microglobulina = document.getElementById("lh_sangre_b2_microglobulina").value;
		var proteinograma = document.getElementById("lh_sangre_proteinograma").value;
		var serologia_hbv = document.getElementById("lh_sangre_hbv").value;
		var serologia_hcv = document.getElementById("lh_sangre_hcv").value;
		var serologia_hzv = document.getElementById("lh_sangre_hzv").value;
		var serologia_cmv = document.getElementById("lh_sangre_cmv").value;
		var serologia_hiv_4 = document.getElementById("lh_sangre_hiv_4").value;
		var serologia_vdrl = document.getElementById("lh_sangre_vdrl").value;

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_lh_sangre',
           data:{consulta:consulta, paciente:paciente, hto_hb_vcm:hto_hb_vcm, leucocitos:leucocitos, pqts:pqts, urea_creatinina:urea_creatinina, ci_creat_ml_min:ci_creat_ml_min, tgo_tgp_fal_bb:tgo_tgp_fal_bb, uricemia:uricemia, vsg:vsg, ldh:ldh, b2_microglobulina:b2_microglobulina, proteinograma:proteinograma, serologia_hbv:serologia_hbv, serologia_hcv:serologia_hcv, serologia_hzv:serologia_hzv, serologia_cmv:serologia_cmv, serologia_hiv_4:serologia_hiv_4, serologia_vdrl:serologia_vdrl,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_lh").value == 1)
           				mostrarSnackbar("LH SANGRE GUARDADO");
            	} else {
            		mostrarSnackbar("LH SANGRE FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });
	}

	function guardarImagenes(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

		var lh_tc_fecha = document.getElementById("lh_tc_fecha").value;
		var tc_descripcion = document.getElementById("lh_imagenes_tc_descripcion").value;
		var lh_pet_fecha = document.getElementById("lh_pet_fecha").value;
		var pet_descripcion = document.getElementById("lh_imagenes_pet_descripcion").value;
		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_lh_imagenes',
           data:{consulta:consulta, paciente:paciente, lh_tc_fecha:lh_tc_fecha, tc_descripcion:tc_descripcion, lh_pet_fecha:lh_pet_fecha, pet_descripcion:pet_descripcion,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_lh").value == 1)
           				mostrarSnackbar("LH IMAGENES GUARDADO");
            	} else {
            		mostrarSnackbar("LH IMAGENES FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });	
	}

	function guardarBiopsia(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

		var descripcion = document.getElementById("lh_biopsia_descripcion").value;		
		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_lh_biopsia',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_lh").value == 1)
           				mostrarSnackbar("LH BIOPSIA GUARDADO");
            	} else {
            		mostrarSnackbar("LH BIOPSIA FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });	
	}

	function guardarEstadio(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

		var ann_arbor = document.getElementById("lh_estadio_ann_arbor").value;		
		var opcion_favorable_desfavorable = document.getElementById("opcion_riesgo_favorable_desfavorable").value;			
		var opcion_bajo_inter_alto = document.getElementById("opcion_riesgo_bajo_inter_alto").value;		
					
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_lh_estadio',
           data:{consulta:consulta, paciente:paciente, ann_arbor:ann_arbor, opcion_favorable_desfavorable:opcion_favorable_desfavorable, opcion_bajo_inter_alto:opcion_bajo_inter_alto,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_lh").value == 1)
           				mostrarSnackbar("LH ESTADIO GUARDADO");
            	} else {
            		mostrarSnackbar("LH ESTADIO FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });	
	}

	function guardarAntecedentes(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

		var antigripal = 0;
		if(document.getElementById("lh_antigripal_si").checked)
			antigripal = 1;
		if(document.getElementById("lh_antigripal_no").checked)
			antigripal = 2;

		var antineumococica = 0;
		if(document.getElementById("lh_antineumococica_si").checked)
			antineumococica = 1;
		if(document.getElementById("lh_antineumococica_no").checked)
			antineumococica = 2;

		var lh_opcion_antecedentes_ecog = document.getElementById("lh_opcion_antecedentes_ecog").value;					

		var insuficiencia_cardiaca = 0;
		if(document.getElementById("lh_insuficiencia_cardiaca_si").checked)
			insuficiencia_cardiaca = 1;
		if(document.getElementById("lh_insuficiencia_cardiaca_no").checked)
			insuficiencia_cardiaca = 2;

		var epoc = 0;
		if(document.getElementById("lh_epoc_si").checked)
			epoc = 1;
		if(document.getElementById("lh_epoc_no").checked)
			epoc = 2;

		var insuficiencia_renal = 0;
		if(document.getElementById("lh_insuficiencia_renal_si").checked)
			insuficiencia_renal = 1;
		if(document.getElementById("lh_insuficiencia_renal_no").checked)
			insuficiencia_renal = 2;

		var hep = 0;
		if(document.getElementById("lh_hep_si").checked)
			hep = 1;
		if(document.getElementById("lh_hep_no").checked)
			hep = 2;

		var diabetes = 0;
		if(document.getElementById("lh_diabetes_si").checked)
			diabetes = 1;
		if(document.getElementById("lh_diabetes_no").checked)
			diabetes = 2;

		var hiv = 0;
		if(document.getElementById("lh_hiv_si").checked)
			hiv = 1;
		if(document.getElementById("lh_hiv_no").checked)
			hiv = 2;

		var lh_score_charlson_puntaje = document.getElementById("lh_score_charlson_puntaje").value;
					
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_lh_antecedentes',
           data:{consulta:consulta, paciente:paciente, antigripal:antigripal, antineumococica:antineumococica, lh_opcion_antecedentes_ecog:lh_opcion_antecedentes_ecog, insuficiencia_cardiaca:insuficiencia_cardiaca, epoc:epoc, insuficiencia_renal:insuficiencia_renal, hep:hep, diabetes:diabetes, hiv:hiv, lh_score_charlson_puntaje:lh_score_charlson_puntaje,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_lh").value == 1)
           				mostrarSnackbar("LH ANTECEDENTES GUARDADO");
            	} else {
            		mostrarSnackbar("LH ANTECEDENTES FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });		
	}

	function cargarConsultasPreviasLh(){
		var paciente = document.getElementById("paciente_id").value;		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_consultas_previas_lh',
           data:{paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response == 1){           			
           			cargarSangreLh(data.response_data.id);
           			cargarImagenesLh(data.response_data.id);
					cargarBiopsiaLh(data.response_data.id);
					cargarEstadioLh(data.response_data.id);
					cargarAntecedentesLh(data.response_data.id);
					if(document.getElementById("seccion_boton_linfoma_hodgkin")!=null){
						document.getElementById("seccion_boton_linfoma_hodgkin").hidden = false;
					}
					// cargarImagenLh(null, paciente);
           		} else {
           			if(document.getElementById("seccion_boton_linfoma_hodgkin") != null){
						document.getElementById("seccion_boton_linfoma_hodgkin").hidden = true;
					}
           		}
            }
        });	   
	}

	function cargarSangreLh(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;				
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_sangre_lh',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){       
           			document.getElementById("lh_sangre_hto_hb_vcm").value = data.response_data.hto_hb_vcm;
					document.getElementById("lh_sangre_leucocitos").value = data.response_data.leucocitos;
					document.getElementById("lh_sangre_pqts").value = data.response_data.pqts;
					document.getElementById("lh_sangre_urea_creatinina").value = data.response_data.urea_creatinina;
					document.getElementById("lh_sangre_ci_creat_ml_min").value = data.response_data.ci_creat_ml_min;
					document.getElementById("lh_sangre_tgo_tgp_fal_bb").value = data.response_data.tgo_tgp_fal_bb;
					document.getElementById("lh_sangre_uricemia").value = data.response_data.uricemia;
					document.getElementById("lh_sangre_vsg").value = data.response_data.vsg;
					document.getElementById("lh_sangre_ldh").value = data.response_data.ldh;
					document.getElementById("lh_sangre_b2_microglobulina").value = data.response_data.b2_microglobulina;
					document.getElementById("lh_sangre_proteinograma").value = data.response_data.proteinograma;
					document.getElementById("lh_sangre_hbv").value = data.response_data.serologia_hbv;
					document.getElementById("lh_sangre_hcv").value = data.response_data.serologia_hcv;
					document.getElementById("lh_sangre_hzv").value = data.response_data.serologia_hzv;
					document.getElementById("lh_sangre_cmv").value = data.response_data.serologia_cmv;
					document.getElementById("lh_sangre_hiv_4").value = data.response_data.serologia_hiv_4;
					document.getElementById("lh_sangre_vdrl").value = data.response_data.serologia_vdrl;
            	} 
            }
        });	       
	}


	function cargarImagenesLh(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_imagenes_lh',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){ 
           			var auxFecha = data.response_data.fecha_tc.split("-");             		           		        
           			var fechaTc = auxFecha[2]+"/"+auxFecha[1]+"/"+auxFecha[0];
           			
           			document.getElementById("lh_tc_fecha").value = fechaTc;
					document.getElementById("lh_imagenes_tc_descripcion").value = data.response_data.tc;

					var auxFecha = data.response_data.fecha_pet.split("-");             		           		        
           			var fechaPet = auxFecha[2]+"/"+auxFecha[1]+"/"+auxFecha[0];
					document.getElementById("lh_pet_fecha").value = fechaPet;
					document.getElementById("lh_imagenes_pet_descripcion").value = data.response_data.pet;
            	} 
            }
        });	 
	}

	function cargarBiopsiaLh(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_biopsia_lh',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){ 
           			document.getElementById("lh_biopsia_descripcion").value = data.response_data.descripcion;
            	} 
            }
        });	
	}

	function cargarEstadioLh(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_estadio_lh',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){ 
           			document.getElementById("lh_estadio_ann_arbor").value = data.response_data.ann_arbor;		
					var opcion_favorable_desfavorable = data.response_data.opcion_favorable_desfavorable;	
					if(opcion_favorable_desfavorable != 0){
 						seleccionarEstadioRiesgo(opcion_favorable_desfavorable, 1);
					} else {
						deseleccionarRiesgos(1);
					}

					var opcion_bajo_inter_alto = data.response_data.opcion_bajo_inter_alto;
					if(opcion_bajo_inter_alto != 0){
 					seleccionarEstadioRiesgo(opcion_favorable_desfavorable, 2);
					} else {
						deseleccionarRiesgos(2);
					}
            	} 
            }
        });		
	}

	function cargarAntecedentesLh(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_antecedentes_lh',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){ 
           			if(data.response_data.opcion_antigripal == 0){
           				document.getElementById("lh_antigripal_si").checked = false;
           				document.getElementById("lh_antigripal_no").checked = false;
           			} else {
           				if(data.response_data.opcion_antigripal == 1){
           					document.getElementById("lh_antigripal_si").checked = true;
           					document.getElementById("lh_antigripal_no").checked = false;
           				} else {
           					document.getElementById("lh_antigripal_no").checked = true;
           					document.getElementById("lh_antigripal_si").checked = false;
           				}
           			}

           			if(data.response_data.opcion_antineumococica == 0){
           				document.getElementById("lh_antineumococica_si").checked = false;
           				document.getElementById("lh_antineumococica_no").checked = false;
           			} else {
           				if(data.response_data.opcion_antineumococica == 1){
           					document.getElementById("lh_antineumococica_si").checked = true;
           					document.getElementById("lh_antineumococica_no").checked = false;
           				} else {
           					document.getElementById("lh_antineumococica_no").checked = true;
           					document.getElementById("lh_antineumococica_si").checked = false;
           				}
           			}           		
		
					var lh_opcion_antecedentes_ecog = data.response_data.opcion_ecog;					
					if(lh_opcion_antecedentes_ecog != -1){
						selectedECOGPerformanceStatus(lh_opcion_antecedentes_ecog);
					} else {
						deseleccionarEcog();
					}

					if(data.response_data.insuficiencia_cardiaca == 0){
						document.getElementById("lh_insuficiencia_cardiaca_si").checked = false;
						document.getElementById("lh_insuficiencia_cardiaca_no").checked = false;
					} else {
						if(data.response_data.insuficiencia_cardiaca == 1){
							document.getElementById("lh_insuficiencia_cardiaca_si").checked = true;
							document.getElementById("lh_insuficiencia_cardiaca_no").checked = false;
						} else {
							document.getElementById("lh_insuficiencia_cardiaca_si").checked = false;
							document.getElementById("lh_insuficiencia_cardiaca_no").checked = true;
						}
					}								

					if(data.response_data.epoc == 0){
						document.getElementById("lh_epoc_si").checked = false;
						document.getElementById("lh_epoc_no").checked = false;
					} else {
						if(data.response_data.epoc == 1){
							document.getElementById("lh_epoc_si").checked = true;
							document.getElementById("lh_epoc_no").checked = false;
						} else {
							document.getElementById("lh_epoc_si").checked = false;
							document.getElementById("lh_epoc_no").checked = true;
						}
					}

					if(data.response_data.insuficiencia_renal == 0){
						document.getElementById("lh_insuficiencia_renal_si").checked = false;
						document.getElementById("lh_insuficiencia_renal_no").checked = false;
					} else {
						if(data.response_data.insuficiencia_renal == 1){
							document.getElementById("lh_insuficiencia_renal_si").checked = true;
							document.getElementById("lh_insuficiencia_renal_no").checked = false;
						} else {
							document.getElementById("lh_insuficiencia_renal_si").checked = false;
							document.getElementById("lh_insuficiencia_renal_no").checked = true;
						}
					}

					if(data.response_data.hep == 0){
						document.getElementById("lh_hep_si").checked = false;
						document.getElementById("lh_hep_no").checked = false;
					} else {
						if(data.response_data.hep == 1){
							document.getElementById("lh_hep_si").checked = true;
							document.getElementById("lh_hep_no").checked = false;
						} else {
							document.getElementById("lh_hep_si").checked = false;
							document.getElementById("lh_hep_no").checked = true;
						}
					}
					
					if(data.response_data.diabetes == 0){
						document.getElementById("lh_diabetes_si").checked = false;
						document.getElementById("lh_diabetes_no").checked = false;
					} else {
						if(data.response_data.diabetes == 1){
							document.getElementById("lh_diabetes_si").checked = true;
							document.getElementById("lh_diabetes_no").checked = false;
						} else {
							document.getElementById("lh_diabetes_si").checked = false;
							document.getElementById("lh_diabetes_no").checked = true;
						}
					}		
					
					if(data.response_data.hiv == 0){
						document.getElementById("lh_hiv_si").checked = false;
						document.getElementById("lh_hiv_no").checked = false;
					} else {
						if(data.response_data.hiv == 1){
							document.getElementById("lh_hiv_si").checked = true;
							document.getElementById("lh_hiv_no").checked = false;
						} else {
							document.getElementById("lh_hiv_si").checked = false;
							document.getElementById("lh_hiv_no").checked = true;
						}
					}			

					document.getElementById("lh_score_charlson_puntaje").value = data.response_data.score_charlson;
            	} 
            }
        });		
	}


</script>
