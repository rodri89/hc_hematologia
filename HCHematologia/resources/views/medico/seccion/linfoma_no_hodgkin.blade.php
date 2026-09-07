@if($nueva_consulta != 0)
<div class="card background_panel_consulta_actual" id="seccion_linfoma_no_hodgkin_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickLinfomaNoHodgkin()" type="button">Linfoma No Hodgkin</a></b></h4>
	</div>	
@else
	<div id="seccion_linfoma_no_hodgkin_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickLinfomaNoHodgkin()" type="button">Linfoma No Hodgkin</a></b></h4>
	</div>	
@endif	
	<input type="hidden" id="guardar_opcion_lnh">
	<div id="seccion_linfoma_no_hodgkin" hidden>		
			
		<div class="row">			
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-md-6"> 
				<div class="col-md-12"> 

					<div class="col-md-12"> 
					<h4>Examen Fisico</h4>					
						@include('medico.dibujos.linfoma_no_hodgkin_dibujo')
					</div>	
					
					<div id="seccion_tabla_lnh_antecedentes" class="table-responsive margin_top_5px" style="height:1150px;">
				      	<table class="table table-sm" id="lnh_tabla_antecedentes" name="lnh_tabla_antecedentes">
					       <thead class="fondoNav text-white">
					          <tr>				            
					            <th class="editText table_sin_borde td_size" colspan="2">ANTECEDENTES</th>
					          </tr>
					        </thead>
						    <tbody id="lnh_tabla_antecedentes_tbody" name="lnh_tabla_antecedentes_tbody">						
								<tr>
									<td class="td_size letrasNegras">Serologia</td>
									<td>
										<table class="table table-sm" id="lh_subtabla_serologia" name="lh_subtabla_serologia">
											<tbody id="lh_tabla_serologia_tbody" name="lh_tabla_serologia_tbody">				
												<tr>
													<th class="td_size letrasNegras">HBV</th>
													<td><input id="lnh_antecedentes_serologia_hbv" type="text" class="form-control input_width_250px"></td>
												</tr>												
												<tr>
													<th class="td_size letrasNegras">HCV</th>
													<td><input id="lnh_antecedentes_serologia_hcv" type="text" class="form-control input_width_250px"></td>
												</tr>												
												<tr>
													<th class="td_size letrasNegras">HZV</th>
													<td><input id="lnh_antecedentes_serologia_hzv" type="text" class="form-control input_width_250px"></td>
												</tr>											
												<tr>
													<th class="td_size letrasNegras">CMV</th>
													<td><input id="lnh_antecedentes_serologia_cmv" type="text" class="form-control input_width_250px"></td>
												</tr>											
												<tr>
													<th class="td_size letrasNegras">HIV 4º</th>
													<td><input id="lnh_antecedentes_serologia_hiv_4" type="text" class="form-control input_width_250px"></td>
												</tr>												
												<tr>
													<th class="td_size letrasNegras">VDRL</th>
													<td><input id="lnh_antecedentes_serologia_vdrl" type="text" class="form-control input_width_250px"></td>
												</tr>														
											</tbody>	
										</table>
									</td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">Inmunizacion</th>
									<td>
										<table class="table table-sm" id="lh_subtabla_riesgo_2" name="lh_subtabla_inmunizacion">
											<tbody id="lh_tabla_inmunizacion_tbody" name="lh_tabla_inmunizacion_tbody">			
												<tr>
													<th class="td_size letrasNegras">Antigripal</th>
													<td>
														<div class="custom-control custom-radio r_inline">
												  			<input type="radio" id="lnh_antigripal_si" name="lnh_antigripal_group" class="custom-control-input">
												  			<label class="custom-control-label td_size letrasNegras" for="lnh_antigripal_si">SI</label>
														</div>
														<div class="custom-control custom-radio r_inline">
												 			<input type="radio" id="lnh_antigripal_no" name="lnh_antigripal_group" class="custom-control-input">			
												 			<label class="custom-control-label td_size letrasNegras" for="lnh_antigripal_no">NO</label>
														</div>
													</td>
												</tr>												
												<tr>
													<th class="td_size letrasNegras">Antineumococica</th>
													<td>
														<div class="custom-control custom-radio r_inline">
												  			<input type="radio" id="lnh_antineumococica_si" name="lnh_antineumococica_group" class="custom-control-input">
												  			<label class="custom-control-label td_size letrasNegras" for="lnh_antineumococica_si">SI</label>
														</div>
														<div class="custom-control custom-radio r_inline">
												 			<input type="radio" id="lnh_antineumococica_no" name="lnh_antineumococica_group" class="custom-control-input">				
												 			<label class="custom-control-label td_size letrasNegras" for="lnh_antineumococica_no">NO</label>
														</div>
													</td>
												</tr>												
											</tbody>
										</table>
									</td>
								</tr>

								<tr>
									<th onclick="deseleccionarEcogAntecedentesLNH()" class="td_size letrasNegras">ECOG Performance Status</th>
									<td>
										<table class="table table-sm" id="lh_subtabla_riesgo_2" name="lh_subtabla_inmunizacion">
											<tbody id="lh_tabla_inmunizacion_tbody" name="lh_tabla_inmunizacion_tbody">		<input hidden id="lnh_opcion_antecedentes_ecog" value="-1">
												<tr>
													<th onclick="pintarEcogAntecedentesLNH(0)" id="ecog_antecedentes_lnh_0" class="td_size letrasNegras">0</th>
													<th class="td_size letrasNegras">Sin Repercusion</th>
												</tr>												
												<tr>
													<th onclick="pintarEcogAntecedentesLNH(1)" id="ecog_antecedentes_lnh_1" class="td_size letrasNegras">1</th>
													<th class="td_size letrasNegras">Tolera actividad diaria</th>
												</tr>												
												<tr>
													<th onclick="pintarEcogAntecedentesLNH(2)" id="ecog_antecedentes_lnh_2" class="td_size letrasNegras">2</th>
													<th class="td_size letrasNegras">< de la mitad del tiempo despierto en silla o cama</th>
												</tr>												
												<tr>
													<th onclick="pintarEcogAntecedentesLNH(3)" id="ecog_antecedentes_lnh_3" class="td_size letrasNegras">3</th>
													<th class="td_size letrasNegras">> de la mitad del tiempo despierto en silla o cama</th>
												</tr>												
												<tr>
													<th onclick="pintarEcogAntecedentesLNH(4)" id="ecog_antecedentes_lnh_4" class="td_size letrasNegras">4</th>
													<th class="td_size letrasNegras">Confinado a silla o cama</th>
												</tr>								
												<tr>
													<th onclick="pintarEcogAntecedentesLNH(5)" id="ecog_antecedentes_lnh_5" class="td_size letrasNegras">5</th>
													<th class="td_size letrasNegras">Muerte</th>
												</tr>																
											</tbody>
										</table>
									</td>
								</tr>										

								<tr>
									<th class="td_size letrasNegras">Antecedente de enfermedad</th>
									<td>
										<table class="table table-sm" id="lh_subtabla_riesgo_2" name="lh_subtabla_inmunizacion">
											<tbody id="lh_tabla_inmunizacion_tbody" name="lh_tabla_inmunizacion_tbody">			
												<tr>
													<th class="td_size letrasNegras">Insuficiencia cardiaca</th>
													<td><input id="lnh_ant_enf_insuficiencia_cardiaca" type="text" class="form-control input_width_200px"></td>
												</tr>												
												<tr>
													<th class="td_size letrasNegras">EPOC</th>
													<td><input id="lnh_ant_enf_epoc" type="text" class="form-control input_width_200px"></td>
												</tr>												
												<tr>
													<th class="td_size letrasNegras">Insuficiencia renal</th>
													<td><input id="lnh_ant_enf_insuficiencia_renal" type="text" class="form-control input_width_200px"></td>
												</tr>												
												<tr>
													<th class="td_size letrasNegras">Hepatopatia</th>
													<td><input id="lnh_ant_enf_hepatopatia" type="text" class="form-control input_width_200px"></td>
												</tr>												
												<tr>
													<th class="td_size letrasNegras">Diabetes</th>
													<td><input id="lnh_ant_enf_diabetes" type="text" class="form-control input_width_200px"></td>
												</tr>								
												<tr>
													<th class="td_size letrasNegras">HIV</th>
													<td><input id="lnh_ant_enf_hiv" type="text" class="form-control input_width_200px"></td>
												</tr>																
											</tbody>
										</table>
									</td>
								</tr>										

								<tr>
									<th class="td_size letrasNegras">Score de Charlson</th>
									<td>
										<table class="table table-sm" id="lh_subtabla_riesgo_2" name="lh_subtabla_inmunizacion">
											<tbody id="lh_tabla_inmunizacion_tbody" name="lh_tabla_inmunizacion_tbody">			
												<tr>
													<th class="td_size letrasNegras">Puntaje</th>
													<td><input id="lnh_score_charlson" type="text" class="form-control input_width_250px"></td>
												</tr>																			
											</tbody>
										</table>
									</td>
								</tr>

							</tbody>
						</table>
					</div>


				</div> 
			</div> <!-- COLUMNA IZQUIERDA FIN-->

			<!-- COLUMNA DERECHA -->
			<div class="col-md-6"> 
				<div class="col-md-12"> 

					<div id="seccion_tabla_lnh_imagenes" class="table-responsive margin_top_5px" style="height:180px;">
				      <table class="table table-sm" id="lnh_tabla_imagenes" name="lnh_tabla_imagenes">
				       <thead class="fondoNav text-white">
				          <tr>				            
				            <th class="editText table_sin_borde td_size" colspan="2">IMAGENES</th>                              
				          </tr>
				        </thead>
					    <tbody id="lnh_tabla_imagenes_tbody" name="lnh_tabla_imagenes_tbody">							
							<tr>
								<td colspan="2">
									<textarea class="form-control width450px_cel margin_left_5px" id="lnh_imagenes_descripcion" name="lnh_imagenes_descripcion" rows="4" cols="30" placeholder="Escriba aqui una descripcion"></textarea>			
								</td>
							</tr>						

				        </tbody>
				      </table>
					</div>

					<div id="seccion_tabla_lnh_biopsia_cmf" class="table-responsive margin_top_5px" style="height:180px;">
				      <table class="table table-sm" id="lnh_tabla_biopsia_cmf" name="lnh_tabla_biopsia_cmf">
				       <thead class="fondoNav text-white">
				          <tr>				            
				            <th class="editText table_sin_borde td_size" colspan="2">BIOPSIA - CMF</th>                              
				          </tr>
				        </thead>
					    <tbody id="lnh_tabla_biopsia_cmf_tbody" name="lnh_tabla_biopsia_cmf_tbody">							
							<tr>
								<td colspan="2">
									<textarea class="form-control width450px_cel margin_left_5px" id="lnh_biopsia_cmf_descripcion" name="lnh_biopsia_cmf_descripcion" rows="4" cols="30" placeholder="Escriba aqui una descripcion"></textarea>			
								</td>
							</tr>						

				        </tbody>
				      </table>
					</div>

					<div id="seccion_tabla_lnh_estadio" class="table-responsive margin_top_5px" style="height:215px;">
				      	<table class="table table-sm" id="lnh_tabla_estadio" name="lnh_tabla_estadio">
					       <thead class="fondoNav text-white">
					          <tr>				            
					            <th class="editText table_sin_borde td_size" colspan="2">ESTADIO</th>
					          </tr>
					        </thead>
						    <tbody id="lnh_tabla_estadio_tbody" name="lnh_tabla_estadio_tbody">							
								<tr>
									<th class="td_size letrasNegras">Ann Arbor</th>
									<td><input id="lnh_estadio_ann_arbor" type="text" class="form-control input_width_350px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">Lugano</th>
									<td><input id="lnh_estadio_lugano" type="text" class="form-control input_width_350px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">Murphy</th>
									<td><input id="lnh_estadio_murphy" type="text" class="form-control input_width_350px"></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div id="seccion_tabla_lnh_pronostico" class="table-responsive margin_top_5px" style="height:1500px;">
				      	<table class="table table-sm" id="lnh_tabla_pronostico" name="lnh_tabla_pronostico">
					       <thead class="fondoNav text-white">
					          <tr>				            
					            <th class="editText table_sin_borde td_size" colspan="4">PRONOSTICO</th>
					          </tr>
					        </thead>
						    <tbody id="lnh_tabla_pronostico_tbody" name="lnh_tabla_pronostico_tbody">							
								<tr>
									<th class="td_size letrasNegras">ECOG</th>
									<td><input id="lnh_pronostico_ecog" type="text" class="form-control input_width_110px"></td>
									<th class="td_size letrasNegras">LDH</th>
									<td><input id="lnh_pronostico_ldh" type="text" class="form-control input_width_110px"></td>
								</tr>								
								<tr>
									<th class="td_size letrasNegras">Testiculo</th>
									<td><input id="lnh_pronostico_testiculo" type="text" class="form-control input_width_110px"></td>
									<th class="td_size letrasNegras">Extra nodal/   /renal</th>
									<td><input id="lnh_pronostico_extra_nodal" type="text" class="form-control input_width_110px"></td>
								</tr>								
								<tr>
									<th class="td_size letrasNegras">SNC</th>
									<td><input id="lnh_pronostico_snc" type="text" class="form-control input_width_110px"></td>
									<th class="td_size letrasNegras">Edad > 60</th>
									<td><input id="lnh_pronostico_edad_60" type="text" class="form-control input_width_110px"></td>
								</tr>								
								<tr>
									<th class="td_size letrasNegras">Doble HIT</th>
									<td><input id="lnh_pronostico_doble_hit" type="text" class="form-control input_width_110px"></td>
									<th class="td_size letrasNegras">Sintomas B</th>
									<td><input id="lnh_pronostico_sintomas_b" type="text" class="form-control input_width_110px"></td>
								</tr>								
								<tr>
									<th class="td_size letrasNegras">M Osea</th>
									<td><input id="lnh_pronostico_m_osea" type="text" class="form-control input_width_110px"></td>
									<th class="td_size letrasNegras">Bulky</th>
									<td><input id="lnh_pronostico_bulky" type="text" class="form-control input_width_110px"></td>
								</tr>								
								<tr>
									<th class="td_size letrasNegras">HIV</th>
									<td><input id="lnh_pronostico_hiv" type="text" class="form-control input_width_110px"></td>
									<td class="td_size letrasNegras" colspan="2"></td>
								</tr>

								<tr>
									<th onclick="deseleccionarRipiLnh()" colspan="4" class="td_size letrasNegras"><b>RIPI</b></th>		
								</tr>
								<input hidden id="opcion_antecedentes_ripi" value="-1">
								<input hidden id="opcion_antecedentes_flipi" value="-1">								

								<input hidden id="opcion_antecedentes_mipi_res" value="-1">								
								<input hidden id="opcion_antecedentes_mipi_edad" value="-1">							
								<input hidden id="opcion_antecedentes_mipi_ecog" value="-1">							
								<input hidden id="opcion_antecedentes_mipi_ldh" value="-1">					
								<input hidden id="opcion_antecedentes_mipi_leucocitos" value="-1">		

								<tr>
									<th onclick="pintarRipiLnh(0)" id="lnh_ripi_0" class="td_size letrasNegras">LDH</th>							
									<th colspan="3" class="td_size letrasNegras">
										<div class="r_inline">
											<div class="custom-control custom-checkbox">
										    	<input type="checkbox" class="custom-control-input" id="lnh_ldh_riesgo_bajo_check">
										    	<label class="custom-control-label" for="lnh_ldh_riesgo_bajo_check">Riesgo bajo: puntuacion 0-1</label>
										  	</div>
										</div>
									</th>				
								</tr>
								<tr>
									<th onclick="pintarRipiLnh(1)" id="lnh_ripi_1" class="td_size letrasNegras">Edad > 60</th>								
									<th colspan="3" class="td_size letrasNegras">
										<div class="r_inline">
											<div class="custom-control custom-checkbox">
										    	<input type="checkbox" class="custom-control-input" id="lnh_ldh_riesgo_bajo_2_check">
										    	<label class="custom-control-label" for="lnh_ldh_riesgo_bajo_2_check">Riesgo intermedio bajo: puntuacion 2</label>
										  	</div>
										</div>
									</th>		
								</tr>
								<tr>
									<th onclick="pintarRipiLnh(2)" id="lnh_ripi_2" class="td_size letrasNegras">E III-IV</th>								
									<th colspan="3" class="td_size letrasNegras">
										<div class="r_inline">
											<div class="custom-control custom-checkbox">
										    	<input type="checkbox" class="custom-control-input" id="lnh_ldh_riesgo_intermedio_alto_check">
										    	<label class="custom-control-label" for="lnh_ldh_riesgo_intermedio_alto_check">Riesgo intermedio alto: puntuacion 3</label>
										  	</div>
										</div>
									</th>		
								</tr>
								<tr>
									<th onclick="pintarRipiLnh(3)" id="lnh_ripi_3" class="td_size letrasNegras">2 o mas sitios EN</th>								
									<th colspan="3" class="td_size letrasNegras">
										<div class="r_inline">
											<div class="custom-control custom-checkbox">
										    	<input type="checkbox" class="custom-control-input" id="lnh_ldh_riesgo_alto_check">
										    	<label class="custom-control-label" for="lnh_ldh_riesgo_alto_check">Riesgo alto: puntuacion 4-5</label>
										  	</div>
										</div>
									</th>		
								</tr>
								<tr>
									<th onclick="pintarRipiLnh(4)" id="lnh_ripi_4" class="td_size letrasNegras">PS ECOG 2 o mayor</th>								
									<th colspan="3" class="td_size letrasNegras"></th>		
								</tr>

								<tr>
									<th onclick="deseleccionarFlipiLnh()" colspan="4" class="td_size letrasNegras"><b>FLIPI</b></th>						
								</tr>

								<tr>
									<th onclick="pintarFlipiLnh(0)" id="lnh_flipi_0" class="td_size letrasNegras">LDH</th>								
									<th colspan="3" class="td_size letrasNegras">
										<div class="r_inline">
											<div class="custom-control custom-checkbox">
										    	<input type="checkbox" class="custom-control-input" id="lnh_ldh_riesgo_flipi_bajo_check">
										    	<label class="custom-control-label" for="lnh_ldh_riesgo_flipi_bajo_check">Riesgo bajo: puntuacion 0-1</label>
										  	</div>
										</div>
									</th>				
								</tr>
								<tr>
									<th onclick="pintarFlipiLnh(1)" id="lnh_flipi_1" class="td_size letrasNegras">Edad > 60</th>								
									<th colspan="3" class="td_size letrasNegras">
										<div class="r_inline">
											<div class="custom-control custom-checkbox">
										    	<input type="checkbox" class="custom-control-input" id="lnh_ldh_riesgo_flipi_intermedio_bajo_check">
										    	<label class="custom-control-label" for="lnh_ldh_riesgo_flipi_intermedio_bajo_check">Riesgo intermedio bajo: puntuacion 2</label>
										  	</div>
										</div>
									</th>		
								</tr>
								<tr>
									<th onclick="pintarFlipiLnh(2)" id="lnh_flipi_2" class="td_size letrasNegras">E III-IV</th>								
									<th colspan="3" class="td_size letrasNegras">
										<div class="r_inline">
											<div class="custom-control custom-checkbox">
										    	<input type="checkbox" class="custom-control-input" id="lnh_ldh_riesgo_flipi_alto_check">
										    	<label class="custom-control-label" for="lnh_ldh_riesgo_flipi_alto_check">Riesgo alto: puntuacion 3 o mas</label>
										  	</div>
										</div>
									</th>		
								</tr>
								<tr>
									<th onclick="pintarFlipiLnh(3)" id="lnh_flipi_3" class="td_size letrasNegras">4 o mas sitios ganglionares</th>							
									<td colspan="3" class="td_size letrasNegras"></td>		
								</tr>
								<tr>
									<th onclick="pintarFlipiLnh(4)" id="lnh_flipi_4" class="td_size letrasNegras">Hb < 12 gr/dl</th>								
									<td colspan="3" class="td_size letrasNegras"></td>		
								</tr>

								<tr>
									<th colspan="4" class="td_size letrasNegras"><b>MIPI</b></th>						
								</tr>								

								<tr>
									<td colspan="2">
										<table class="table table-sm" id="lh_subtabla_riesgo_2" name="lh_subtabla_inmunizacion">
											<tbody id="lh_tabla_inmunizacion_tbody" name="lh_tabla_inmunizacion_tbody">			
												<tr>
													<th onclick="deseleccionarMipiEdadLnh()" class="td_size letrasNegras"><b>EDAD</b></th>					
												</tr>																			
												<tr>
													<th onclick="pintarMipiEdadLnh(0)" id="lnh_mipi_50" class="td_size letrasNegras">0: < 50 años</th>					
												</tr>																		

												<tr>
													<th onclick="pintarMipiEdadLnh(1)" id="lnh_mipi_50_59" class="td_size letrasNegras">1: entre 50 y 59 años</th>				
												</tr>																			
												<tr>
													<th onclick="pintarMipiEdadLnh(2)" id="lnh_mipi_60_69" class="td_size letrasNegras">2: entre 60 y 69 años</th>			
												</tr>											

												<tr>
													<th onclick="pintarMipiEdadLnh(3)" id="lnh_mipi_70" class="td_size letrasNegras">3: > 70 años</th>
												</tr>																									
												<tr>
													<th onclick="deseleccionarMipiEcogLnh()" class="td_size letrasNegras"><b>ECOG</b></th>					
												</tr>
												<tr>
													<th onclick="pintarMipiEcogLnh(0)" id="lnh_mipi_ecog_1" class="td_size letrasNegras">0: Si ECOG 0-1</th>				
												</tr>																			
												<tr>
													<th onclick="pintarMipiEcogLnh(1)" id="lnh_mipi_ecog_2" class="td_size letrasNegras">1: Si ECOG 2-4</th>
												</tr>																			
												<tr>
													<th onclick="deseleccionarMipiLdhLnh()" class="td_size letrasNegras"><b>LDH</b></th>					
												</tr>

												<tr>
													<th onclick="pintarMipiLdhLnh(0)" id="lnh_mipi_ldh_0" class="td_size letrasNegras">0: ratio menor de 0.67</th>			
												</tr>																			
												<tr>
													<th onclick="pintarMipiLdhLnh(1)" id="lnh_mipi_ldh_1" class="td_size letrasNegras">1: ratio entre 0.67 y 0.99</th>	
												</tr>																			
												<tr>
													<th onclick="pintarMipiLdhLnh(2)" id="lnh_mipi_ldh_2" class="td_size letrasNegras">2: ratio entre 1.00 y 1.49</th>	
												</tr>	

												<tr>
													<th onclick="pintarMipiLdhLnh(3)" id="lnh_mipi_ldh_3" class="td_size letrasNegras">3: ratio igual o mayor de 1.50</th>
												</tr>																			

												<tr>
													<th onclick="deseleccionarMipiLeucocitosLnh()" class="td_size letrasNegras"><b>Leucocitos</b></th>				
												</tr>

												<tr>
													<th onclick="pintarMipiLeucocitosLnh(0)" id="lnh_mipi_leucocitos_0" class="td_size letrasNegras">0: menor de 6.700 x 109/L</th>		
												</tr>																			
												<tr>
													<th onclick="pintarMipiLeucocitosLnh(1)" id="lnh_mipi_leucocitos_1" class="td_size letrasNegras">1: entre 6.700 y 9.999 x 109/L</th>
												</tr>																			
												<tr>
													<th onclick="pintarMipiLeucocitosLnh(2)" id="lnh_mipi_leucocitos_2" class="td_size letrasNegras">2: entre 1.000 y 14.999 x 109/L</th>
												</tr>														

												<tr>
													<th onclick="pintarMipiLeucocitosLnh(4)" id="lnh_mipi_leucocitos_3" class="td_size letrasNegras">4: igual o mayor de 15.000 x 109/L</th>
												</tr>																								
											</tbody>
										</table>										
									</td>

									<td colspan="2">
										<table class="table table-sm" id="lh_subtabla_riesgo_2" name="lh_subtabla_inmunizacion">
											<tbody id="lh_tabla_inmunizacion_tbody" name="lh_tabla_inmunizacion_tbody">			
												<tr><th id="mipi_res_1" class="td_size letrasNegras">Riesgo bajo: entre 0 y 3 puntos</th></tr>
												<tr><th id="mipi_res_2" class="td_size letrasNegras">Riesgo intermedio: entre 4 y 5 puntos</th></tr>
												<tr><th id="mipi_res_3" class="td_size letrasNegras">Riesgo alto: entre 6 y 11 puntos</th></tr>
											</tbody>
										</table>
									</td>

								</tr>

							</tbody>
						</table>
					</div>

				</div>
			</div> <!-- COLUMNA DERECHA FIN-->
			
		</div>			
		@if($nueva_consulta != 0)
		<div class="row contenedor3">
		  <div class="contenido3">
		  	
		    <button type="button" id="btn_id_guardarLinfomaNoHodgkin" onclick="guardarDatosLinfomaNoHodgkin(1)" class="rodri_button">GUARDAR</button>
		  </div>
		</div>		
		@endif
		<br>
	</div>

	
</div>

<div id="seccion_linfoma_no_hodgkin_consulta" hidden>			
</div>

<script type="text/javascript">
	
	function clickLinfomaNoHodgkin(){
		seccionPrincipal = document.getElementById("seccion_linfoma_no_hodgkin");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	function cargarConsultasPreviasLnh(){
		var paciente = document.getElementById("paciente_id").value;		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_consultas_previas_lnh',
           data:{paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response == 1){           			           			
           			cargarImagenesLnh(data.response_data.id);
					cargarBiopsiaCMFLnh(data.response_data.id);
					cargarEstadioLnh(data.response_data.id);
					cargarAntecedentesLnh(data.response_data.id);
					cargarPronosticoLnh(data.response_data.id);
					// cargarImagenLnh(null, paciente);
					if(document.getElementById("seccion_boton_linfoma_no_hodgkin")!=null){
						document.getElementById("seccion_boton_linfoma_no_hodgkin").hidden = false;
					}
           		} else {
           			if(document.getElementById("seccion_boton_linfoma_no_hodgkin")!=null){
						document.getElementById("seccion_boton_linfoma_no_hodgkin").hidden = true;
					}
           		}
            }
        });	   
	}

	function cargarDatosLinfomaNoHodkin(){
		cargarImagenesLnh();
		cargarBiopsiaCMFLnh();
		cargarEstadioLnh();
		cargarAntecedentesLnh();
		cargarPronosticoLnh();	
	}

	function guardarDatosLinfomaNoHodgkin(opcion){
		document.getElementById("guardar_opcion_lnh").value = opcion;		
		guardarImagenesLnh();
		guardarBiopsiaCMFLnh();
		guardarEstadioLnh();
		guardarAntecedentesLnh();
		guardarPronosticoLnh();		
		guardarTipoEstudioConsulta(2);		
	}
	
	function deseleccionarRipiLnh(){
		$("#lnh_ripi_0").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_ripi_1").attr("class", "td_size letrasNegras unselected_item");
		$("#lnh_ripi_2").attr("class", "td_size letrasNegras unselected_item");
		$("#lnh_ripi_3").attr("class", "td_size letrasNegras unselected_item");
		$("#lnh_ripi_4").attr("class", "td_size letrasNegras unselected_item");		
		document.getElementById("opcion_antecedentes_ripi").value = -1;
	}
	
	function pintarRipiLnh(opcion){
		deseleccionarRipiLnh();
		if(opcion == 0){
			$("#lnh_ripi_0").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("opcion_antecedentes_ripi").value = 0;
		}
		if(opcion == 1){
			$("#lnh_ripi_1").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("opcion_antecedentes_ripi").value = 1;
		}
		if(opcion == 2){
			$("#lnh_ripi_2").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("opcion_antecedentes_ripi").value = 2;
		}
		if(opcion == 3){
			$("#lnh_ripi_3").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("opcion_antecedentes_ripi").value = 3;
		}
		if(opcion == 4){
			$("#lnh_ripi_4").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("opcion_antecedentes_ripi").value = 4;
		}
	}

	function deseleccionarFlipiLnh(){
		$("#lnh_flipi_0").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_flipi_1").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_flipi_2").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_flipi_3").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_flipi_4").attr("class", "td_size letrasNegras unselected_item");				
		document.getElementById("opcion_antecedentes_flipi").value = -1;
	}

	function pintarFlipiLnh(opcion){		
		deseleccionarFlipiLnh();
		if(opcion == 0){
			$("#lnh_flipi_0").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("opcion_antecedentes_flipi").value = 0;
		}
		if(opcion == 1){
			$("#lnh_flipi_1").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("opcion_antecedentes_flipi").value = 1;
		}
		if(opcion == 2){
			$("#lnh_flipi_2").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("opcion_antecedentes_flipi").value = 2;
		}
		if(opcion == 3){
			$("#lnh_flipi_3").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("opcion_antecedentes_flipi").value = 3;
		}
		if(opcion == 4){
			$("#lnh_flipi_4").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("opcion_antecedentes_flipi").value = 4;
		}
	}

	function deseleccionarMipiEdadLnh(){
		$("#lnh_mipi_50").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_mipi_50_59").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_mipi_60_69").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_mipi_70").attr("class", "td_size letrasNegras unselected_item");		
		document.getElementById("opcion_antecedentes_mipi_edad").value = -1;
		pintarMipiResLnh();
	}

	function pintarMipiEdadLnh(opcion){
		deseleccionarMipiEdadLnh();
		if(opcion == 0){
			$("#lnh_mipi_50").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 1){
			$("#lnh_mipi_50_59").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 2){
			$("#lnh_mipi_60_69").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 3){
			$("#lnh_mipi_70").attr("class", "td_size letrasNegras selected_item");				
		}
		document.getElementById("opcion_antecedentes_mipi_edad").value = opcion;
		pintarMipiResLnh();
	}

	function deseleccionarMipiEcogLnh(){
		$("#lnh_mipi_ecog_1").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_mipi_ecog_2").attr("class", "td_size letrasNegras unselected_item");				
		document.getElementById("opcion_antecedentes_mipi_ecog").value = -1;
		pintarMipiResLnh();
	}

	function pintarMipiEcogLnh(opcion){
		deseleccionarMipiEcogLnh();
		if(opcion == 0){
			$("#lnh_mipi_ecog_1").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 1){
			$("#lnh_mipi_ecog_2").attr("class", "td_size letrasNegras selected_item");				
		}		
		document.getElementById("opcion_antecedentes_mipi_ecog").value = opcion;			
		pintarMipiResLnh();
	}

	function deseleccionarMipiLdhLnh(){
		$("#lnh_mipi_ldh_0").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_mipi_ldh_1").attr("class", "td_size letrasNegras unselected_item");				
		$("#lnh_mipi_ldh_2").attr("class", "td_size letrasNegras unselected_item");				
		$("#lnh_mipi_ldh_3").attr("class", "td_size letrasNegras unselected_item");				
		document.getElementById("opcion_antecedentes_mipi_ldh").value = -1;
		pintarMipiResLnh();
	}
	
	function pintarMipiLdhLnh(opcion){	
		deseleccionarMipiLdhLnh();
		if(opcion == 0){
			$("#lnh_mipi_ldh_0").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 1){
			$("#lnh_mipi_ldh_1").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 2){
			$("#lnh_mipi_ldh_2").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 3){
			$("#lnh_mipi_ldh_3").attr("class", "td_size letrasNegras selected_item");				
		}				
		document.getElementById("opcion_antecedentes_mipi_ldh").value = opcion;			
		pintarMipiResLnh();
	}

	function deseleccionarMipiLeucocitosLnh(){
		$("#lnh_mipi_leucocitos_0").attr("class", "td_size letrasNegras unselected_item");		
		$("#lnh_mipi_leucocitos_1").attr("class", "td_size letrasNegras unselected_item");				
		$("#lnh_mipi_leucocitos_2").attr("class", "td_size letrasNegras unselected_item");				
		$("#lnh_mipi_leucocitos_3").attr("class", "td_size letrasNegras unselected_item");				
		document.getElementById("opcion_antecedentes_mipi_leucocitos").value = -1;		
		pintarMipiResLnh();
	}

	function pintarMipiLeucocitosLnh(opcion){
		deseleccionarMipiLeucocitosLnh();
		if(opcion == 0){
			$("#lnh_mipi_leucocitos_0").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 1){
			$("#lnh_mipi_leucocitos_1").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 2){
			$("#lnh_mipi_leucocitos_2").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 4){
			$("#lnh_mipi_leucocitos_3").attr("class", "td_size letrasNegras selected_item");				
		}			
		document.getElementById("opcion_antecedentes_mipi_leucocitos").value = opcion;
		pintarMipiResLnh();
	}

	function pintarEcogAntecedentesLNH(option){
		deseleccionarEcogAntecedentesLNH();
		if(option == 0){
			$("#ecog_antecedentes_lnh_0").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lnh_opcion_antecedentes_ecog").value = 0;
		}
		if(option == 1){
			$("#ecog_antecedentes_lnh_1").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lnh_opcion_antecedentes_ecog").value = 1;
		}
		if(option == 2){
			$("#ecog_antecedentes_lnh_2").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lnh_opcion_antecedentes_ecog").value = 2;
		}
		if(option == 3){
			$("#ecog_antecedentes_lnh_3").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lnh_opcion_antecedentes_ecog").value = 3;
		}
		if(option == 4){
			$("#ecog_antecedentes_lnh_4").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lnh_opcion_antecedentes_ecog").value = 4;
		}
		if(option == 5){
			$("#ecog_antecedentes_lnh_5").attr("class", "td_size letrasNegras selected_item");	
			document.getElementById("lnh_opcion_antecedentes_ecog").value = 5;
		}		
	}

	function pintarMipiResLnh(){
		var edad = document.getElementById("opcion_antecedentes_mipi_edad").value;
		var ecog = document.getElementById("opcion_antecedentes_mipi_ecog").value;
		var ldh = document.getElementById("opcion_antecedentes_mipi_ldh").value;
		var leucocitos = document.getElementById("opcion_antecedentes_mipi_leucocitos").value;
		var suma = 0;
		if(parseInt(edad) != -1)
			suma += parseInt(edad);
		if(parseInt(ecog) != -1)
			suma += parseInt(ecog);
		if(parseInt(ldh) != -1)
			suma += parseInt(ldh);
		if(parseInt(leucocitos) != -1)
			suma += parseInt(leucocitos);
		document.getElementById("opcion_antecedentes_mipi_res").value = suma;
		deseleccionarMipiResLnh();
		if(suma >= 0 && suma <= 3)
			$("#mipi_res_1").attr("class", "td_size letrasNegras selected_item");				
		if(suma == 4 || suma == 5)
			$("#mipi_res_2").attr("class", "td_size letrasNegras selected_item");				
		if(suma >= 6 && suma <= 11)
			$("#mipi_res_3").attr("class", "td_size letrasNegras selected_item");				
		if((parseInt(edad)==-1)&&(parseInt(ecog)==-1)&&(parseInt(ldh)==-1)&&(parseInt(leucocitos)==-1)){
			deseleccionarMipiResLnh();
		}
	}

	function deseleccionarMipiResLnh(){
		$("#mipi_res_1").attr("class", "td_size letrasNegras unselected_item");
		$("#mipi_res_2").attr("class", "td_size letrasNegras unselected_item");
		$("#mipi_res_3").attr("class", "td_size letrasNegras unselected_item");
	}

	function deseleccionarEcogAntecedentesLNH(){
		$("#ecog_antecedentes_lnh_0").attr("class", "td_size letrasNegras unselected_item");
		$("#ecog_antecedentes_lnh_1").attr("class", "td_size letrasNegras unselected_item");
		$("#ecog_antecedentes_lnh_2").attr("class", "td_size letrasNegras unselected_item");
		$("#ecog_antecedentes_lnh_3").attr("class", "td_size letrasNegras unselected_item");
		$("#ecog_antecedentes_lnh_4").attr("class", "td_size letrasNegras unselected_item");
		$("#ecog_antecedentes_lnh_5").attr("class", "td_size letrasNegras unselected_item");
		document.getElementById("lnh_opcion_antecedentes_ecog").value = -1;
	}

	function cargarLinfomaNoHodgkin(){
		var consulta_id = document.getElementById("consulta_id").value;
		var tipo_estudio = 2;
		$.ajax({
             type:'POST',
             dataType:'JSON',
             url:'/cargar_tipo_estudio_consulta',
             data:{tipo_estudio:tipo_estudio, consulta_id:consulta_id, _token: '{{csrf_token()}}'},
             success:function(data) { 
             	if(data.response == 1){
             		document.getElementById("seccion_linfoma_no_hodgkin_nueva_consulta").hidden = false;
             		cargarImagenesLnh();
					cargarBiopsiaCMFLnh();
					cargarEstadioLnh();
					cargarAntecedentesLnh();
					cargarPronosticoLnh();		
             	} else {
             		document.getElementById("seccion_linfoma_no_hodgkin_nueva_consulta").hidden = true;
             	}		
              }
          });
		
	}

	function guardarImagenesLnh(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var descripcion = document.getElementById("lnh_imagenes_descripcion").value;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_imagenes_lnh',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_lnh").value == 1)
						mostrarSnackbar("IMAGENES LNH GUARDADAS");            		
            	} else {
            		mostrarSnackbar("IMAGENES LNH FALLO");            		
            	}
            }
        });		
	}

	function guardarBiopsiaCMFLnh(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var descripcion = document.getElementById("lnh_biopsia_cmf_descripcion").value;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_biopsia_cmf_lnh',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_lnh").value == 1)
						mostrarSnackbar("BIOPSIA CMF LNH GUARDADAS");            		
            	} else {
            		mostrarSnackbar("BIOPSIA CMF LNH FALLO");            		
            	}
            }
        });		
	}

	function guardarEstadioLnh(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		
		var ann_arbor = document.getElementById("lnh_estadio_ann_arbor").value;
		var lugano = document.getElementById("lnh_estadio_lugano").value;
		var murphy = document.getElementById("lnh_estadio_murphy").value;
	
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_estadio_lnh',
           data:{consulta:consulta, paciente:paciente, ann_arbor:ann_arbor, lugano:lugano, murphy:murphy ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_lnh").value == 1)
						mostrarSnackbar("ESTADIO LNH GUARDADAS");            		
            	} else {
            		mostrarSnackbar("ESTADIO LNH FALLO");            		
            	}
            }
        });		
	}

	function guardarAntecedentesLnh(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		
		var serologia_hbv = document.getElementById("lnh_antecedentes_serologia_hbv").value;
		var serologia_hcv = document.getElementById("lnh_antecedentes_serologia_hcv").value;
		var serologia_hzv = document.getElementById("lnh_antecedentes_serologia_hzv").value;
		var serologia_cmv = document.getElementById("lnh_antecedentes_serologia_cmv").value;
		var serologia_hiv_4 = document.getElementById("lnh_antecedentes_serologia_hiv_4").value;
		var serologia_vdrl = document.getElementById("lnh_antecedentes_serologia_vdrl").value;
		
		var antigripal = 0;
		if(document.getElementById("lnh_antigripal_si").checked)
			antigripal = 1;		
		if(document.getElementById("lnh_antigripal_no").checked)
			antigripal = 2;

		var antineumococica = 0;
		if(document.getElementById("lnh_antineumococica_si").checked)
			antineumococica = 1;		
		if(document.getElementById("lnh_antineumococica_no").checked)
			antineumococica = 2;	

		var opcion_antecedentes_ecog = document.getElementById("lnh_opcion_antecedentes_ecog").value;	

		var insuficiencia_cardiaca = document.getElementById("lnh_ant_enf_insuficiencia_cardiaca").value;	
		var epoc = document.getElementById("lnh_ant_enf_epoc").value;	
		var insuficiencia_renal = document.getElementById("lnh_ant_enf_insuficiencia_renal").value;	
		var hepatopatia = document.getElementById("lnh_ant_enf_hepatopatia").value;	
		var diabetes = document.getElementById("lnh_ant_enf_diabetes").value;	
		var hiv = document.getElementById("lnh_ant_enf_hiv").value;	

		var score_charlson = document.getElementById("lnh_score_charlson").value;	

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_antecedentes_lnh',
           data:{consulta:consulta, paciente:paciente, serologia_hbv:serologia_hbv, serologia_hcv:serologia_hcv, serologia_hzv:serologia_hzv, serologia_cmv:serologia_cmv, serologia_hiv_4:serologia_hiv_4, serologia_vdrl:serologia_vdrl, antigripal:antigripal, antineumococica:antineumococica, opcion_antecedentes_ecog:opcion_antecedentes_ecog, insuficiencia_cardiaca:insuficiencia_cardiaca, epoc:epoc, hepatopatia:hepatopatia, insuficiencia_renal:insuficiencia_renal, diabetes:diabetes, hiv:hiv, score_charlson:score_charlson,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_lnh").value == 1)
						mostrarSnackbar("ANTECEDENTES LNH GUARDADAS");            		
            	} else {
            		mostrarSnackbar("ANTECEDENTES LNH FALLO");            		
            	}
            }
        });
	}

	function guardarPronosticoLnh(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		
		var ecog = document.getElementById("lnh_pronostico_ecog").value;		
		var ldh = document.getElementById("lnh_pronostico_ldh").value;		
		var testiculo = document.getElementById("lnh_pronostico_testiculo").value;		
		var extra_nodal = document.getElementById("lnh_pronostico_extra_nodal").value;		
		var snc = document.getElementById("lnh_pronostico_snc").value;		
		var edad_60 = document.getElementById("lnh_pronostico_edad_60").value;		
		var doble_hit = document.getElementById("lnh_pronostico_doble_hit").value;		
		var sintomas_b = document.getElementById("lnh_pronostico_sintomas_b").value;		
		var m_osea = document.getElementById("lnh_pronostico_m_osea").value;		
		var bulky = document.getElementById("lnh_pronostico_bulky").value;		
		var hiv = document.getElementById("lnh_pronostico_hiv").value;		

		var opcion_ripi = document.getElementById("opcion_antecedentes_ripi").value;		
		var opcion_flipi = document.getElementById("opcion_antecedentes_flipi").value;				
		var opcion_mipi_edad = document.getElementById("opcion_antecedentes_mipi_edad").value;		
		var opcion_mipi_ecog = document.getElementById("opcion_antecedentes_mipi_ecog").value;		
		var opcion_mipi_ldh = document.getElementById("opcion_antecedentes_mipi_ldh").value;		
		var opcion_mipi_leucocitos = document.getElementById("opcion_antecedentes_mipi_leucocitos").value;		
		var opcion_mipi_res = document.getElementById("opcion_antecedentes_mipi_res").value;		

		var ripi_bajo = 0;
		if(document.getElementById("lnh_ldh_riesgo_bajo_check").checked){
			ripi_bajo = 1;
		} else {
			ripi_bajo = 2;
		}

		var ripi_bajo_2 = 0;
		if(document.getElementById("lnh_ldh_riesgo_bajo_2_check").checked){
			ripi_bajo_2 = 1;
		} else {
			ripi_bajo_2 = 2;
		}

		var ripi_intermedio = 0;
		if(document.getElementById("lnh_ldh_riesgo_intermedio_alto_check").checked){
			ripi_intermedio = 1;
		} else {
			ripi_intermedio = 2;
		}

		var ripi_alto = 0;
		if(document.getElementById("lnh_ldh_riesgo_alto_check").checked){
			ripi_alto = 1;
		} else {
			ripi_alto = 2;
		}

		var flipi_bajo = 0;
		if(document.getElementById("lnh_ldh_riesgo_flipi_bajo_check").checked){
			flipi_bajo = 1;
		} else {
			flipi_bajo = 2;
		}

		var flipi_intermedio = 0;
		if(document.getElementById("lnh_ldh_riesgo_flipi_intermedio_bajo_check").checked){
			flipi_intermedio = 1;
		} else {
			flipi_intermedio = 2;
		}

		var flipi_alto = 0;
		if(document.getElementById("lnh_ldh_riesgo_flipi_alto_check").checked){
			flipi_alto = 1;
		} else {
			flipi_alto = 2;
		}

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_pronostico_lnh',
           data:{consulta:consulta, paciente:paciente, ecog:ecog, ldh:ldh, testiculo:testiculo, extra_nodal:extra_nodal, snc:snc, edad_60:edad_60, doble_hit:doble_hit, sintomas_b:sintomas_b, m_osea:m_osea, bulky:bulky, hiv:hiv,  opcion_ripi:opcion_ripi, opcion_flipi:opcion_flipi, opcion_mipi_edad:opcion_mipi_edad, opcion_mipi_ecog:opcion_mipi_ecog, opcion_mipi_ldh:opcion_mipi_ldh, opcion_mipi_leucocitos:opcion_mipi_leucocitos, opcion_mipi_res:opcion_mipi_res, ripi_bajo:ripi_bajo, ripi_bajo_2:ripi_bajo_2, ripi_intermedio:ripi_intermedio, ripi_alto:ripi_alto, flipi_bajo:flipi_bajo, flipi_intermedio:flipi_intermedio, flipi_alto:flipi_alto, _token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_lnh").value == 1)
						mostrarSnackbar("PRONOSTICO LNH GUARDADAS");            		
            	} else {
            		mostrarSnackbar("PRONOSTICO LNH FALLO");            		
            	}
            }
        });
	}

	function cargarImagenesLnh(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;				
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_imagenes_lnh',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){ 
           			document.getElementById("lnh_imagenes_descripcion").value = data.response_data.descripcion;
            	} 
            }
        });
	}

	function cargarBiopsiaCMFLnh(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;				
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_biopsia_lnh',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){ 
           			document.getElementById("lnh_biopsia_cmf_descripcion").value = data.response_data.descripcion;
            	} 
            }
        });
	}

	function cargarEstadioLnh(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;				
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_estadio_lnh',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){ 
           			document.getElementById("lnh_estadio_ann_arbor").value = data.response_data.ann_arbor;
					document.getElementById("lnh_estadio_lugano").value = data.response_data.lugano;
					document.getElementById("lnh_estadio_murphy").value = data.response_data.murphy;
            	} 
            }
        });
	}

	function cargarAntecedentesLnh(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;				
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_antecedentes_lnh',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){ 

					document.getElementById("lnh_antecedentes_serologia_hbv").value = data.response_data.serologia_hbv;
					document.getElementById("lnh_antecedentes_serologia_hcv").value = data.response_data.serologia_hcv;
					document.getElementById("lnh_antecedentes_serologia_hzv").value = data.response_data.serologia_hzv;
					document.getElementById("lnh_antecedentes_serologia_cmv").value = data.response_data.serologia_cmv;
					document.getElementById("lnh_antecedentes_serologia_hiv_4").value = data.response_data.serologia_hiv_4;
					document.getElementById("lnh_antecedentes_serologia_vdrl").value = data.response_data.serologia_vdrl;
		
					if(data.response_data.opcion_antigripal == 0){
						document.getElementById("lnh_antigripal_si").checked = false;
						document.getElementById("lnh_antigripal_no").checked = false;			
					} else {
						if(data.response_data.opcion_antigripal == 1){
							document.getElementById("lnh_antigripal_si").checked = true;
							document.getElementById("lnh_antigripal_no").checked = false;			
						} else {
							document.getElementById("lnh_antigripal_si").checked = false;
							document.getElementById("lnh_antigripal_no").checked = true;			
						}
					}

					if(data.response_data.opcion_antineumococica == 0){
						document.getElementById("lnh_antineumococica_si").checked = false;
						document.getElementById("lnh_antineumococica_no").checked = false;			
					} else {
						if(data.response_data.opcion_antineumococica == 1){
							document.getElementById("lnh_antineumococica_si").checked = true;
							document.getElementById("lnh_antineumococica_no").checked = false;			
						} else {
							document.getElementById("lnh_antineumococica_si").checked = false;
							document.getElementById("lnh_antineumococica_no").checked = true;			
						}
					}		

					var opcion_antecedentes_ecog = data.response_data.opcion_ecog;
					pintarEcogAntecedentesLNH(opcion_antecedentes_ecog);

					document.getElementById("lnh_ant_enf_insuficiencia_cardiaca").value = data.response_data.insuficiencia_cardiaca;	
					document.getElementById("lnh_ant_enf_epoc").value  = data.response_data.epoc;	
					document.getElementById("lnh_ant_enf_insuficiencia_renal").value  = data.response_data.insuficiencia_renal;	
					document.getElementById("lnh_ant_enf_hepatopatia").value  = data.response_data.hepatopatia;	
					document.getElementById("lnh_ant_enf_diabetes").value  = data.response_data.diabetes;	
					document.getElementById("lnh_ant_enf_hiv").value  = data.response_data.hiv;	

					document.getElementById("lnh_score_charlson").value  = data.response_data.score_charlson;	
            	} 
            }
        });
	}

	function cargarPronosticoLnh(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;				
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_pronostico_lnh',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){ 
           			
           			document.getElementById("lnh_pronostico_ecog").value = data.response_data.ecog; 		
					document.getElementById("lnh_pronostico_ldh").value = data.response_data.ldh;
					document.getElementById("lnh_pronostico_testiculo").value = data.response_data.testiculo;
					document.getElementById("lnh_pronostico_extra_nodal").value = data.response_data.extra_nodal_renal;
					document.getElementById("lnh_pronostico_snc").value = data.response_data.snc;
					document.getElementById("lnh_pronostico_edad_60").value = data.response_data.edad_60;
					document.getElementById("lnh_pronostico_doble_hit").value = data.response_data.doble_hit;
					document.getElementById("lnh_pronostico_sintomas_b").value = data.response_data.sintomas_b;
					document.getElementById("lnh_pronostico_m_osea").value = data.response_data.m_osea;
					document.getElementById("lnh_pronostico_bulky").value = data.response_data.bulky;
					document.getElementById("lnh_pronostico_hiv").value = data.response_data.hiv;

					var opcion_ripi = data.response_data.opcion_ripi;
					var opcion_flipi = data.response_data.opcion_flipi;
					var opcion_mipi_edad = data.response_data.opcion_mipi_edad;		
					var opcion_mipi_ecog = data.response_data.opcion_mipi_ecog;	
					var opcion_mipi_ldh = data.response_data.opcion_mipi_ldh;
					var opcion_mipi_leucocitos = data.response_data.opcion_mipi_leucocitos;	

					pintarRipiLnh(opcion_ripi);
					pintarFlipiLnh(opcion_flipi);

					pintarMipiEdadLnh(opcion_mipi_edad);
					pintarMipiEcogLnh(opcion_mipi_ecog);
					pintarMipiLdhLnh(opcion_mipi_ldh);
					pintarMipiLeucocitosLnh(opcion_mipi_leucocitos);
			
					if(data.response_data.checkbox_ripi_riesgo_bajo == 1){
						document.getElementById("lnh_ldh_riesgo_bajo_check").checked = true;			
					} else {
						document.getElementById("lnh_ldh_riesgo_bajo_check").checked = false;			
					}

					if(data.response_data.checkbox_ripi_riesgo_intermedio_bajo == 1){
						document.getElementById("lnh_ldh_riesgo_bajo_2_check").checked = true;			
					} else {
						document.getElementById("lnh_ldh_riesgo_bajo_2_check").checked = false;			
					}
										
					if(data.response_data.checkbox_ripi_riesgo_intermedio_alto == 1){
						document.getElementById("lnh_ldh_riesgo_intermedio_alto_check").checked = true;			
					} else {
						document.getElementById("lnh_ldh_riesgo_intermedio_alto_check").checked = false;			
					}

					if(data.response_data.checkbox_ripi_riesgo_alto == 1){
						document.getElementById("lnh_ldh_riesgo_alto_check").checked = true;			
					} else {
						document.getElementById("lnh_ldh_riesgo_alto_check").checked = false;			
					}

					if(data.response_data.checkbox_flipi_bajo == 1){
						document.getElementById("lnh_ldh_riesgo_flipi_bajo_check").checked = true;			
					} else {
						document.getElementById("lnh_ldh_riesgo_flipi_bajo_check").checked = false;			
					}

					if(data.response_data.checkbox_flipi_intermedio_bajo == 1){
						document.getElementById("lnh_ldh_riesgo_flipi_intermedio_bajo_check").checked = true;			
					} else {
						document.getElementById("lnh_ldh_riesgo_flipi_intermedio_bajo_check").checked = false;			
					}

					if(data.response_data.checkbox_flipi_intermedio_alto == 1){
						document.getElementById("lnh_ldh_riesgo_flipi_alto_check").checked = true;			
					} else {
						document.getElementById("lnh_ldh_riesgo_flipi_alto_check").checked = false;			
					}		
            	} 
            }
        });
	}

</script>
