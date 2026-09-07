<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/clear-cache', function() {
   $exitCode = Artisan::call('cache:clear');
   // return what you want
});

Route::get('/config-cache', function() {
   $exitCode = Artisan::call('config:cache');
   // return what you want
});
Route::get('/config-clear', function() {
   $exitCode = Artisan::call('config:clear');
   // return what you want
});

Route::get('/check_consultas/{mes}', function ($mes) {	
	$anio = date('Y');	
	$dia = "1";	
	$desde = $anio."-".$mes."-".$dia;
	$dia = "31";
	$hasta = $anio."-".$mes."-".$dia;

    $consultas = DB::table('consultas')            
    					->select('consultas.medico_id', DB::raw('count(*) as total'))
    					->where('consultas.created_at', '<=', $desde)
    					->where('consultas.created_at', '>=', $hasta)
	                    ->where('consultas.activo', 1)                                    
	                    ->groupBy('consultas.medico_id')
	                    ->get(); 
    return $consultas;
});

Route::get('/original', function () {
    return view('plantillas.plantilla_original');
});


Route::get('/licencia_expirada', function () {
	return view('licencia.licencia_expirada');   
})->name('licencia_expirada');


Route::get('/aviso_licencia_expirada', function () {
	return view('licencia.aviso_licencia_expirada');   
})->name('aviso_licencia_expirada');


Route::get('/', function () {
	return view('auth.login');
   // return view('plantillas.plantilla_medico');
});

Route::get('/home', 'HomeController@index')->name('home');

// Aca van a ir todas las rutas que tiene acceso un administrador.
Route::group(['middleware' => ['usuarioAdmin']], function () {

	Route::get('/admin_home', function () {
	    return view('plantillas.plantilla_admin');
	})->name('admin_home');

	Route::get('/admin_nuevo_usuario', function () {
	    return view('admin.nuevo_usuario');
	});
	
	Route::get('/admin_medicos', 'AdminController@adminMedicos')->name('adminmedicos');

	Route::post('/update_exp_licencia', 'AdminController@updateExpLicencia')->name('updateexplicencia');

	Route::post('/update_aviso_licencia', 'AdminController@updateAvisoLicencia')->name('updateavisolicencia');

	Route::post('/update_importe', 'AdminController@updateImporte')->name('updateimporte');

	Route::post('/update_activo', 'AdminController@updateActivo')->name('updateactivo');

	Route::get('/admin_secretaria', function () {
		$secretarias = DB::table('users')->where('usuario_tipo', 3)->get();
		$medicos = DB::table('users')->where('usuario_tipo', 2)->get();

    	return View('admin.admin_secretaria')
    	->with('secretarias',$secretarias)
    	->with('medicos',$medicos);   
    });

	Auth::routes();

	Route::post('/registrar', 'Auth\RegisterController@registrar')->name('registrar');

	Route::post('/vincular_secretaria_medico', 'AdminController@vincularSecretariaMedico')->name('vincularsecretariamedico');
	
 });

// Aca van a ir todas las rutas que tiene acceso un medico.
Route::group(['middleware' => ['usuarioMedico']], function () {

	Route::post('cargar_diagnosticos','MedicoController@cargarDiagnosticos')->name('cargardiagnosticos');			
	
	Route::post('guardar_diagnosticos','MedicoController@guardarDiagnosticos')->name('guardardiagnosticos');			

	Route::post('cargar_listado_diagnostico','MedicoController@cargarListadoDiagnostico')->name('cargarlistadodiagnostico');			

	Route::get('alta_diagnostico','MedicoController@altaDiagnostico')->name('altadiagnostico');			
	
	Route::post('guardar_nuevo_diagnostico','MedicoController@guardarNuevoDiagnostico')->name('guardarnuevodiagnostico');			

	Route::post('ver_licencia_expira','MedicoController@verLicenciaExpira')->name('verlicenciaexpira');			

	Route::get('/medico_home', function () {
	    return view('plantillas.plantilla_medico');
	})->name('medico_home');

	Route::get('/medico_nuevo_paciente', function () {
	    return view('medico.nuevo_paciente')->with('medico_id', Auth::user()->id);
	});

	Route::get('/medico_buscar_paciente', function () {
	    $user = \Auth::user();	
	    return view('medico.buscar_paciente_listado')->with('medico_id', $user->id);
	});

	Route::get('/medico_buscar_paciente_bd', function () {
	    $user = \Auth::user();	
	    return view('medico.base_datos.buscar_paciente_bd')->with('medico_id', $user->id);
	});	

	Route::get('pacientes_listado_buscar_bd','MedicoController@pacientesListadoBuscarBd');	

	Route::get('pacientes_listado_buscar','PacienteController@pacientesListadoBuscar');		

	Route::get('medico_actualizar_paciente','PacienteController@actualizarPaciente')->name('medicoactualizarpaciente');

	Route::post('medico_actualizar_paciente_buscar','PacienteController@actualizarPacienteBuscar')->name('medicoactualizarpacientebuscar');

	Route::get('crear_nueva_consulta_digital','MedicoController@crearNuevaConsultaDigital')->name('crearnuevaconsultadigital');	

	Route::get('nueva_consulta','MedicoController@nuevaConsulta')->name('nuevaconsulta');

	Route::post('guardar_planilla_control_mm','MedicoController@guardarPlanillaControlMM')->name('guardarplanillacontrolmm');
	
	Route::post('guardar_lh_sangre','MedicoController@guardarLhSangre')->name('guardarlhsangre');
	
	Route::post('guardar_lh_imagenes','MedicoController@guardarLhImagenes')->name('guardarlhimagenes');
	
	Route::post('guardar_lh_biopsia','MedicoController@guardarLhBiopsia')->name('guardarlhbiopsia');
	
	Route::post('guardar_lh_estadio','MedicoController@guardarLhEstadio')->name('guardarlhestadio');
	
	Route::post('guardar_lh_antecedentes','MedicoController@guardarLhAntecedentes')->name('guardarlhantecedentes');
	
	Route::post('guardar_imagenes_lnh','MedicoController@guardarImagenesLnh')->name('guardarimageneslnh');
	
	Route::post('guardar_biopsia_cmf_lnh','MedicoController@guardarBiopsiaCmfLnh')->name('guardarbiopsiacmflnh');
	
	Route::post('guardar_estadio_lnh','MedicoController@guardarEstadioLnh')->name('guardarestadiolnh');
	
	Route::post('guardar_antecedentes_lnh','MedicoController@guardarAntecedentesLnh')->name('guardarantecedenteslnh');
	
	Route::post('guardar_pronostico_lnh','MedicoController@guardarPronosticoLnh')->name('guardarpronosticolnh');
	
	Route::post('guardar_sangre_gm','MedicoController@guardarSangreGm')->name('guardarsangregm');
	
	Route::post('guardar_orina_gm','MedicoController@guardarOrinaGm')->name('guardarorinagm');
	
	Route::post('guardar_medula_osea_gm','MedicoController@guardarMedulaOseaGm')->name('guardarmedulaoseagm');
	
	Route::post('guardar_antecedentes_personales_gm','MedicoController@guardarAntecedentesPersonalesGm')->name('guardarantecedentespersonalesgm');
	
	Route::post('guardar_diagnostico_gm','MedicoController@guardarDiagnosticoGm')->name('guardardiagnosticogm');
	
	Route::post('guardar_tratamiento_gm','MedicoController@guardarTratamientoGm')->name('guardartratamientogm');
	
	Route::post('guardar_estudio_diagnostico_pm','MedicoController@guardarEstudioDiagnosticoPm')->name('guardarestudiodiagnosticopm');
	
	Route::post('guardar_tratamiento_pm','MedicoController@guardarTratamientoPm')->name('guardartratamientopm');
	
	Route::post('guardar_ipssr_pm','MedicoController@guardarIpssrPm')->name('guardaripssrpm');
	
	Route::post('guardar_puntaje_pm','MedicoController@guardarPuntajePm')->name('guardarpuntajepm');
	
	Route::post('guardar_evolucion','MedicoController@guardarEvolucion')->name('guardarevolucion');

	Route::post('guardar_conductas','MedicoController@guardarConductas')->name('guardarconductas');
	
	Route::post('establecer_activo','MedicoController@establecerActivo')->name('estableceractivo');

	Route::get('consulta','MedicoController@consultasPrevias')->name('consulta');
	
	Route::post('guardar_audio','MedicoController@guardarAudio')->name('guardaraudio');
	
	Route::post('guardar_evolucion_fotos','MedicoController@guardarEvolucionFotos')->name('guardarevolucionfotos');
	
	Route::post('cargar_evolucion_fotos','MedicoController@cargarEvolucionFotos')->name('cargarevolucionfotos');
	
	Route::post('cargar_evolucion_foto','MedicoController@cargarEvolucionFoto')->name('cargarevolucionfoto');
	
	Route::post('cargar_evolucion_ant_sig_foto','MedicoController@cargarEvolucionAntSigFoto')->name('cargarevolucionantsigfoto');
	
	Route::post('cargar_evolucion_ant_sig','MedicoController@cargarEvolucionAntSig')->name('cargarevolucionantsig');

	Route::get('consultas_previas','MedicoController@navegarConsultasPrevias2')->name('consultas_previas');

	Route::post('cargar_evolucion','MedicoController@cargarEvolucion')->name('cargarevolucion');

	Route::post('cargar_conductas','MedicoController@cargarConductas')->name('cargarconductas');
	
	Route::post('cargar_sangre_lh','MedicoController@cargarSangreLh')->name('cargarsangrelh');
	
	Route::post('cargar_imagenes_lh','MedicoController@cargarImagenesLh')->name('cargarimageneslh');
	
	Route::post('cargar_biopsia_lh','MedicoController@cargarBiopsiaLh')->name('cargarbiopsialh');
	
	Route::post('cargar_estadio_lh','MedicoController@cargarEstadioLh')->name('cargarestadiolh');
	
	Route::post('cargar_antecedentes_lh','MedicoController@cargarAntecedentesLh')->name('cargarantecedenteslh');
	
	Route::post('cargar_imagenes_lnh','MedicoController@cargarImagenesLnh')->name('cargarimageneslnh');
	
	Route::post('cargar_biopsia_lnh','MedicoController@cargarBiopsiaLnh')->name('cargarbiopsialnh');
	
	Route::post('cargar_estadio_lnh','MedicoController@cargarEstadioLnh')->name('cargarestadiolnh');
	
	Route::post('cargar_antecedentes_lnh','MedicoController@cargarAntecedentesLnh')->name('cargarantecedenteslnh');
	
	Route::post('cargar_pronostico_lnh','MedicoController@cargarPronosticoLnh')->name('cargarpronosticolnh');
	
	Route::post('cargar_sangre_gm','MedicoController@cargarSangreGm')->name('cargarsangregm');
	
	Route::post('cargar_orina_gm','MedicoController@cargarOrinaGm')->name('cargarorinagm');
	
	Route::post('cargar_medula_osea_gm','MedicoController@cargarMedulaOseaGm')->name('cargarmedulaoseagm');
	
	Route::post('cargar_antecedentes_personales_gm','MedicoController@cargarAntecedentesPersonalesGm')->name('cargarantecedentespersonalesgm');
	
	Route::post('cargar_diagnostico_gm','MedicoController@cargarDiagnosticoGm')->name('cargardiagnosticogm');
	
	Route::post('cargar_tratamiento_gm','MedicoController@cargarTratamientoGm')->name('cargartratamientogm');
	
	Route::post('cargar_estudio_diagnostico_pm','MedicoController@cargarEstudioDiagnosticoPm')->name('cargarestudiodiagnosticopm');
	
	Route::post('cargar_tratamiento_pm','MedicoController@cargarTratamientoPm')->name('cargartratamientopm');
	
	Route::post('cargar_ipssr_pm','MedicoController@cargarIpssrPm')->name('cargaripssrpm');
	
	Route::post('cargar_puntaje_pm','MedicoController@cargarPuntajePm')->name('cargarpuntajepm');
	
	Route::post('guardar_tipo_estudio_consulta','MedicoController@guardarTipoEstudioConsulta')->name('guardartipoestudioconsulta');
	
	Route::post('cargar_tipo_estudio_consulta','MedicoController@cargarTipoEstudioConsulta')->name('cargartipoestudioconsulta');

	Route::get('seleccionar_tipo_consulta','MedicoController@seleccionarTipoConsulta')->name('seleccionartipoconsulta');

	Route::post('crear_nueva_consulta','MedicoController@crearNuevaConsulta')->name('crearnuevaconsulta');
	
	Route::post('guardar_datos_subjetivos','MedicoController@guardarDatosSubjetivos')->name('guardardatossubjetivos');

	Route::post('cargar_datos_subjetivos','MedicoController@cargarDatosSubjetivos')->name('cargardatossubjetivos');
	
	Route::post('guardar_imagen_cuerpo','MedicoController@guardarImagenCuerpo')->name('guardarimagencuerpo');	

	Route::post('guardar_imagen_gm','MedicoController@guardarImagenCuerpoGm')->name('guardarimagencuerpogm');

	Route::post('guardar_imagen_cuerpo_lnh','MedicoController@guardarImagenCuerpoLnh')->name('guardarimagencuerpolnh');
	
	Route::post('cargar_imagen_examen_fisico','MedicoController@cargarImagenExamenFisico')->name('cargarimagenexamenfisico');
	
	Route::post('cargar_consultas_previas_lh','MedicoController@cargarConsultasPreviasLh')->name('cargarconsultaspreviaslh');
	
	Route::post('cargar_consultas_previas_lnh','MedicoController@cargarConsultasPreviasLnh')->name('cargarconsultaspreviaslnh');
	
	Route::post('cargar_consultas_previas_gm','MedicoController@cargarConsultasPreviasGm')->name('cargarconsultaspreviasgm');
	
	Route::post('cargar_consultas_previas_pm','MedicoController@cargarConsultasPreviasPm')->name('cargarconsultaspreviaspm');
	
	Route::post('guardar_control_anticoagulacion','MedicoController@guardarControlAnticoagulacion')->name('guardarcontrolanticoagulacion');
	
	Route::post('guardar_laboratorio_general','MedicoController@guardarLaboratorioGeneral')->name('guardarlaboratoriogeneral');
	
	Route::post('guardar_trombofilia','MedicoController@guardarTrombofilia')->name('guardartrombofilia');
	
	Route::post('guardar_trastorno_hemorragiparo','MedicoController@guardarTrastornoHemorragiparo')->name('guardartrastornohemorragiparo');

	Route::post('guardar_examen_fisico_texto','MedicoController@guardarExamenFisicoTexto')->name('guardarexamenfisicotexto');

	Route::post('cargar_examen_fisico_texto','MedicoController@cargarExamenFisicoTexto')->name('cargarexamenfisicotexto');
	
	Route::post('guardar_plan','MedicoController@guardarPlan')->name('guardarplan');
	
	Route::post('cargar_plan','MedicoController@cargarPlan')->name('cargarplan');	

	Route::post('guardar_impresion_diagnostica','MedicoController@guardarImpresionDiagnostica')->name('guardarimpresiondiagnostica');	

	Route::post('cargar_impresion_diagnostica','MedicoController@cargarImpresionDiagnostica')->name('cargarimpresiondiagnostica');

	Route::post('guardar_motivo_consulta','MedicoController@guardarMotivoConsulta')->name('guardarmotivoconsulta');

	Route::post('cargar_motivo_consulta','MedicoController@cargarMotivoConsulta')->name('cargarmotivoconsulta');

	Route::post('guardar_antecedentes_personales','MedicoController@guardarAntecedentesPersonales')->name('guardarantecedentespersonales');

	Route::post('guardar_antecedentes_familiares','MedicoController@guardarAntecedentesFamiliares')->name('guardarantecedentesfamiliares');

	Route::post('cargar_antecedentes','MedicoController@cargarAntecedentes')->name('cargarantecedentes');

	Route::post('guardar_resumen','MedicoController@guardarResumen')->name('guardarresumen');

	Route::post('cargar_resumen','MedicoController@cargarResumen')->name('cargarresumen');	

	Route::post('cargar_medicacion_actual','MedicoController@cargarMedicacionActual')->name('cargarmedicacionactual');	

	Route::post('guardar_medicacion_actual','MedicoController@guardarMedicacionActual')->name('guardarmedicacionactual');	

	Route::get('navegar_consulta_seleccionada','MedicoController@navegarConsultaSeleccionada')->name('navegarconsultaseleccionada');

	Route::post('guardar_nueva_consulta_foto','MedicoController@guardarNuevaConsultaFoto')->name('guardarnuevaconsultafoto');

	Route::post('get_fotos_nueva_consulta','MedicoController@getFotosNuevaConsulta')->name('getfotosnuevaconsulta');	
	
	Route::get('seleccionar_consulta_imprimir','MedicoController@seleccionarConsultaImprimir')->name('seleccionarconsultaimprimir');
		
	Route::post('get_informacion_imprimir','MedicoController@getInformacionImprimir')->name('getinformacionimprimir');	

	Route::post('cargar_config','MedicoController@cargarConfig')->name('cargarconfig');	

	Route::post('guardar_config','MedicoController@guardarConfig')->name('guardarconfig');	

	Route::post('guardar_config_secciones','MedicoController@guardarConfigSecciones')->name('guardarconfigsecciones');	

	Route::post('get_config_secciones','MedicoController@getConfigSecciones')->name('getconfigsecciones');	
 });

// Aca van a ir todas las rutas que tiene acceso una secretaria.
Route::group(['middleware' => ['usuarioSecretaria']], function () {

	Route::get('/secretaria_home', function () {
	    return view('plantillas.plantilla_secretaria');
	})->name('secretaria_home');

	Route::get('nuevo_paciente','SecretariaController@nuevoPaciente')->name('nuevopaciente');	

	Route::get('actualizar_paciente','SecretariaController@actualizarPaciente')->name('actualizarpaciente');	

	Route::get('buscar_paciente','SecretariaController@buscarPaciente')->name('buscarpaciente');	

	Route::post('continuar_navegacion','SecretariaController@continuarNavegacion')->name('continuarnavegacion');

	Route::post('secretaria_actualizar_paciente_buscar','SecretariaController@actualizarPacienteBuscar')->name('secretariaactualizarpacientebuscar');	

	Route::post('cargar_fotos_nueva_consulta_ant_sig_foto','MedicoController@cargarFotosNuevaConsultaAntSigFoto')->name('cargarfotosnuevaconsultaantsigfoto');
	
	Route::get('modal_buscar_pacientes_secretaria_list','SecretariaController@modalBuscarPacientesSecretariaList')->name('modalbuscarpacientessecretarialist');

 });

// Aca van a ir todas las rutas que son publicas

Route::post('alta_paciente_medico_secretaria','PacienteController@altaPacienteMedicoSecretaria')->name('altapacientemedicosecretaria');

Route::post('consultar_paciente','PacienteController@consultarPaciente')->name('consultarpaciente');		

Route::post('consultar_paciente_id','PacienteController@consultarPacienteId')->name('consultarpacienteid');		

Route::post('actualizar_datos_paciente','PacienteController@actualizarDatosPaciente')->name('actualizardatospaciente');

Route::get('paciente_listado_buscar','PacienteController@pacienteListadoBuscar');						

Route::post('paciente_consultar','PacienteController@pacienteConsultar');			

Route::post('get_paciente_id','PacienteController@getPacienteId');			

