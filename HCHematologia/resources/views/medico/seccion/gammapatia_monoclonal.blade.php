@if($nueva_consulta != 0)
<div class="card background_panel_consulta_actual" id="seccion_gammapatia_monoclonal_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickGammapatiaMonoclonal()" type="button">Gammapatia Monoclonal</a></b></h4>
	</div>	
@else
	<div id="seccion_gammapatia_monoclonal_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickGammapatiaMonoclonal()" type="button">Gammapatia Monoclonal</a></b></h4>
	</div>	
@endif	
	<input type="hidden" id="guardar_opcion_gm">
	<div id="seccion_gammapatia_monoclonal" hidden>		
		<!-- SECCION IZQUIERDA -->
		<div class="row">
		<div class="col-md-6"> 
			<div class="col-md-12"> 
				
				<div id="seccion_tabla_gm_sangre" class="table-responsive margin_top_5px" style="height:1350px;">
				      	<table class="table table-sm" id="gm_tabla_sangre" name="gm_tabla_sangre">
					       <thead class="fondoNav text-white">
					          <tr>				            
					            <th class="editText table_sin_borde td_size" colspan="2">SANGRE</th>
					          </tr>
					        </thead>
						    <tbody id="gm_tabla_sangre_tbody" name="gm_tabla_sangre_tbody">							
								<tr>
									<th class="td_size letrasNegras">Hto/Hb/VCM</th>
									<td><input id="gm_hto_hb_vcm" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">Leucocitos</th>
									<td><input id="gm_leucocitos" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">Plaquetas</th>
									<td><input id="gm_plaquetas" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">Urea/Creatinina</th>
									<td><input id="gm_urea_creatinina" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">CI Creat ml/min</th>
									<td><input id="gm_ci_creat" type="text" class="form-control input_width_300px"></td>		
								</tr>
								<tr>
									<th class="td_size letrasNegras">Calcemia</th>
									<td><input id="gm_calcemia" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">VSG</th>
									<td><input id="gm_vsg" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">LDH</th>
									<td><input id="gm_ldh" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">B2 microglobulina</th>
									<td><input id="gm_b2_microglobulina" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">Proteinograma</th>
									<td>
										<table class="table table-sm" id="gm_proteinograma_subtabla" name="gm_proteinograma_subtabla">
											<tbody id="gm_subtabla_proteinograma_tbody" name="gm_subtabla_proteinograma_tbody">	
												<tr>
													<th class="td_size letrasNegras">Prot Totales</th>
													<td><input id="gm_prot_totales" type="text" class="form-control input_width_200px"></td>
												</tr>												

												<tr>
													<th class="td_size letrasNegras">Albumina</th>
													<td><input id="gm_albumina" type="text" class="form-control input_width_200px"></td>
												</tr>						

												<tr>
													<th class="td_size letrasNegras">Alfa</th>
													<td><input id="gm_alfa" type="text" class="form-control input_width_200px"></td>
												</tr>					

												<tr>
													<th class="td_size letrasNegras">Beta</th>
													<td><input id="gm_beta" type="text" class="form-control input_width_200px"></td>
												</tr>																										
												<tr>
													<th class="td_size letrasNegras">Gamma</th>
													<td><input id="gm_gamma" type="text" class="form-control input_width_200px"></td>
												</tr>												
												
												<tr>
													<th class="td_size letrasNegras">Obs</th>
													<td><input id="gm_obs" type="text" class="form-control input_width_200px"></td>
												</tr>												
											</tbody>	
										</table>
									</td>
								</tr>

								<tr>
									<th onclick="deseleccionarIssrGm()" class="td_size letrasNegras">ISS - R</th>
									<input hidden id="opcion_issr_gm" value="0">
									<td>
										<table class="table table-sm" id="gm_issr_subtabla" name="gm_issr_subtabla">
											<tbody id="gm_subtabla_issr_tbody" name="gm_subtabla_issr_tbody">	
												<tr>
													<th id="gm_issr_1" onclick="pintarIrssrGm(1)" class="td_size letrasNegras">B2 micro < 3,5 y alb >= 3,5; LDH normal</th>													
												</tr>												

												<tr>
													<th id="gm_issr_2" onclick="pintarIrssrGm(2)" class="td_size letrasNegras">B2 micro 3,5 - 5,5</th>
												</tr>						

												<tr>
													<th id="gm_issr_3" onclick="pintarIrssrGm(3)" class="td_size letrasNegras">B2 micro > 5,5; LDH alta; citog alto riesgo</th>			
												</tr>					
											</tbody>	
										</table>
									</td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">Dosaje IgG</th>
									<td><input id="gm_dosaje_igg" type="text" class="form-control input_width_300px"></td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">Dosaje IgA</th>
									<td><input id="gm_dosaje_iga" type="text" class="form-control input_width_300px"></td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">Dosaje IgM</th>
									<td><input id="gm_dosaje_igm" type="text" class="form-control input_width_300px"></td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">Dosaje Ig D</th>
									<td><input id="gm_dosaje_igd" type="text" class="form-control input_width_300px"></td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">Dosaje Ig E</th>
									<td><input id="gm_dosaje_ige" type="text" class="form-control input_width_300px"></td>
								</tr>

								<tr>
									<th class="td_size letrasNegras"><b>Inmunofijacion</b></th>
									<td><input id="gm_inmunofijacion" type="text" class="form-control input_width_300px"></td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">K libre / L libre</th>
									<td><input id="gm_klibre_llibre" type="text" class="form-control input_width_300px"></td>
								</tr>
								
								<tr>
									<th class="td_size letrasNegras">Componente M</th>
									<td><input id="gm_componente_m" type="text" class="form-control input_width_300px"></td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">B cross-laps</th>
									<td><input id="gm_dosaje_b_cross_laps" type="text" class="form-control input_width_300px"></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div id="seccion_tabla_gm_orina" class="table-responsive margin_top_5px" style="height:350px;">
				      	<table class="table table-sm" id="gm_tabla_orina" name="gm_tabla_orina">
					       <thead class="fondoNav text-white">
					          <tr>				            
					            <th class="editText table_sin_borde td_size" colspan="2">ORINA</th>
					          </tr>
					        </thead>
						    <tbody id="gm_tabla_orina_tbody" name="gm_tabla_orina_tbody">							
								<tr>
									<th class="td_size letrasNegras">Proteinuria</th>
									<td><input id="gm_proteinuria" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">Proteinograma</th>
									<td><input id="gm_proteinograma" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">IF Orina</th>
									<td><input id="gm_if_orina" type="text" class="form-control input_width_300px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">Comp M/Bence Jones</th>
									<td><input id="gm_comp_mbence_jones" type="text" class="form-control input_width_300px"></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-md-12"> 
					<h4>Oseo (RX - RMN - PET)</h4>					
						@include('medico.dibujos.gammapatia_monoclonal_dibujo')
					</div>

			</div>
		</div> <!-- SECCION IZQUIERDA FIN-->	

		<!-- SECCION DERECHA -->
		<div class="col-md-6"> 
			<div class="col-md-12"> 

				<div id="seccion_tabla_gm_medula_osea" class="table-responsive margin_top_5px" style="height:475px;">
				      	<table class="table table-sm" id="gm_tabla_medula_osea" name="gm_tabla_medula_osea">
					       <thead class="fondoNav text-white">
					          <tr>				            
					            <th class="editText table_sin_borde td_size" colspan="2">Medula Osea</th>
					          </tr>
					        </thead>
						    <tbody id="gm_tabla_medula_osea_tbody" name="gm_tabla_medula_osea_tbody">							
								<tr>
									<th class="td_size letrasNegras">CMF</th>
									<td>
										<table class="table table-sm" id="gm_cmf_subtabla" name="gm_cmf_subtabla">
											<tbody id="gm_subtabla_cmf_tbody" name="gm_subtabla_cmf_tbody">	
												<tr>
													<th class="td_size letrasNegras">Plasmocitos</th>
													<td><input id="gm_plasmocitos" type="text" class="form-control input_width_200px"></td>
												</tr>												

												<tr>
													<th class="td_size letrasNegras">% aberrantes</th>
													<td><input id="gm_aberrantes" type="text" class="form-control input_width_200px"></td>
												</tr>																			
											</tbody>	
										</table>									
									</td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">CITOGENETICO (alto riesgo,*)</th>
									<td>
										<table class="table table-sm" id="gm_citogenetico_subtabla" name="gm_citogenetico_subtabla">
											<tbody id="gm_subtabla_citogenetico_tbody" name="gm_subtabla_citogenetico_tbody">	
												<tr>
													<th class="td_size letrasNegras">Bandeo G</th>
													<td><input id="gm_bandeo_g" type="text" class="form-control input_width_200px"></td>
												</tr>												
												<tr>
													<th class="td_size letrasNegras">FISH del(17p)</th>
													<td><input id="gm_fish_17" type="text" class="form-control input_width_200px"></td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">FISH 1q</th>
													<td><input id="gm_fish_1" type="text" class="form-control input_width_200px"></td>
												</tr>						
												<tr>
													<th class="td_size letrasNegras">FISH 14q32</th>
													<td><input id="gm_fish_14" type="text" class="form-control input_width_200px"></td>
												</tr>													
											</tbody>	
										</table>									
									</td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">BIOPSIA</th>
									<td>
										<table class="table table-sm" id="gm_biopsia_subtabla" name="gm_biopsia_subtabla">
											<tbody id="gm_subtabla_biopsia_tbody" name="gm_subtabla_biopsia_tbody">	
												<tr>
													<th class="td_size letrasNegras">Plasmocitos %</th>
													<td><input id="gm_biopsia_plasmocitos" type="text" class="form-control input_width_200px"></td>
												</tr>																			
											</tbody>	
										</table>									
									</td>
								</tr>

							</tbody>
						</table>
					</div>


					<div id="seccion_tabla_gm_ant_personales" class="table-responsive margin_top_5px" style="height:1350px;">
				      	<table class="table table-sm" id="gm_tabla_ant_personales" name="gm_tabla_ant_personales">
					       <thead class="fondoNav text-white">
					          <tr>				            
					            <th class="editText table_sin_borde td_size" colspan="2">Antecedentes Personales</th>
					          </tr>
					        </thead>
						    <tbody id="gm_tabla_ant_personales_tbody" name="gm_tabla_ant_personales_tbody">						
								<tr>
									<th class="td_size letrasNegras">Serologia</th>
									<td>
										<table class="table table-sm" id="gm_serologia_subtabla" name="gm_serologia_subtabla">
											<tbody id="gm_subtabla_serologia_tbody" name="gm_subtabla_serologia_tbody">	
												<tr>
													<th class="td_size letrasNegras">HBV</th>
													<td><input id="gm_serologia_hbv" type="text" class="form-control input_width_250px"></td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">HCV</th>
													<td><input id="gm_serologia_hcv" type="text" class="form-control input_width_250px"></td>
												</tr>							
												<tr>
													<th class="td_size letrasNegras">HZV</th>
													<td><input id="gm_serologia_hzv" type="text" class="form-control input_width_250px"></td>
												</tr>					
												<tr>
													<th class="td_size letrasNegras">CMV</th>
													<td><input id="gm_serologia_cmv" type="text" class="form-control input_width_250px"></td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">HIV 4º</th>
													<td><input id="gm_serologia_hiv_4" type="text" class="form-control input_width_250px"></td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">VDRL</th>
													<td><input id="gm_serologia_vdrl" type="text" class="form-control input_width_250px"></td>
												</tr>
											</tbody>	
										</table>									
									</td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">Inmunizacion</th>
									<td>
										<table class="table table-sm" id="gm_inmunizacion_subtabla" name="gm_inmunizacion_subtabla">
											<tbody id="gm_subtabla_inmunizacion_tbody" name="gm_subtabla_inmunizacion_tbody">	
												<tr>
													<th class="td_size letrasNegras">Antigripal</th>
													<td>
														<div class="custom-control custom-radio r_inline">
												  			<input type="radio" id="gm_antigripal_si" name="gm_antigripal_group" class="custom-control-input">
												  			<label class="custom-control-label td_size letrasNegras" for="gm_antigripal_si">SI</label>
														</div>
														<div class="custom-control custom-radio r_inline">
												 			<input type="radio" id="gm_antigripal_no" name="gm_antigripal_group" class="custom-control-input">			
												 			<label class="custom-control-label td_size letrasNegras" for="gm_antigripal_no">NO</label>
														</div>
													</td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">Antineumococica</th>
													<td>
														<div class="custom-control custom-radio r_inline">
												  			<input type="radio" id="gm_antineumococica_si" name="gm_antineumococica_group" class="custom-control-input">
												  			<label class="custom-control-label td_size letrasNegras" for="gm_antineumococica_si">SI</label>
														</div>
														<div class="custom-control custom-radio r_inline">
												 			<input type="radio" id="gm_antineumococica_no" name="gm_antineumococica_group" class="custom-control-input">				
												 			<label class="custom-control-label td_size letrasNegras" for="gm_antineumococica_no">NO</label>
														</div>
													</td>
												</tr>																			
											</tbody>	
										</table>									
									</td>
								</tr>

								<tr>
									<th onclick="deseleccionarEcogGm()" class="td_size letrasNegras">ECOG Performance Status</th>
									<input hidden id="opcion_ecog_gm" value=99>
									<td>
										<table class="table table-sm" id="gm_ecog_subtabla" name="gm_ecog_subtabla">
											<tbody id="gm_subtabla_ecog_tbody" name="gm_subtabla_ecog_tbody">	
												<tr>
													<th id="gm_ecog_0" onclick="pintarEcogGm(0)" class="td_size letrasNegras">0</th>
													<th class="td_size letrasNegras">Sin Repercusion</th>
												</tr>
												<tr>
													<th id="gm_ecog_1" onclick="pintarEcogGm(1)" class="td_size letrasNegras">1</th>
													<th class="td_size letrasNegras">Tolera actividad diaria</th>
												</tr>
												<tr>
													<th id="gm_ecog_2" onclick="pintarEcogGm(2)" class="td_size letrasNegras">2</th>
													<th class="td_size letrasNegras">Menos de la mitad del tiempo despierto en silla o cama</th>
												</tr>
												<tr>
													<th id="gm_ecog_3" onclick="pintarEcogGm(3)" class="td_size letrasNegras">3</th>
													<th class="td_size letrasNegras">Mas de la mitad del tiempo despierto en silla o cama</th>
												</tr>
												<tr>
													<th id="gm_ecog_4" onclick="pintarEcogGm(4)" class="td_size letrasNegras">4</th>
													<th class="td_size letrasNegras">Confinado a silla o cama</th>
												</tr>
												<tr>
													<th id="gm_ecog_5" onclick="pintarEcogGm(5)" class="td_size letrasNegras">5</th>
													<th class="td_size letrasNegras">Muerte</th>
												</tr>
											</tbody>	
										</table>									
									</td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">Antecedentes de enfermedad</th>
									<td>
										<table class="table table-sm" id="gm_ant_enfermedad_subtabla" name="gm_ant_enfermedad_subtabla">
											<tbody id="gm_subtabla_ant_enfermedad_tbody" name="gm_subtabla_ant_enfermedad_tbody">	
												<tr>
													<th class="td_size letrasNegras">Insuficiencia cardiaca</th>
													<td><input id="gm_ant_enfermedad_insuficiencia_cardiaca" type="text" class="form-control input_width_200px"></td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">EPOC</th>
													<td><input id="gm_ant_enfermedad_epoc" type="text" class="form-control input_width_200px"></td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">Insuficiencia renal</th>
													<td><input id="gm_ant_enfermedad_insuficiencia_renal" type="text" class="form-control input_width_200px"></td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">Hepatopatia</th>
													<td><input id="gm_ant_enfermedad_hepatopatia" type="text" class="form-control input_width_200px"></td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">Diabetes</th>
													<td><input id="gm_ant_enfermedad_diabetes" type="text" class="form-control input_width_200px"></td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">HIV</th>
													<td><input id="gm_ant_enfermedad_hiv" type="text" class="form-control input_width_200px"></td>
												</tr>
												<tr>
													<th class="td_size letrasNegras">Otro</th>
													<td><input id="gm_ant_enfermedad_otro" type="text" class="form-control input_width_200px"></td>
												</tr>
											</tbody>	
										</table>									
									</td>
								</tr>

								<tr>
									<th class="td_size letrasNegras">Score de Charlson</th>
									<td>
										<table class="table table-sm" id="gm_score_charlson_subtabla" name="gm_score_charlson_subtabla">
											<tbody id="gm_subtabla_score_charlson_tbody" name="gm_subtabla_score_charlson_tbody">	
												<tr>
													<th class="td_size letrasNegras">Puntaje</th>
													<td><input id="gm_score_charlson_puntaje" type="text" class="form-control input_width_250px"></td>
												</tr>												
											</tbody>	
										</table>									
									</td>
								</tr>

								<tr>
									<th onclick="deseleccionarIndiceKatzGm()" class="td_size letrasNegras">Indice de Katz</th>
									<input hidden id="opcion_indice_katz_gm_1">									
									<input hidden id="opcion_indice_katz_gm_2">									
									<input hidden id="opcion_indice_katz_gm_3">									
									<input hidden id="opcion_indice_katz_gm_4">									
									<input hidden id="opcion_indice_katz_gm_5">									
									<td>
										<table class="table table-sm" id="gm_indice_katz_subtabla" name="gm_indice_katz_subtabla">
											<tbody id="gm_subtabla_indice_katz_tbody" name="gm_subtabla_indice_katz_tbody">	
												<tr>
													<th class="td_size letrasNegras">Baño</th>
													<th id="gm_indice_katz_1d" onclick="pintarIndiceKatz(1, 1)" class="td_size letrasNegras">D</th>
													<th id="gm_indice_katz_1i" onclick="pintarIndiceKatz(1, 2)" class="td_size letrasNegras">I</th>										
												</tr>												
												<tr>
													<th class="td_size letrasNegras">Vestimenta</th>
													<th id="gm_indice_katz_2d" onclick="pintarIndiceKatz(2, 1)" class="td_size letrasNegras">D</th>
													<th id="gm_indice_katz_2i" onclick="pintarIndiceKatz(2, 2)" class="td_size letrasNegras">I</th>										
												</tr>											
												<tr>
													<th class="td_size letrasNegras">Movilidad</th>
													<th id="gm_indice_katz_3d" onclick="pintarIndiceKatz(3, 1)" class="td_size letrasNegras">D</th>
													<th id="gm_indice_katz_3i" onclick="pintarIndiceKatz(3, 2)" class="td_size letrasNegras">I</th>										
												</tr>										
												<tr>
													<th class="td_size letrasNegras">Continencia</th>
													<th id="gm_indice_katz_4d" onclick="pintarIndiceKatz(4, 1)" class="td_size letrasNegras">D</th>
													<th id="gm_indice_katz_4i" onclick="pintarIndiceKatz(4, 2)" class="td_size letrasNegras">I</th>										
												</tr>											
												<tr>
													<th class="td_size letrasNegras">Alimentacion</th>
													<th id="gm_indice_katz_5d" onclick="pintarIndiceKatz(5, 1)" class="td_size letrasNegras">D</th>
													<th id="gm_indice_katz_5i" onclick="pintarIndiceKatz(5, 2)" class="td_size letrasNegras">I</th>										
												</tr>																
											</tbody>	
										</table>									
									</td>
								</tr>

							</tbody>
						</table>
					</div>


					<div id="seccion_tabla_gm_orina" class="table-responsive margin_top_5px" style="height:150px;">
				      	<table class="table table-sm" id="gm_tabla_orina" name="gm_tabla_orina">
					       <thead class="fondoNav text-white">
					          <tr>				            
					            <th class="editText table_sin_borde td_size" colspan="2">DIAGNOSTICO</th>
					          </tr>
					        </thead>
						    <tbody id="gm_tabla_orina_tbody" name="gm_tabla_orina_tbody">							
								<tr>
									<td class="td_size letrasNegras">
										<textarea class="form-control width450px_cel margin_left_5px" id="gm_diagnostico_descripcion" name="gm_diagnostico_descripcion" rows="4" cols="30" placeholder="Escriba aqui una descripcion"></textarea>
									</td>								
								</tr>								
							</tbody>
						</table>
					</div>

					<div id="seccion_tabla_gm_tratamiento" class="table-responsive margin_top_5px" style="height:300px;">
				      	<table class="table table-sm" id="gm_tabla_tratamiento" name="gm_tabla_tratamiento">
					       <thead class="fondoNav text-white">
					          <tr>				            
					            <th class="editText table_sin_borde td_size" colspan="2">TRATAMIENTO</th>
					          </tr>
					        </thead>
						    <tbody id="gm_tabla_tratamiento" name="gm_tabla_tratamiento_tbody">							
								<tr>
									<th class="td_size letrasNegras">RVD</th>
									<td><input id="gm_tratamiento_rvd" type="text" class="form-control input_width_350px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">RD</th>
									<td><input id="gm_tratamiento_rd" type="text" class="form-control input_width_350px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">CyBorD</th>
									<td><input id="gm_tratamiento_cybord" type="text" class="form-control input_width_350px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">MPV</th>
									<td><input id="gm_tratamiento_mpv" type="text" class="form-control input_width_350px"></td>
								</tr>
								<tr>
									<th class="td_size letrasNegras">MP</th>
									<td><input id="gm_tratamiento_mp" type="text" class="form-control input_width_350px"></td>
								</tr>
							</tbody>
						</table>
					</div>

			</div>
		</div> <!-- SECCION DERECHA FIN -->
	</div>
		<br>	
		@if($nueva_consulta != 0)
		<div class="row contenedor3">
		  <div class="contenido3">
		  	<br>
		  	<br>
		    <button type="button" id="btn_id_guardarGammapatiaMonoclonal" onclick="guardarGammapatiaMonoclonal(1)" class="rodri_button">GUARDAR</button>
		  </div>
		</div>
		@endif
	</div>	
</div>

<div id="seccion_gammapatia_monoclonal_consulta" hidden>			
</div>

<script type="text/javascript">
	
	function clickGammapatiaMonoclonal(){
		seccionPrincipal = document.getElementById("seccion_gammapatia_monoclonal");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	function guardarGammapatiaMonoclonal(opcion){
		document.getElementById("guardar_opcion_gm").value = opcion;
		guardarSangreGm();
		guardarOrinaGm();
		guardarMedulaOseaGm();
		guardarAntecedentesPersonalesGm();
		guardarDiagnosticoGm();
		guardarTratamientoGm();	
		guardarTipoEstudioConsulta(3);		
	}

	function cargarConsultasPreviasGm(){
		var paciente = document.getElementById("paciente_id").value;		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_consultas_previas_gm',
           data:{paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response == 1){           			           			           			
					cargarSangreGm(data.response_data.id);
					cargarOrinaGm(data.response_data.id);
					cargarMedulaOseaGm(data.response_data.id);
					cargarAntecedentesPersonalesGm(data.response_data.id);
					cargarDiagnosticoGm(data.response_data.id);
					cargarTratamientoGm(data.response_data.id);
					// cargarImagenGm(null, paciente);
					if(document.getElementById("seccion_boton_gammapatia_monoclonal")!=null){
						document.getElementById("seccion_boton_gammapatia_monoclonal").hidden = false;
					}
           		} else {
           			if(document.getElementById("seccion_boton_gammapatia_monoclonal")!=null){
						document.getElementById("seccion_boton_gammapatia_monoclonal").hidden = true;
					}
           		}
            }
        });	   
	}

	function cargarDatosGammapatiaMonoclonal(){
		cargarSangreGm();
		cargarOrinaGm();
		cargarMedulaOseaGm();
		cargarAntecedentesPersonalesGm();
		cargarDiagnosticoGm();
		cargarTratamientoGm();
	}

	function cargarGammapatiaMonoclonal(){
		var consulta_id = document.getElementById("consulta_id").value;
		var tipo_estudio = 3;
		$.ajax({
             type:'POST',
             dataType:'JSON',
             url:'/cargar_tipo_estudio_consulta',
             data:{tipo_estudio:tipo_estudio, consulta_id:consulta_id, _token: '{{csrf_token()}}'},
             success:function(data) { 
             	if(data.response == 1){
             		document.getElementById("seccion_gammapatia_monoclonal_nueva_consulta").hidden = false;
             		cargarSangreGm();
					cargarOrinaGm();
					cargarMedulaOseaGm();
					cargarAntecedentesPersonalesGm();
					cargarDiagnosticoGm();
					cargarTratamientoGm();	
             	} else {
             		document.getElementById("seccion_gammapatia_monoclonal_nueva_consulta").hidden = true;
             	}		
              }
          });
	}

	function deseleccionarIssrGm(){	
		$("#gm_issr_1").attr("class", "td_size letrasNegras unselected_item");				
		$("#gm_issr_2").attr("class", "td_size letrasNegras unselected_item");						
		$("#gm_issr_3").attr("class", "td_size letrasNegras unselected_item");		
		document.getElementById("opcion_issr_gm").value = -1;		
	}
	
	function pintarIrssrGm(opcion){	
		deseleccionarIssrGm();		
		if(opcion == 1){
			$("#gm_issr_1").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 2){
			$("#gm_issr_2").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 3){
			$("#gm_issr_3").attr("class", "td_size letrasNegras selected_item");				
		}				
		document.getElementById("opcion_issr_gm").value = opcion;					
	}

	function deseleccionarEcogGm(){	
		$("#gm_ecog_0").attr("class", "td_size letrasNegras unselected_item");		
		$("#gm_ecog_1").attr("class", "td_size letrasNegras unselected_item");				
		$("#gm_ecog_2").attr("class", "td_size letrasNegras unselected_item");						
		$("#gm_ecog_3").attr("class", "td_size letrasNegras unselected_item");		
		$("#gm_ecog_4").attr("class", "td_size letrasNegras unselected_item");		
		$("#gm_ecog_5").attr("class", "td_size letrasNegras unselected_item");		
		document.getElementById("opcion_ecog_gm").value = -1;		
	}
	
	function pintarEcogGm(opcion){	
		deseleccionarEcogGm();		
		if(opcion == 0){
			$("#gm_ecog_0").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 1){
			$("#gm_ecog_1").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 2){
			$("#gm_ecog_2").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 3){
			$("#gm_ecog_3").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 4){
			$("#gm_ecog_4").attr("class", "td_size letrasNegras selected_item");				
		}
		if(opcion == 5){
			$("#gm_ecog_5").attr("class", "td_size letrasNegras selected_item");				
		}						
		document.getElementById("opcion_ecog_gm").value = opcion;					
	}

	function deseleccionarIndiceKatzGm() {
		$("#gm_indice_katz_1d").attr("class", "td_size letrasNegras unselected_item");		
		$("#gm_indice_katz_1i").attr("class", "td_size letrasNegras unselected_item");		
		
		$("#gm_indice_katz_2d").attr("class", "td_size letrasNegras unselected_item");		
		$("#gm_indice_katz_2i").attr("class", "td_size letrasNegras unselected_item");		

		$("#gm_indice_katz_3d").attr("class", "td_size letrasNegras unselected_item");		
		$("#gm_indice_katz_3i").attr("class", "td_size letrasNegras unselected_item");		

		$("#gm_indice_katz_4d").attr("class", "td_size letrasNegras unselected_item");		
		$("#gm_indice_katz_4i").attr("class", "td_size letrasNegras unselected_item");		

		$("#gm_indice_katz_5d").attr("class", "td_size letrasNegras unselected_item");		
		$("#gm_indice_katz_5i").attr("class", "td_size letrasNegras unselected_item");		

		document.getElementById("opcion_indice_katz_gm_1").value = -1;			
		document.getElementById("opcion_indice_katz_gm_2").value = -1;			
		document.getElementById("opcion_indice_katz_gm_3").value = -1;			
		document.getElementById("opcion_indice_katz_gm_4").value = -1;			
		document.getElementById("opcion_indice_katz_gm_5").value = -1;			
	}

	function pintarIndiceKatz(fila, opcion){
		if(fila == 1){
			if(opcion == 1){
				$("#gm_indice_katz_1d").attr("class", "td_size letrasNegras selected_item");				
				$("#gm_indice_katz_1i").attr("class", "td_size letrasNegras unselected_item");				
				document.getElementById("opcion_indice_katz_gm_1").value = 1;			
			} else {
				$("#gm_indice_katz_1i").attr("class", "td_size letrasNegras selected_item");				
				$("#gm_indice_katz_1d").attr("class", "td_size letrasNegras unselected_item");				
				document.getElementById("opcion_indice_katz_gm_1").value = 2;			
			}
		}

		if(fila == 2){
			if(opcion == 1){
				$("#gm_indice_katz_2d").attr("class", "td_size letrasNegras selected_item");				
				$("#gm_indice_katz_2i").attr("class", "td_size letrasNegras unselected_item");				
				document.getElementById("opcion_indice_katz_gm_2").value = 1;			
			} else {
				$("#gm_indice_katz_2i").attr("class", "td_size letrasNegras selected_item");				
				$("#gm_indice_katz_2d").attr("class", "td_size letrasNegras unselected_item");				
				document.getElementById("opcion_indice_katz_gm_2").value = 2;
			}
		}

		if(fila == 3){
			if(opcion == 1){
				$("#gm_indice_katz_3d").attr("class", "td_size letrasNegras selected_item");				
				$("#gm_indice_katz_3i").attr("class", "td_size letrasNegras unselected_item");				
				document.getElementById("opcion_indice_katz_gm_3").value = 1;
			} else {
				$("#gm_indice_katz_3i").attr("class", "td_size letrasNegras selected_item");				
				$("#gm_indice_katz_3d").attr("class", "td_size letrasNegras unselected_item");				
				document.getElementById("opcion_indice_katz_gm_3").value = 2;
			}
		}

		if(fila == 4){
			if(opcion == 1){
				$("#gm_indice_katz_4d").attr("class", "td_size letrasNegras selected_item");				
				$("#gm_indice_katz_4i").attr("class", "td_size letrasNegras unselected_item");				
				document.getElementById("opcion_indice_katz_gm_4").value = 1;
			} else {
				$("#gm_indice_katz_4i").attr("class", "td_size letrasNegras selected_item");				
				$("#gm_indice_katz_4d").attr("class", "td_size letrasNegras unselected_item");				
				document.getElementById("opcion_indice_katz_gm_4").value = 2;
			}
		}

		if(fila == 5){
			if(opcion == 1){
				$("#gm_indice_katz_5d").attr("class", "td_size letrasNegras selected_item");				
				$("#gm_indice_katz_5i").attr("class", "td_size letrasNegras unselected_item");				
				document.getElementById("opcion_indice_katz_gm_5").value = 1;
			} else {
				$("#gm_indice_katz_5i").attr("class", "td_size letrasNegras selected_item");				
				$("#gm_indice_katz_5d").attr("class", "td_size letrasNegras unselected_item");				
				document.getElementById("opcion_indice_katz_gm_5").value = 2;
			}
		}
	}


	function guardarSangreGm() {
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		var hto_hb_vcm = document.getElementById("gm_hto_hb_vcm").value;
		var leucocitos = document.getElementById("gm_leucocitos").value;
		var plaquetas = document.getElementById("gm_plaquetas").value;
		var urea_creatinina = document.getElementById("gm_urea_creatinina").value;
		var ci_creat = document.getElementById("gm_ci_creat").value;
		var calcemia = document.getElementById("gm_calcemia").value;
		var vsg = document.getElementById("gm_vsg").value;
		var ldh = document.getElementById("gm_ldh").value;
		var b2_microglobulina = document.getElementById("gm_b2_microglobulina").value;
		var prot_totales = document.getElementById("gm_prot_totales").value;
		var albumina = document.getElementById("gm_albumina").value;
		var alfa = document.getElementById("gm_alfa").value;
		var beta = document.getElementById("gm_beta").value;
		var gamma = document.getElementById("gm_gamma").value;
		var obs = document.getElementById("gm_obs").value;

		var opcion_issr = document.getElementById("opcion_issr_gm").value;
		var dosaje_igg = document.getElementById("gm_dosaje_igg").value;
		var dosaje_iga = document.getElementById("gm_dosaje_iga").value;
		var dosaje_igm = document.getElementById("gm_dosaje_igm").value;
		var dosaje_igd = document.getElementById("gm_dosaje_igd").value;
		var dosaje_ige = document.getElementById("gm_dosaje_ige").value;
		var inmunofijacion = document.getElementById("gm_inmunofijacion").value;
		var klibre_llibre = document.getElementById("gm_klibre_llibre").value;
		var componente_m = document.getElementById("gm_componente_m").value;
		var dosaje_b_cross_laps = document.getElementById("gm_dosaje_b_cross_laps").value;

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_sangre_gm',
           data:{consulta:consulta, paciente:paciente, hto_hb_vcm:hto_hb_vcm, leucocitos:leucocitos, plaquetas:plaquetas, urea_creatinina:urea_creatinina,ci_creat:ci_creat, calcemia:calcemia, vsg:vsg, ldh:ldh, b2_microglobulina:b2_microglobulina, prot_totales:prot_totales, albumina:albumina, alfa:alfa, beta:beta, gamma:gamma, obs:obs, opcion_issr:opcion_issr, dosaje_igg:dosaje_igg, dosaje_iga:dosaje_iga, dosaje_igm:dosaje_igm, dosaje_igd:dosaje_igd, dosaje_ige:dosaje_ige, inmunofijacion:inmunofijacion, klibre_llibre:klibre_llibre, componente_m:componente_m, dosaje_b_cross_laps:dosaje_b_cross_laps,  _token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_gm").value == 1)
						mostrarSnackbar("SANGRE GM GUARDADO");            		
            	} else {
            		mostrarSnackbar("SANGRE GM FALLO");            		
            	}
            }
        });	
	}

	function guardarOrinaGm() {
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		var proteinuria = document.getElementById("gm_proteinuria").value;
		var proteinograma = document.getElementById("gm_proteinograma").value;
		var if_orina = document.getElementById("gm_if_orina").value;
		var comp_mbence_jones = document.getElementById("gm_comp_mbence_jones").value;

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_orina_gm',
           data:{consulta:consulta, paciente:paciente, proteinuria:proteinuria, proteinograma:proteinograma, if_orina:if_orina, comp_mbence_jones:comp_mbence_jones,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_gm").value == 1)
						mostrarSnackbar("ORINA GM GUARDADO");            		
            	} else {
            		mostrarSnackbar("ORINA GM FALLO");            		
            	}
            }
        });			
	}

	function guardarMedulaOseaGm() {
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		var plasmocitos = document.getElementById("gm_plasmocitos").value;
		var aberrantes = document.getElementById("gm_aberrantes").value;
		var bandeo_g = document.getElementById("gm_bandeo_g").value;
		var fish_17 = document.getElementById("gm_fish_17").value;
		var fish_1 = document.getElementById("gm_fish_1").value;
		var fish_14 = document.getElementById("gm_fish_14").value;
		var biopsia_plasmocitos = document.getElementById("gm_biopsia_plasmocitos").value;
		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_medula_osea_gm',
           data:{consulta:consulta, paciente:paciente, plasmocitos:plasmocitos, aberrantes:aberrantes, bandeo_g:bandeo_g, fish_17:fish_17, fish_1:fish_1, fish_14:fish_14, biopsia_plasmocitos:biopsia_plasmocitos, _token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_gm").value == 1)
						mostrarSnackbar("MEDULA OSEA GM GUARDADO");            		
            	} else {
            		mostrarSnackbar("MEDUAL OSEA GM FALLO");            		
            	}
            }
        });			
	}

	function guardarAntecedentesPersonalesGm() {
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		var serologia_hbv = document.getElementById("gm_serologia_hbv").value;
		var serologia_hcv = document.getElementById("gm_serologia_hcv").value;
		var serologia_hzv = document.getElementById("gm_serologia_hzv").value;
		var serologia_cmv = document.getElementById("gm_serologia_cmv").value;
		var serologia_hiv_4 = document.getElementById("gm_serologia_hiv_4").value;
		var serologia_vdrl = document.getElementById("gm_serologia_vdrl").value;
			
		var antigripal = 0;
		if(document.getElementById("gm_antigripal_si").checked){
			antigripal = 1;
		} 
		if(document.getElementById("gm_antigripal_no").checked){
			antigripal = 2;
		}

		var antineumococica = 0;
		if(document.getElementById("gm_antineumococica_si").checked){
			antineumococica = 1;
		} 
		if(document.getElementById("gm_antineumococica_no").checked){
			antineumococica = 2;
		}

		var opcion_ecog = document.getElementById("opcion_ecog_gm").value;

		var insuficiencia_cardiaca = document.getElementById("gm_ant_enfermedad_insuficiencia_cardiaca").value;
		var epoc = document.getElementById("gm_ant_enfermedad_epoc").value;		
		var insuficiencia_renal = document.getElementById("gm_ant_enfermedad_insuficiencia_renal").value;
		var hepatopatia = document.getElementById("gm_ant_enfermedad_hepatopatia").value;
		var diabetes = document.getElementById("gm_ant_enfermedad_diabetes").value;
		var hiv = document.getElementById("gm_ant_enfermedad_hiv").value;
		var otro = document.getElementById("gm_ant_enfermedad_otro").value;

		var score_charlson_puntaje = document.getElementById("gm_score_charlson_puntaje").value;		

		var opcion_indice_katz_gm_1 = document.getElementById("opcion_indice_katz_gm_1").value;		
		var opcion_indice_katz_gm_2 = document.getElementById("opcion_indice_katz_gm_2").value;		
		var opcion_indice_katz_gm_3 = document.getElementById("opcion_indice_katz_gm_3").value;		
		var opcion_indice_katz_gm_4 = document.getElementById("opcion_indice_katz_gm_4").value;		
		var opcion_indice_katz_gm_5 = document.getElementById("opcion_indice_katz_gm_5").value;	

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_antecedentes_personales_gm',
           data:{consulta:consulta, paciente:paciente, serologia_hbv:serologia_hbv, serologia_hcv:serologia_hcv, serologia_hzv:serologia_hzv, serologia_cmv:serologia_cmv, serologia_hiv_4:serologia_hiv_4, serologia_vdrl:serologia_vdrl, antigripal:antigripal, antineumococica:antineumococica, opcion_ecog:opcion_ecog, insuficiencia_cardiaca:insuficiencia_cardiaca, epoc:epoc, insuficiencia_renal:insuficiencia_renal, hepatopatia:hepatopatia, diabetes:diabetes, hiv:hiv, otro:otro, score_charlson_puntaje:score_charlson_puntaje, opcion_indice_katz_gm_1:opcion_indice_katz_gm_1, opcion_indice_katz_gm_2:opcion_indice_katz_gm_2, opcion_indice_katz_gm_3:opcion_indice_katz_gm_3, opcion_indice_katz_gm_4:opcion_indice_katz_gm_4, opcion_indice_katz_gm_5:opcion_indice_katz_gm_5, _token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_gm").value == 1)
						mostrarSnackbar("ANTECEDENTES PERSONALES GM GUARDADO");            		
            	} else {
            		mostrarSnackbar("ANTECEDENTES PERSONALES GM FALLO");            		
            	}
            }
        });				
	}	

	function guardarDiagnosticoGm() {
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		var descripcion = document.getElementById("gm_diagnostico_descripcion").value;

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_diagnostico_gm',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion, _token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_gm").value == 1)
						mostrarSnackbar("DIAGNOSTICO GM GUARDADO");            		
            	} else {
            		mostrarSnackbar("DIAGNOSTICO GM FALLO");            		
            	}
            }
        });		
	}

	function guardarTratamientoGm() {
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		var rvd = document.getElementById("gm_tratamiento_rvd").value;
		var rd = document.getElementById("gm_tratamiento_rd").value;
		var cybord = document.getElementById("gm_tratamiento_cybord").value;
		var mpv = document.getElementById("gm_tratamiento_mpv").value;
		var mp = document.getElementById("gm_tratamiento_mp").value;
	
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_tratamiento_gm',
           data:{consulta:consulta, paciente:paciente, rvd:rvd, rd:rd, cybord:cybord, mpv:mpv, mp:mp, _token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response == 1){
           			if(document.getElementById("guardar_opcion_gm").value == 1)
						mostrarSnackbar("TRATAMIENTO GM GUARDADO");            		
            	} else {
            		mostrarSnackbar("TRATAMIENTO GM FALLO");            		
            	}
            }
        });	
	}

	function cargarSangreGm(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_sangre_gm',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){ 
           			document.getElementById("gm_hto_hb_vcm").value = data.response_data.hto_hb_vcm;
					document.getElementById("gm_leucocitos").value = data.response_data.leucocitos;
					document.getElementById("gm_plaquetas").value = data.response_data.plaquetas;
					document.getElementById("gm_urea_creatinina").value = data.response_data.urea_creatinina;
					document.getElementById("gm_ci_creat").value = data.response_data.ci_creat_ml_min;
					document.getElementById("gm_calcemia").value = data.response_data.calcemia;
					document.getElementById("gm_vsg").value = data.response_data.vsg;
					document.getElementById("gm_ldh").value = data.response_data.ldh;
					document.getElementById("gm_b2_microglobulina").value = data.response_data.b2_microglobulina;
					document.getElementById("gm_prot_totales").value = data.response_data.proteinograma_prot_totales;
					document.getElementById("gm_albumina").value = data.response_data.proteinograma_albumina;
					document.getElementById("gm_alfa").value = data.response_data.proteinograma_alfa;
					document.getElementById("gm_beta").value = data.response_data.proteinograma_beta;
					document.getElementById("gm_gamma").value = data.response_data.proteinograma_gamma;
					document.getElementById("gm_obs").value = data.response_data.proteinograma_obs;

					var opcion_issr = data.response_data.opcion_issr; 
					pintarIrssrGm(opcion_issr);
		
					document.getElementById("gm_dosaje_igg").value = data.response_data.dosaje_igg;
					document.getElementById("gm_dosaje_iga").value = data.response_data.dosaje_iga;
					document.getElementById("gm_dosaje_igm").value = data.response_data.dosaje_igm;
					document.getElementById("gm_dosaje_igd").value = data.response_data.dosaje_igd;
					document.getElementById("gm_dosaje_ige").value = data.response_data.dosaje_ige;
					document.getElementById("gm_inmunofijacion").value = data.response_data.inmunofijacion;
					document.getElementById("gm_klibre_llibre").value = data.response_data.k_libre_l_libre;
					document.getElementById("gm_componente_m").value = data.response_data.componente_m;
					document.getElementById("gm_dosaje_b_cross_laps").value = data.response_data.b_cross_laps;

            	} 
            }
        });		
	}

	function cargarOrinaGm(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_orina_gm',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){            			
           			document.getElementById("gm_proteinuria").value = data.response_data.proteinuria;
					document.getElementById("gm_proteinograma").value = data.response_data.proteinograma;
					document.getElementById("gm_if_orina").value = data.response_data.if_orina;
					document.getElementById("gm_comp_mbence_jones").value = data.response_data.comp_m_bence_jones;
            	} 
            }
        });
	}

	function cargarMedulaOseaGm(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_medula_osea_gm',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){            			           			
					document.getElementById("gm_plasmocitos").value = data.response_data.cmf_plasmocitos;
					document.getElementById("gm_aberrantes").value = data.response_data.cmf_aberrantes;
					document.getElementById("gm_bandeo_g").value = data.response_data.citogenetico_bandeo_g;
					document.getElementById("gm_fish_17").value = data.response_data.citogenetico_fish_17p;
					document.getElementById("gm_fish_1").value = data.response_data.citogenetico_fish_1q;
					document.getElementById("gm_fish_14").value = data.response_data.citogenetico_fish_14q_32;
					document.getElementById("gm_biopsia_plasmocitos").value = data.response_data.biopsia_plasmocitos;
            	} 
            }
        });
	}

	function cargarAntecedentesPersonalesGm(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_antecedentes_personales_gm',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){            			           			
										
					document.getElementById("gm_serologia_hbv").value = data.response_data.serologia_hbv;
					document.getElementById("gm_serologia_hcv").value = data.response_data.serologia_hcv;
					document.getElementById("gm_serologia_hzv").value = data.response_data.serologia_hzv;
					document.getElementById("gm_serologia_cmv").value = data.response_data.serologia_cmv;
					document.getElementById("gm_serologia_hiv_4").value = data.response_data.serologia_hiv_4;
					document.getElementById("gm_serologia_vdrl").value = data.response_data.serologia_vdrl;
				
					if(data.response_data.antigripal == 1){
						document.getElementById("gm_antigripal_si").checked = true;
						document.getElementById("gm_antigripal_no").checked = false;
					} else {
						document.getElementById("gm_antigripal_si").checked = false;
						document.getElementById("gm_antigripal_no").checked = true;
					}

					if(data.response_data.antineumococica == 1){
						document.getElementById("gm_antineumococica_si").checked = true;
						document.getElementById("gm_antineumococica_no").checked = false;
					} else {
						document.getElementById("gm_antineumococica_no").checked = true;
						document.getElementById("gm_antineumococica_si").checked = false;
					}

					var opcion_ecog = data.response_data.opcion_ecog;
					pintarEcogGm(opcion_ecog);

					document.getElementById("gm_ant_enfermedad_insuficiencia_cardiaca").value = data.response_data.ant_enfermedad_insuficiencia_cardiaca;
					document.getElementById("gm_ant_enfermedad_epoc").value = data.response_data.ant_enfermedad_epoc;;
					document.getElementById("gm_ant_enfermedad_insuficiencia_renal").value = data.response_data.ant_enfermedad_insuficiencia_renal;
					document.getElementById("gm_ant_enfermedad_hepatopatia").value = data.response_data.ant_enfermedad_hepatopatia;
					document.getElementById("gm_ant_enfermedad_diabetes").value = data.response_data.ant_enfermedad_diabetes;
					document.getElementById("gm_ant_enfermedad_hiv").value = data.response_data.ant_enfermedad_hiv;
					document.getElementById("gm_ant_enfermedad_otro").value = data.response_data.ant_enfermedad_otro;

					document.getElementById("gm_score_charlson_puntaje").value = data.response_data.score_charlson_puntaje;

					var katz_banio = data.response_data.indice_katz_banio;
					if(katz_banio != -1)
						pintarIndiceKatz(1, katz_banio);

					var katz_vestimenta = data.response_data.indice_katz_vestimenta;
					if(katz_vestimenta != -1)
						pintarIndiceKatz(2, katz_vestimenta);

					var katz_movilidad = data.response_data.indice_katz_movilidad;
					if(katz_movilidad != -1)
						pintarIndiceKatz(3, katz_movilidad);

					var katz_continencia = data.response_data.indice_katz_continencia;
					if(katz_continencia != -1)
						pintarIndiceKatz(4, katz_continencia);

					var katz_alimentacion = data.response_data.indice_katz_alimentacion;
					if(katz_alimentacion != -1)
						pintarIndiceKatz(5, katz_alimentacion);	
            	} 
            }
        });
	}

	function cargarDiagnosticoGm(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_diagnostico_gm',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){            			           							
					document.getElementById("gm_diagnostico_descripcion").value = data.response_data.descripcion;
            	} 
            }
        });
	}

	function cargarTratamientoGm(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_tratamiento_gm',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){            			           											
					document.getElementById("gm_tratamiento_rvd").value = data.response_data.rvd;
					document.getElementById("gm_tratamiento_rd").value = data.response_data.rd;
					document.getElementById("gm_tratamiento_cybord").value = data.response_data.cybord;
					document.getElementById("gm_tratamiento_mpv").value = data.response_data.mpv;
					document.getElementById("gm_tratamiento_mp").value = data.response_data.mp;
            	} 
            }
        });
	}

		

</script>
