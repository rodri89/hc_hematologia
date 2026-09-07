@if($nueva_consulta != 0)
<form class="card background_panel_consulta_actual" id="seccion_planilla_mielodisplasia_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickPlanillaMielodisplasia()" type="button">Sindrome Mielodisplásico</a></b></h4>
	</div>	
@else
	<form id="seccion_planilla_mielodisplasia_nueva_consulta">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickPlanillaMielodisplasia()" type="button">Sindrome Mielodisplásico</a></b></h4>
	</div>	
@endif	
	<div id="seccion_planilla_mielodisplasia" hidden>		
		<div class="row">
			<div class="col-md-12">
				<div id="seccion_tabla_pm_estudios_diagnosticos" class="table-responsive margin_top_5px" style="height:900px;">
					<table class="table table-sm" id="pm_tabla_estudios_diagnosticos" name="pm_tabla_estudios_diagnosticos">
				       <thead class="fondoNav text-white">
				          <tr>				            
				            <th colspan="7" class="editText table_sin_borde td_size">ESTUDIOS DIAGNOSTICOS</th>                              
				            <th class="table_sin_borde"></th>                              
				          </tr>
				        </thead>
					    <tbody id="pm_tabla_estudios_diagnosticos_tbody" name="pm_tabla_estudios_diagnosticos_tbody">
							<tr>
								<th class="td_size letrasNegras">Fecha</th>
								<td><input type="text" class="form-control datepicker editText" name="pm_ed_fecha_1" id="pm_ed_fecha_1" value="{{str_replace('-','/',$date)}}" required autocomplete="off"></td>		
								<th class="td_size letrasNegras">Fecha</th>
								<td><input type="text" class="form-control datepicker editText" name="pm_ed_fecha_2" id="pm_ed_fecha_2" value="{{str_replace('-','/',$date)}}" required autocomplete="off"></td>		

								<th colspan="4" class="td_size letrasNegras">Biopsia MO</th>									
							</tr>				          			

							<tr>
								<th class="td_size letrasNegras">Hto/Hb</th>
								<td><input id="pm_estudios_diagnostico_hto_hb" type="text" class="form-control input_width_110px"></td>
								<th class="td_size letrasNegras">HIV</th>
								<td><input id="pm_estudios_diagnostico_hiv" type="text" class="form-control input_width_110px"></td>

								<td colspan="4" class="td_size letrasNegras">
									<textarea class="form-control width450px_cel margin_left_5px" id="pm_estudios_diagnostico_biopsia_mo" name="pm_estudios_diagnostico_biopsia_mo" rows="2" cols="40" placeholder="Escriba aqui una descripcion para Biopsia MO"></textarea>			
								</td>										
							</tr>

							<tr>
								<th class="td_size letrasNegras">VCM</th>
								<td><input id="pm_estudios_diagnostico_vcm" type="text" class="form-control input_width_110px"></td>
								<th class="td_size letrasNegras">VDRL</th>
								<td><input id="pm_estudios_diagnostico_vdrl" type="text" class="form-control input_width_110px"></td>

								<th colspan="4" class="td_size letrasNegras">Citogenetico</th>									
							</tr>

							<tr>
								<th class="td_size letrasNegras">GB/PMN</th>
								<td><input id="pm_estudios_diagnostico_gb_pmn" type="text" class="form-control input_width_110px"></td>
								<th class="td_size letrasNegras">HBV</th>
								<td><input id="pm_estudios_diagnostico_hbv" type="text" class="form-control input_width_110px"></td>

								<td colspan="4" class="td_size letrasNegras">
									<textarea class="form-control width450px_cel margin_left_5px" id="pm_estudios_diagnostico_citogenetico" name="pm_estudios_diagnostico_citogenetico" rows="2" cols="40" placeholder="Escriba aqui una descripcion para Citogenetico"></textarea>			
								</td>										
							</tr>

							<tr>
								<th class="td_size letrasNegras">Plaquetas</th>
								<td><input id="pm_estudios_diagnostico_plaquetas" type="text" class="form-control input_width_110px"></td>
								<th class="td_size letrasNegras">HCV</th>
								<td><input id="pm_estudios_diagnostico_hcv" type="text" class="form-control input_width_110px"></td>

								<th colspan="4" class="td_size letrasNegras">Categoria WHO (2016)</th>							
							</tr>

							<tr>
								<th class="td_size letrasNegras">Albumina</th>
								<td><input id="pm_estudios_diagnostico_albumina" type="text" class="form-control input_width_110px"></td>
								<th class="td_size letrasNegras">Otro</th>
								<td><input id="pm_estudios_diagnostico_otro" type="text" class="form-control input_width_110px"></td>

								<td colspan="4" class="td_size letrasNegras">
									<textarea class="form-control width450px_cel margin_left_5px" id="pm_estudios_diagnostico_categoria_who" name="pm_estudios_diagnostico_categoria_who" rows="2" cols="40" placeholder="Escriba aqui una descripcion para Categoria WHO (2016)"></textarea>		
								</td>										
							</tr>

							<tr>
								<th class="td_size letrasNegras">LDH</th>
								<td><input id="pm_estudios_diagnostico_ldh" type="text" class="form-control input_width_110px"></td>
								<th class="td_size letrasNegras">G y F</th>
								<td><input id="pm_estudios_diagnostico_gyf" type="text" class="form-control input_width_110px"></td>

								<th colspan="2" class="td_size letrasNegras">Puntaje IPSS - R</th>							
								<td colspan="2" class="td_size letrasNegras"><input id="pm_estudios_diagnostico_puntaje_ipssr" type="text" class="form-control input_width_450px"></td>							
							</tr>

							<tr>
								<th class="td_size letrasNegras">ERS</th>
								<td><input id="pm_estudios_diagnostico_ers" type="text" class="form-control input_width_110px"></td>
								<th class="td_size letrasNegras">PCD</th>
								<td><input id="pm_estudios_diagnostico_pcd" type="text" class="form-control input_width_110px"></td>

								<th colspan="2" class="td_size letrasNegras">Mortalidad</th>							
								<td colspan="2" class="td_size letrasNegras"><input id="pm_estudios_diagnostico_mortalidad" type="text" class="form-control input_width_450px"></td>							
							</tr>

							<tr>
								<th class="td_size letrasNegras">Ferremia</th>
								<td><input id="pm_estudios_diagnostico_ferremia" type="text" class="form-control input_width_110px"></td>
								<th class="td_size letrasNegras">PCI</th>
								<td><input id="pm_estudios_diagnostico_pci" type="text" class="form-control input_width_110px"></td>

								<th colspan="2" class="td_size letrasNegras">Progresion Leucemia</th>							
								<td colspan="2" class="td_size letrasNegras"><input id="pm_estudios_diagnostico_progresion_leucemia" type="text" class="form-control input_width_450px"></td>							
							</tr>

							<tr>
								<th class="td_size letrasNegras">Ferritina</th>
								<td><input id="pm_estudios_diagnostico_ferritina" type="text" class="form-control input_width_110px"></td>
								<td class="td_size letrasNegras"></td>
								<td class="td_size letrasNegras"></td>

								<th colspan="2" class="td_size letrasNegras">Score de Charlson</th>							
								<td colspan="2" class="td_size letrasNegras"><input id="pm_estudios_diagnostico_score_charlson" type="text" class="form-control input_width_450px"></td>							
							</tr>

							<tr>
								<th class="td_size letrasNegras">Transferrina</th>
								<td><input id="pm_estudios_diagnostico_transferrina" type="text" class="form-control input_width_110px"></td>
								<td class="td_size letrasNegras"></td>
								<td class="td_size letrasNegras"></td>

								<th colspan="4" class="td_size letrasNegras">Comorbilidades (detallar)</th>						
							</tr>

							<tr>
								<th class="td_size letrasNegras">Sat. Transf</th>
								<td><input id="pm_estudios_diagnostico_sat_transf" type="text" class="form-control input_width_110px"></td>
								<td class="td_size letrasNegras"></td>
								<td class="td_size letrasNegras"></td>

								<td colspan="4" class="td_size letrasNegras">
									<textarea class="form-control width450px_cel margin_left_5px" id="pm_estudios_diagnostico_comorbilidades" name="pm_estudios_diagnostico_comorbilidades" rows="2" cols="40" placeholder="Escriba aqui una descripcion para Comorbilidades (detallar)"></textarea>		
								</td>						
							</tr>

							<tr>
								<th class="td_size letrasNegras">Dosaje EPO</th>
								<td><input id="pm_estudios_diagnostico_dosaje_epo" type="text" class="form-control input_width_110px"></td>
								<td class="td_size letrasNegras"></td>
								<td class="td_size letrasNegras"></td>

								<td colspan="4" class="td_size letrasNegras"></td>						
							</tr>

						</tbody>
					</table>
				</div>

				<div id="seccion_tabla_pm_tratamiento" class="table-responsive margin_top_5px" style="height:200px;">
					<table class="table table-sm" id="pm_tabla_tratamiento" name="pm_tabla_tratamiento">
				       <thead class="fondoNav text-white">
				          <tr>				            
				            <th class="editText table_sin_borde td_size">TRATAMIENTO</th>                              			
				          </tr>
				        </thead>
					    <tbody id="pm_tabla_tratamiento_tbody" name="pm_tabla_tratamiento_tbody">
							<tr>
								<td class="td_size letrasNegras">
									<textarea class="form-control margin_left_5px" id="pm_tratamiento_detalle" name="pm_tratamiento_detalle" rows="4" cols="80" placeholder="Escriba aqui una descripcion para TRATAMIENTO"></textarea>		
								</td>														
							</tr>				          			
						</tbody>
					</table>
				</div>


				<div id="seccion_tabla_pm_ipss_r" class="table-responsive margin_top_5px" style="height:240px;">
					<table class="table table-sm" id="pm_tabla_ipss_r" name="pm_tabla_ipss_r">
				       <thead class="fondoNav text-white">
				          <tr>				            
				            <th colspan="8" class="editText table_sin_borde td_size">IPSS - R</th>                              
				          </tr>
				        </thead>
					    <tbody id="pm_tabla_ipss_r_tbody" name="pm_tabla_ipss_r_tbody">
							<tr>
								<th class="td_size letrasNegras">Puntos</th>
								<th class="td_size letrasNegras">0</th>
								<th class="td_size letrasNegras">0,5</th>
								<th class="td_size letrasNegras">1</th>
								<th class="td_size letrasNegras">1,5</th>
								<th class="td_size letrasNegras">2</th>
								<th class="td_size letrasNegras">3</th>
								<th class="td_size letrasNegras">4</th>
							</tr>

							<input hidden id="opcion_ipssr_fila_1" value="-1">
							<tr>
								<th onclick="deseleccionarIpssrFila(1)" class="td_size letrasNegras">Riesgo CTG</th>
								<th id="fila_1_1" onclick="pintarIpssr(1,1)" class="td_size letrasNegras">Muy bueno</th>
								<th class="td_size letrasNegras"></th>
								<th id="fila_1_2" onclick="pintarIpssr(1,2)" class="td_size letrasNegras">Bueno</th>
								<th class="td_size letrasNegras"></th>
								<th id="fila_1_3" onclick="pintarIpssr(1,3)" class="td_size letrasNegras">Intermedio</th>
								<th id="fila_1_4" onclick="pintarIpssr(1,4)" class="td_size letrasNegras">Pobre</th>
								<th id="fila_1_5" onclick="pintarIpssr(1,5)" class="td_size letrasNegras">Muy pobre</th>
							</tr>				          			

							<input hidden id="opcion_ipssr_fila_2" value="-1"> 
							<tr>	
								<th onclick="deseleccionarIpssrFila(2)" class="td_size letrasNegras">Blastos</th>
								<th id="fila_2_1" onclick="pintarIpssr(2,1)" class="td_size letrasNegras">0 - 2</th>
								<th class="td_size letrasNegras"></th>
								<th id="fila_2_2" onclick="pintarIpssr(2,2)" class="td_size letrasNegras">3 - 4,9 </th>
								<th class="td_size letrasNegras"></th>
								<th id="fila_2_3" onclick="pintarIpssr(2,3)" class="td_size letrasNegras">5 - 10</th>
								<th id="fila_2_4" onclick="pintarIpssr(2,4)" class="td_size letrasNegras">>10</th>
								<th class="td_size letrasNegras"></th>
							</tr>

							<input hidden id="opcion_ipssr_fila_3" value="-1">
							<tr>
								<th onclick="deseleccionarIpssrFila(3)" class="td_size letrasNegras">Hb (g/dl)</th>
								<th id="fila_3_1" onclick="pintarIpssr(3,1)" class="td_size letrasNegras">> 10</th>
								<th class="td_size letrasNegras"></th>
								<th id="fila_3_2" onclick="pintarIpssr(3,2)" class="td_size letrasNegras">8 - 9,9</th>
								<th id="fila_3_3" onclick="pintarIpssr(3,3)" class="td_size letrasNegras">< 8</th>
								<th class="td_size letrasNegras"></th>
								<th class="td_size letrasNegras"></th>
								<th class="td_size letrasNegras"></th>
							</tr>

							<input hidden id="opcion_ipssr_fila_4" value="-1">
							<tr>
								<th onclick="deseleccionarIpssrFila(4)" class="td_size letrasNegras">Pqt (mm3)</th>
								<th id="fila_4_1" onclick="pintarIpssr(4,1)" class="td_size letrasNegras">>100.000</th>
								<th id="fila_4_2" onclick="pintarIpssr(4,2)" class="td_size letrasNegras">50 - 99 mil</th>
								<th id="fila_4_3" onclick="pintarIpssr(4,3)" class="td_size letrasNegras"><50</th>
								<th class="td_size letrasNegras"></th>
								<th class="td_size letrasNegras"></th>
								<th class="td_size letrasNegras"></th>
								<th class="td_size letrasNegras"></th>
							</tr>

							<input hidden id="opcion_ipssr_fila_5" value="-1">
							<tr>
								<th onclick="deseleccionarIpssrFila(5)" class="td_size letrasNegras">Neutrofilos</th>
								<th id="fila_5_1" onclick="pintarIpssr(5,1)" class="td_size letrasNegras">>800</th>
								<th id="fila_5_2" onclick="pintarIpssr(5,2)" class="td_size letrasNegras"><800</th>
								<th class="td_size letrasNegras"></th>
								<th class="td_size letrasNegras"></th>
								<th class="td_size letrasNegras"></th>
								<th class="td_size letrasNegras"></th>
								<th class="td_size letrasNegras"></th>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div id="seccion_tabla_pm_citogenetico" class="table-responsive margin_top_5px" style="height:300px;">
							<table class="table table-sm" id="pm_tabla_citogenetico" name="pm_tabla_citogenetico">
						       <thead class="fondoNav text-white">
						          <tr>				            
						            <th colspan="3" class="editText table_sin_borde td_size">CITOGENÉTICO</th>
						          </tr>
						        </thead>
							    <tbody id="pm_tabla_citogenetico_tbody" name="pm_tabla_citogenetico_tbody">
									<tr>
										<th class="td_size letrasNegras">Muy bueno</th>											<th class="td_size letrasNegras">Del (11q) -Y</th>										
										<th class="td_size letrasNegras">4%</th>
									</tr>
									<tr>
										<th class="td_size letrasNegras">Bueno</th>
										<th class="td_size letrasNegras">Normal, Del (20p). del(20q)</th>
										<th class="td_size letrasNegras">72%</th>
									</tr>
									<tr>
										<th class="td_size letrasNegras">Intermedio</th>
										<th class="td_size letrasNegras">Del (7q). +8. i(17q). +19</th>
										<th class="td_size letrasNegras">13%</th>
									</tr>
									<tr>
										<th class="td_size letrasNegras">Pobre</th>
										<th class="td_size letrasNegras">7. alteraciones que incluyan -7 o del(7q). Cariotipo complejo (hasta 3 alteraciones) </th>
										<th class="td_size letrasNegras">4%</th>
									</tr>
									<tr>
										<th class="td_size letrasNegras">Muy pobre</th>
										<th class="td_size letrasNegras">Cariotipo complejo (>3 alteraciones)</th>
										<th class="td_size letrasNegras">7%</th>
									</tr>
								</tbody>
							</table>
						</div>
					
					</div>

					<div class="col-md-6">
						<div id="seccion_tabla_pm_citogenetico" class="table-responsive margin_top_5px" style="height:300px;">
							<table class="table table-sm" id="pm_tabla_citogenetico" name="pm_tabla_citogenetico">
						       <thead class="fondoNav text-white">
						          <tr>				            
						            <th colspan="4" class="editText table_sin_borde td_size">PUNTAJE</th>
						          </tr>
						        </thead>
							    <tbody id="pm_tabla_citogenetico_tbody" name="pm_tabla_citogenetico_tbody">

							    	<input hidden id="opcion_puntaje" value="-1">
									<tr>
										<th onclick="deseleccionarPuntajePm()" class="td_size letrasNegras"></th>
										<th class="td_size letrasNegras">Puntaje</th>
										<th class="td_size letrasNegras">Sobrevida (años)</th>
										<th class="td_size letrasNegras">Progresion a LMA (años)</th>
									</tr>
									<tr id="pm_puntaje_fila_1" onclick="pintarPuntajeFila(1)">
										<th class="td_size letrasNegras">Muy bajo</th>
										<th class="td_size letrasNegras">0 - 1,5</th>
										<th class="td_size letrasNegras">8,8</th>
										<th class="td_size letrasNegras"></th>
									</tr>
									<tr id="pm_puntaje_fila_2" onclick="pintarPuntajeFila(2)">
										<th class="td_size letrasNegras">Bajo</th>
										<th class="td_size letrasNegras">1,5 - 3</th>
										<th class="td_size letrasNegras">5,3</th>
										<th class="td_size letrasNegras">10,8</th>
									</tr>
									<tr id="pm_puntaje_fila_3" onclick="pintarPuntajeFila(3)">
										<th class="td_size letrasNegras">Intermedio</th>
										<th class="td_size letrasNegras">3 - 4,5</th>
										<th class="td_size letrasNegras">3</th>
										<th class="td_size letrasNegras">3,2</th>
									</tr>
									<tr id="pm_puntaje_fila_4" onclick="pintarPuntajeFila(4)">
										<th class="td_size letrasNegras">Alto</th>
										<th class="td_size letrasNegras">4,5 - 6</th>
										<th class="td_size letrasNegras">1,6</th>
										<th class="td_size letrasNegras">1,4</th>
									</tr>
									<tr id="pm_puntaje_fila_5" onclick="pintarPuntajeFila(5)">
										<th class="td_size letrasNegras">Muy alto</th>
										<th class="td_size letrasNegras">>6</th>
										<th class="td_size letrasNegras">0,8</th>
										<th class="td_size letrasNegras">0,73</th>
									</tr>
								</tbody>
							</table>
						</div>	
					</div>
				</div>

			</div>
		</div>
			<br>	
			@if($nueva_consulta != 0)
		<div class="row contenedor3">
		  <div class="contenido3">
		  	<br>
		  	<br>
		    <button type="button" id="btn_id_guardarPlanillaMieldosplasia" onclick="guardarPlanillaMielodisplasia(1)" class="rodri_button">GUARDAR</button>
		  </div>
		</div>	
		@endif
	</div>
</form>

<div id="seccion_planilla_mielodisplasia_consulta" hidden>			
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

	
	function clickPlanillaMielodisplasia(){
		seccionPrincipal = document.getElementById("seccion_planilla_mielodisplasia");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	function guardarPlanillaMielodisplasia(){
		guardarEstudiosDiagnosticosPm();
		guardarTratamientoPm();
		guardarIpssrPm();
		guardarPuntajePm();
		guardarTipoEstudioConsulta(4);		
	}

	function cargarConsultasPreviasPm(){
		var paciente = document.getElementById("paciente_id").value;		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_consultas_previas_pm',
           data:{paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response == 1){           			           			           							
					cargarEstudiosDiagnosticosPm(data.response_data.id);
             		cargarTratamientoPm(data.response_data.id);
					cargarIpssrPm(data.response_data.id);
					cargarPuntajePm(data.response_data.id);

					if(document.getElementById("seccion_boton_planilla_mielodisplasia")!=null){
						document.getElementById("seccion_boton_planilla_mielodisplasia").hidden = false;
					}
           		} else {
           			if(document.getElementById("seccion_boton_planilla_mielodisplasia")!=null){
						document.getElementById("seccion_boton_planilla_mielodisplasia").hidden = true;
					}
           		}       	
            }
        });	   
	}

	function cargarPlanillaMielodisplasia(){
		var consulta_id = document.getElementById("consulta_id").value;
		var tipo_estudio = 4;
		$.ajax({
             type:'POST',
             dataType:'JSON',
             url:'/cargar_tipo_estudio_consulta',
             data:{tipo_estudio:tipo_estudio, consulta_id:consulta_id, _token: '{{csrf_token()}}'},
             success:function(data) { 
             	if(data.response == 1){
             		document.getElementById("seccion_planilla_mielodisplasia_nueva_consulta").hidden = false;
             		cargarEstudiosDiagnosticosPm();
             		cargarTratamientoPm();
					cargarIpssrPm();
					cargarPuntajePm();
             	} else {
             		document.getElementById("seccion_planilla_mielodisplasia_nueva_consulta").hidden = true;
             	}		
              }
          });
	}

	function deseleccionarIpssrFila(filaNum){
		if(filaNum == 1){
			$("#fila_1_1").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_1_2").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_1_3").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_1_4").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_1_5").attr("class", "td_size letrasNegras unselected_item");
			document.getElementById("opcion_ipssr_fila_1").value = -1;							
		}
		if(filaNum == 2){
			$("#fila_2_1").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_2_2").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_2_3").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_2_4").attr("class", "td_size letrasNegras unselected_item");							
			document.getElementById("opcion_ipssr_fila_2").value = -1;							
		}
		if(filaNum == 3){
			$("#fila_3_1").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_3_2").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_3_3").attr("class", "td_size letrasNegras unselected_item");						
			document.getElementById("opcion_ipssr_fila_3").value = -1;								
		}
		if(filaNum == 4){
			$("#fila_4_1").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_4_2").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_4_3").attr("class", "td_size letrasNegras unselected_item");					
			document.getElementById("opcion_ipssr_fila_4").value = -1;							
		}
		if(filaNum == 5){
			$("#fila_5_1").attr("class", "td_size letrasNegras unselected_item");				
			$("#fila_5_2").attr("class", "td_size letrasNegras unselected_item");							
			document.getElementById("opcion_ipssr_fila_5").value = -1;							
		}
	}

	function pintarIpssr(fila, opcion){		
		if(fila == 1){
			deseleccionarIpssrFila(1);
			if(opcion == 1){				
				$("#fila_1_1").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_1").value = 1;			
			}
			if(opcion == 2){				
				$("#fila_1_2").attr("class", "td_size letrasNegras selected_item");							
				document.getElementById("opcion_ipssr_fila_1").value = 2;			
			}
			if(opcion == 3){
				$("#fila_1_3").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_1").value = 3;			
			} 
			if(opcion == 4){
				$("#fila_1_4").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_1").value = 4;			
			}
			if(opcion == 5){
				$("#fila_1_5").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_1").value = 5;			
			}			
		}
		if(fila == 2){
			deseleccionarIpssrFila(2);
			if(opcion == 1){
				$("#fila_2_1").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_2").value = 1;			
			}
			if(opcion == 2){
				$("#fila_2_2").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_2").value = 2;			
			}
			if(opcion == 3){
				$("#fila_2_3").attr("class", "td_size letrasNegras selected_item");							
				document.getElementById("opcion_ipssr_fila_2").value = 3;			
			}
			if(opcion == 4){
				$("#fila_2_4").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_2").value = 4;			
			}
		}
		if(fila == 3){
			deseleccionarIpssrFila(3);
			if(opcion == 1){
				$("#fila_3_1").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_3").value = 1;			
			}
			if(opcion == 2){
				$("#fila_3_2").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_3").value = 2;			
			}
			if(opcion == 3){
				$("#fila_3_3").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_3").value = 3;			
			}		
		}

		if(fila == 4){
			deseleccionarIpssrFila(4);
			if(opcion == 1){
				$("#fila_4_1").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_4").value = 1;			
			}
			if(opcion == 2){
				$("#fila_4_2").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_4").value = 2;			
			}
			if(opcion == 3){
				$("#fila_4_3").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_4").value = 3;			
			}		
		}

		if(fila == 5){
			deseleccionarIpssrFila(5);
			if(opcion == 1){
				$("#fila_5_1").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_5").value = 1;			
			}
			if(opcion == 2){
				$("#fila_5_2").attr("class", "td_size letrasNegras selected_item");								
				document.getElementById("opcion_ipssr_fila_5").value = 2;			
			}			
		}

	}

	function deseleccionarPuntajePm(){
		$("#pm_puntaje_fila_1").attr("class", "td_size letrasNegras unselected_item");	
		$("#pm_puntaje_fila_2").attr("class", "td_size letrasNegras unselected_item");	
		$("#pm_puntaje_fila_3").attr("class", "td_size letrasNegras unselected_item");	
		$("#pm_puntaje_fila_4").attr("class", "td_size letrasNegras unselected_item");	
		$("#pm_puntaje_fila_5").attr("class", "td_size letrasNegras unselected_item");	
		document.getElementById("opcion_puntaje").value = -1;
	}

	function pintarPuntajeFila(fila){
		deseleccionarPuntajePm();
		if(fila == 1){
			$("#pm_puntaje_fila_1").attr("class", "td_size letrasNegras selected_item");								
			document.getElementById("opcion_puntaje").value = 1;										
		}
		if(fila == 2){
			$("#pm_puntaje_fila_2").attr("class", "td_size letrasNegras selected_item");								
			document.getElementById("opcion_puntaje").value = 2;										
		}		
		if(fila == 3){
			$("#pm_puntaje_fila_3").attr("class", "td_size letrasNegras selected_item");								
			document.getElementById("opcion_puntaje").value = 3;										
		}
		if(fila == 4){
			$("#pm_puntaje_fila_4").attr("class", "td_size letrasNegras selected_item");								
			document.getElementById("opcion_puntaje").value = 4;										
		}
		if(fila == 5){
			$("#pm_puntaje_fila_5").attr("class", "td_size letrasNegras selected_item");								
			document.getElementById("opcion_puntaje").value = 5;										
		}
	}

	function guardarEstudiosDiagnosticosPm(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

		var fecha1 = document.getElementById("pm_ed_fecha_1").value;
		var fecha2 = document.getElementById("pm_ed_fecha_2").value;
		var hto_hb = document.getElementById("pm_estudios_diagnostico_hto_hb").value;
		var hiv = document.getElementById("pm_estudios_diagnostico_hiv").value;
		var biopsia_mo = document.getElementById("pm_estudios_diagnostico_biopsia_mo").value;
		var vcm = document.getElementById("pm_estudios_diagnostico_vcm").value;
		var vdrl = document.getElementById("pm_estudios_diagnostico_vdrl").value;
		var gb_pmn = document.getElementById("pm_estudios_diagnostico_gb_pmn").value;
		var hbv = document.getElementById("pm_estudios_diagnostico_hbv").value;
		var citogenetico = document.getElementById("pm_estudios_diagnostico_citogenetico").value;
		var plaquetas = document.getElementById("pm_estudios_diagnostico_plaquetas").value;
		var hcv = document.getElementById("pm_estudios_diagnostico_hcv").value;
		var albumina = document.getElementById("pm_estudios_diagnostico_albumina").value;
		var otro = document.getElementById("pm_estudios_diagnostico_otro").value;
		var categoria_who = document.getElementById("pm_estudios_diagnostico_categoria_who").value;
		var ldh = document.getElementById("pm_estudios_diagnostico_ldh").value;
		var gyf = document.getElementById("pm_estudios_diagnostico_gyf").value;
		var puntaje_ipssr = document.getElementById("pm_estudios_diagnostico_puntaje_ipssr").value;
		var ers = document.getElementById("pm_estudios_diagnostico_ers").value;	
		var pcd = document.getElementById("pm_estudios_diagnostico_pcd").value;
		var mortalidad = document.getElementById("pm_estudios_diagnostico_mortalidad").value;
		var ferremia = document.getElementById("pm_estudios_diagnostico_ferremia").value;
		var pci = document.getElementById("pm_estudios_diagnostico_pci").value;
		var progresion_leucemia = document.getElementById("pm_estudios_diagnostico_progresion_leucemia").value;
		var ferritina = document.getElementById("pm_estudios_diagnostico_ferritina").value;
		var score_charlson = document.getElementById("pm_estudios_diagnostico_score_charlson").value;
		var transferrina = document.getElementById("pm_estudios_diagnostico_transferrina").value;
		var sat_transf = document.getElementById("pm_estudios_diagnostico_sat_transf").value;
		var comorbilidades = document.getElementById("pm_estudios_diagnostico_comorbilidades").value;
		var dosaje_epo = document.getElementById("pm_estudios_diagnostico_dosaje_epo").value;

		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_estudio_diagnostico_pm',
           data:{consulta:consulta, paciente:paciente, fecha1:fecha1, fecha2:fecha2, hto_hb:hto_hb, hiv:hiv, biopsia_mo:biopsia_mo, vcm:vcm, vdrl:vdrl, gb_pmn:gb_pmn, hbv:hbv, citogenetico:citogenetico, plaquetas:plaquetas, hcv:hcv, albumina:albumina, otro:otro, categoria_who:categoria_who, ldh:ldh, gyf:gyf, puntaje_ipssr:puntaje_ipssr, ers:ers, pcd:pcd, mortalidad:mortalidad, ferremia:ferremia, pci:pci, progresion_leucemia:progresion_leucemia, ferritina:ferritina, score_charlson:score_charlson, transferrina:transferrina, sat_transf:sat_transf, comorbilidades:comorbilidades, dosaje_epo:dosaje_epo ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			mostrarSnackbar("ESTUDIO DIAGNOSTICO GUARDADO");            		
            	} else {
            		mostrarSnackbar("ESTUDIO DIAGNOSTICO FALLO");            		
            	}
            }
        });		
	}

	function guardarTratamientoPm(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

		var descripcion = document.getElementById("pm_tratamiento_detalle").value;
				
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_tratamiento_pm',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			mostrarSnackbar("TRATAMIENTO GUARDADO");            		
            	} else {
            		mostrarSnackbar("TRATAMIENTO FALLO");            		
            	}
            }
        });		
	}

	function guardarIpssrPm(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

		var opcion_fila_1 = document.getElementById("opcion_ipssr_fila_1").value;
		var opcion_fila_2 = document.getElementById("opcion_ipssr_fila_2").value;
		var opcion_fila_3 = document.getElementById("opcion_ipssr_fila_3").value;
		var opcion_fila_4 = document.getElementById("opcion_ipssr_fila_4").value;
		var opcion_fila_5 = document.getElementById("opcion_ipssr_fila_5").value;
					
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_ipssr_pm',
           data:{consulta:consulta, paciente:paciente, opcion_fila_1:opcion_fila_1, opcion_fila_2:opcion_fila_2, opcion_fila_3:opcion_fila_3, opcion_fila_4:opcion_fila_4, opcion_fila_5:opcion_fila_5 ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			mostrarSnackbar("IPSS-R GUARDADO");            		
            	} else {
            		mostrarSnackbar("IPSS-R FALLO");            		
            	}
            }
        });
	}

	function guardarPuntajePm(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

		var opcion_puntaje = document.getElementById("opcion_puntaje").value;		
					
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_puntaje_pm',
           data:{consulta:consulta, paciente:paciente, opcion_puntaje:opcion_puntaje, _token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			mostrarSnackbar("PUNTAJE GUARDADO");            		
            	} else {
            		mostrarSnackbar("PUNTAJE FALLO");            		
            	}
            }
        });
	}

	function cargarEstudiosDiagnosticosPm(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;		
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_estudio_diagnostico_pm',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){            			           						
           		    var fecha1_aux = data.response_data.fecha1.split("-");
           		    var fecha1 = fecha1_aux[2]+"/"+fecha1_aux[1]+"/"+fecha1_aux[0];

           		    var fecha2_aux = data.response_data.fecha2.split("-");
           		    var fecha2 = fecha2_aux[2]+"/"+fecha2_aux[1]+"/"+fecha2_aux[0];

					document.getElementById("pm_ed_fecha_1").value = fecha1;
					document.getElementById("pm_ed_fecha_2").value = fecha2;
					document.getElementById("pm_estudios_diagnostico_hto_hb").value = data.response_data.hto_hb;
					document.getElementById("pm_estudios_diagnostico_hiv").value = data.response_data.hiv;
					document.getElementById("pm_estudios_diagnostico_biopsia_mo").value = data.response_data.biopsia_mo;
					document.getElementById("pm_estudios_diagnostico_vcm").value = data.response_data.vcm;
					document.getElementById("pm_estudios_diagnostico_vdrl").value = data.response_data.vdrl;
					document.getElementById("pm_estudios_diagnostico_gb_pmn").value = data.response_data.gb_pmn;
					document.getElementById("pm_estudios_diagnostico_hbv").value = data.response_data.hbv;
					document.getElementById("pm_estudios_diagnostico_citogenetico").value = data.response_data.citogenetico;
					document.getElementById("pm_estudios_diagnostico_plaquetas").value = data.response_data.plaquetas;
					document.getElementById("pm_estudios_diagnostico_hcv").value = data.response_data.hcv;
					document.getElementById("pm_estudios_diagnostico_albumina").value = data.response_data.albumina;
					document.getElementById("pm_estudios_diagnostico_otro").value = data.response_data.otro;
					document.getElementById("pm_estudios_diagnostico_categoria_who").value = data.response_data.categoria_who_2016;
					document.getElementById("pm_estudios_diagnostico_ldh").value = data.response_data.ldh;
					document.getElementById("pm_estudios_diagnostico_gyf").value = data.response_data.gyf;
					document.getElementById("pm_estudios_diagnostico_puntaje_ipssr").value = data.response_data.puntaje_ipss_r;
					document.getElementById("pm_estudios_diagnostico_ers").value = data.response_data.ers;
					document.getElementById("pm_estudios_diagnostico_pcd").value = data.response_data.pcd;
					document.getElementById("pm_estudios_diagnostico_mortalidad").value = data.response_data.mortalidad;
					document.getElementById("pm_estudios_diagnostico_ferremia").value = data.response_data.ferremia;
					document.getElementById("pm_estudios_diagnostico_pci").value = data.response_data.pci;
					document.getElementById("pm_estudios_diagnostico_progresion_leucemia").value = data.response_data.progresion_leucemia;
					document.getElementById("pm_estudios_diagnostico_ferritina").value = data.response_data.ferritina;
					document.getElementById("pm_estudios_diagnostico_score_charlson").value = data.response_data.score_charlson;
					document.getElementById("pm_estudios_diagnostico_transferrina").value = data.response_data.transferrina;
					document.getElementById("pm_estudios_diagnostico_sat_transf").value = data.response_data.sat_transf;
					document.getElementById("pm_estudios_diagnostico_comorbilidades").value = data.response_data.comorbilidades;
					document.getElementById("pm_estudios_diagnostico_dosaje_epo").value = data.response_data.dosaje_epo;
            	} 
            }
        });
	}

	function cargarTratamientoPm(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;		
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_tratamiento_pm',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){            			           					
					document.getElementById("pm_tratamiento_detalle").value = data.response_data.descripcion;
            	} 
            }
        });
	}

	function cargarIpssrPm(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;		
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_ipssr_pm',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){            			           									
					var opcion_fila_1 = data.response_data.fila_1_opcion;
					var opcion_fila_2 = data.response_data.fila_2_opcion;
					var opcion_fila_3 = data.response_data.fila_3_opcion;
					var opcion_fila_4 = data.response_data.fila_4_opcion;
					var opcion_fila_5 = data.response_data.fila_5_opcion;

					pintarIpssr(1, opcion_fila_1);
					pintarIpssr(2, opcion_fila_2);
					pintarIpssr(3, opcion_fila_3);
					pintarIpssr(4, opcion_fila_4);
					pintarIpssr(5, opcion_fila_5);
            	} 
            }
        });
	}

	function cargarPuntajePm(consulta_aux){
		if(consulta_aux == null)		
			var consulta = document.getElementById("consulta_id").value;
		else
			var consulta = consulta_aux;		
		var paciente = document.getElementById("paciente_id").value;		

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_puntaje_pm',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){            			           						
           			var opcion_puntaje = data.response_data.opcion_fila;										
					pintarPuntajeFila(opcion_puntaje);
            	} 
            }
        });
	}


</script>
