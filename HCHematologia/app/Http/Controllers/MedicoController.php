<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Paciente;
use App\Consulta;
use App\ConsultaFoto;
use App\MedicoInfo;
use App\PlanillaControlMM;
use App\LHSangre;
use App\LHAntecedentes;
use App\LHBiopsias;
use App\LHImagenes;
use App\LHEstadios;

use App\LNHImagenes;
use App\LNHAntecedentes;
use App\LNHBiopsiaCMf;
use App\LNHEstadios;
use App\LNHPronosticos;

use App\GMAntecedentesPersonales;
use App\GMDiagnostico;
use App\GMMedulaOsea;
use App\GMOrina;
use App\GMSangre;
use App\GMTratamiento;

use App\PMEstudiosDiagnosticos;
use App\PMIpssr;
use App\PMPuntaje;
use App\PMTratamiento;

use App\Conducta;
use App\Evolucion;

use App\DatosSubjetivo;
use App\ExamenFisico;

use App\ControlAnticoagulacion;
use App\LaboratorioGeneral;
use App\Trombofilia;
use App\TranstornoHemorragiparo;

use App\ExamenFisicoTexto;
use App\Plan;
use App\MotivoConsulta;
use App\ImpresionDiagnostica;
use App\Antecedente;
use App\EvolucionFoto;
use App\Resumen;
use App\MedicacionActual;

use App\MedicoConfig;
use App\MedicoFirma;
use App\Diagnostico;

use DateTime;
use DateTimeZone;
use Image;

class MedicoController extends Controller
{

	public function __construct()
    {    	
        $this->middleware('auth');
    }

    function verLicenciaExpira(Request $request){
        $user=\Auth::user(); 
        $licencia = DB::table('licencias')
                            ->where('licencias.medico_user_id', $user->id)                                   
                            ->first();
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d");  
        $aviso = 0;
        if($fecha >= $licencia->fecha_aviso)
            $aviso = 1;        
        return response()->json(array('licencia'=>$licencia, 'aviso'=>$aviso));   
    }

    function guardarTipoEstudioConsulta(Request $request){
        $consulta_id = $request->consulta_id;
        $tipo_estudio = $request->tipo_estudio;

        $consulta = Consulta::find($consulta_id);
        if($tipo_estudio == 1)
            $consulta->linfoma_hodgkin = 1;
        if($tipo_estudio == 2)
            $consulta->linfoma_no_hodgkin = 1;
        if($tipo_estudio == 3)
            $consulta->gammapatia_monoclonal = 1;
        if($tipo_estudio == 4)
            $consulta->planilla_mielodisplasia = 1;
        $consulta->save();

        return response()->json(array('consulta'=>$consulta));   
    }   

    function cargarTipoEstudioConsulta(Request $request){
        $consulta_id = $request->consulta_id;
        $tipo_estudio = $request->tipo_estudio;

        $consulta = Consulta::find($consulta_id);
        $response = 0;
        if($tipo_estudio == 1){
            if($consulta->linfoma_hodgkin == 1){
                $response = 1;
            }
        }
        if($tipo_estudio == 2){
            if($consulta->linfoma_no_hodgkin == 1){
                $response = 1;   
            }
        }
        if($tipo_estudio == 3){
            if($consulta->gammapatia_monoclonal == 1){
                $response = 1;
            }
        }
        if($tipo_estudio == 4){
            if($consulta->planilla_mielodisplasia == 1){
                $response = 1;
            }
        }
        
        return response()->json(array('response'=>$response));           
    }

    function establecerActivo(Request $request){
        $paciente_id = $request->paciente_id;
        $consulta_id = $request->consulta_id;        
        $fecha_consulta = $request->fecha_consulta;
        $edad_mostrar = $request->edad;
        
        $consultas = Consulta::find($consulta_id);
        if($edad_mostrar != null)
            $consultas->edad_mostrar = $edad_mostrar;
        if($fecha_consulta!=null)
            $consultas->created_at = $fecha_consulta;                
        $consultas->activo = 1;        
        $consultas->save();

        $this->guardarLaboratoriosActivo1($paciente_id, $consulta_id, 'laboratorio_generals');
        $this->guardarLaboratoriosActivo1($paciente_id, $consulta_id, 'control_anticoagulacions');
        $this->guardarLaboratoriosActivo1($paciente_id, $consulta_id, 'trombofilias');
        $this->guardarLaboratoriosActivo1($paciente_id, $consulta_id, 'transtorno_hemorragiparos');
        // $this->guardarLaboratoriosActivo1($paciente_id, $consulta_id, 'evolucions');

        return response()->json(array('response'=>1));
    }

    function consultasPrevias(){
        $user=\Auth::user();                
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first(); 
        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
        $medicoInfo->consulta_id = 0;
        $medicoInfo->save();      

        $listadoConsultas = DB::table('consultas')
                            ->select('consultas.*')
                            ->join('medico_pacientes', 'medico_pacientes.paciente_id', 'consultas.paciente_id')
                            ->where('medico_pacientes.medico_user_id', $user->id)
                            ->where('consultas.medico_id', $user->id)
                            ->where('consultas.paciente_id', $medicoInfoAux->paciente_id)
                            ->where('consultas.activo', 1)
                            ->distinct()
                            ->orderby('consultas.created_at','desc')
                            ->get();    
        
        $paciente = Paciente::find($medicoInfoAux->paciente_id);    
        $fecha_nacimiento_aux = explode('-', $paciente->fecha_nacimiento);
        $fecha_nacimiento = $fecha_nacimiento_aux[2].'/'.$fecha_nacimiento_aux[1].'/'.$fecha_nacimiento_aux[0];
                
        $consulta = null;
        $response = 0; 
        
        if($listadoConsultas->count() > 0){
            $consulta = $listadoConsultas[0];
            $response = 1; 
        }
        if($response == 1){

            $pcmmPrimeroTabla = $this->getLaboratorioPCMMTabla($paciente->id, 'planilla_control_m_m_s');
            $pcmmTablaFechas = $this->getTablaFechas($paciente->id, 'planilla_control_m_m_s');
            $pcmmTablaTope = $this->getTablaTope($paciente->id, 'planilla_control_m_m_s'); 

            $caPrimeroTabla = $this->getLaboratorioCATabla($paciente->id, 'control_anticoagulacions');
            $caTablaFechas = $this->getTablaFechas($paciente->id, 'control_anticoagulacions');
            $caTablaTope = $this->getTablaTope($paciente->id, 'control_anticoagulacions'); 

            $lgPrimeroTabla = $this->getLaboratorioLGTabla($paciente->id, 'laboratorio_generals');
            $lgTablaFechas = $this->getTablaFechas($paciente->id, 'laboratorio_generals');
            $lgTablaTope = $this->getTablaTope($paciente->id, 'laboratorio_generals'); 

            $tPrimeroTabla = $this->getLaboratorioTTabla($paciente->id, 'trombofilias');
            $tTablaFechas = $this->getTablaFechas($paciente->id, 'trombofilias');
            $tTablaTope = $this->getTablaTope($paciente->id, 'trombofilias'); 

            $thPrimeroTabla = $this->getLaboratorioTHTabla($paciente->id, 'transtorno_hemorragiparos');
            $thTablaFechas = $this->getTablaFechas($paciente->id, 'transtorno_hemorragiparos');
            $thTablaTope = $this->getTablaTope($paciente->id, 'transtorno_hemorragiparos'); 

            $img_cuerpo_ultimo = null;
            $img_cuerpo_ultimo_lnh = null;
            $img_cuerpo_ultimo_gm = null;            

            return view('medico.consultas_previas')
                        ->with('response', $response)                
                        ->with('nueva_consulta', 0)                
                        ->with('date', null)        

                        ->with('planilla_control_mm_tabla', $pcmmPrimeroTabla)
                        ->with('planilla_control_mm_tabla_fechas', $pcmmTablaFechas)
                        ->with('planilla_control_mm_tabla_tope', $pcmmTablaTope)        

                        ->with('laboratorio_general_tabla', $lgPrimeroTabla)
                        ->with('laboratorio_general_tabla_fechas', $lgTablaFechas)
                        ->with('laboratorio_general_tabla_tope', $lgTablaTope)        

                        ->with('control_anticoagulacion_tabla', $caPrimeroTabla)
                        ->with('control_anticoagulacion_tabla_fechas', $caTablaFechas)
                        ->with('control_anticoagulacion_tabla_tope', $caTablaTope)        

                        ->with('trombofilia_tabla', $tPrimeroTabla)
                        ->with('trombofilia_tabla_fechas', $tTablaFechas)
                        ->with('trombofilia_tabla_tope', $tTablaTope)    

                        ->with('trastorno_hemorragiparo_tabla', $thPrimeroTabla)
                        ->with('trastorno_hemorragiparo_tabla_fechas', $thTablaFechas)
                        ->with('trastorno_hemorragiparo_tabla_tope', $thTablaTope)    
                        
                        ->with('img_cuerpo_ultimo', $img_cuerpo_ultimo)                
                        ->with('img_cuerpo_ultimo_lnh', $img_cuerpo_ultimo_lnh)                
                        ->with('img_cuerpo_ultimo_gm', $img_cuerpo_ultimo_gm)                

                        ->with('consulta', $consulta)                
                        ->with('paciente', $paciente)                        
                        ->with('fecha_nacimiento', $fecha_nacimiento)                
                        ->with('listadoConsultas', $listadoConsultas);                         
        } else {
            $mensaje = "El paciente no tiene consultas.";
            return view('medico.mostrar_mensaje')
                        ->with('mensaje', $mensaje);
        }
    }

    function seleccionarTipoConsulta(Request $request){
        return view('medico.seleccionar_tipo_consulta');
    }

    function crearNuevaConsulta(Request $request){
        $tipo_consulta = $request->tipo_consulta;

        $user=\Auth::user();
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();        

        $paciente = Paciente::find($medicoInfoAux->paciente_id);
                    
        $consulta = new Consulta;
        $consulta->paciente_id = $paciente->id;
        $consulta->medico_id = $user->id;
        $consulta->tipo_consulta = $tipo_consulta;
        $consulta->es_foto = 0;        
        $consulta->edad_mostrar = '';
        $consulta->linfoma_hodgkin = 0;
        $consulta->linfoma_no_hodgkin = 0;
        $consulta->gammapatia_monoclonal = 0;
        $consulta->planilla_mielodisplasia = 0;
        $consulta->activo = 2;
        $consulta->save();                      
                
        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
        $medicoInfo->paciente_id = $paciente->id;
        $medicoInfo->consulta_id = $consulta->id;
        $medicoInfo->es_nueva_consulta = 1;
        $medicoInfo->save();        

        return redirect()->route('navegarconsultaseleccionada');
    }

    function crearNuevaConsultaDigital(){
    	$user=\Auth::user();                
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        
        $paciente = Paciente::find($medicoInfoAux->paciente_id);
        
        $consulta = new Consulta;
        $consulta->paciente_id = $paciente->id;
        $consulta->medico_id = $user->id;
        $consulta->tipo_consulta = 2;
        $consulta->es_foto = 1;                
        $consulta->edad_mostrar = '';
        $consulta->linfoma_hodgkin = 0;
        $consulta->linfoma_no_hodgkin = 0;
        $consulta->gammapatia_monoclonal = 0;
        $consulta->planilla_mielodisplasia = 0;
        $consulta->activo = 2;
        $consulta->save();        

        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
        $medicoInfo->paciente_id = $paciente->id;
        $medicoInfo->consulta_id = $consulta->id;
        $medicoInfo->es_nueva_consulta = 1;
        $medicoInfo->save();

        return redirect()->route('navegarconsultaseleccionada');
    }


    function navegarConsultasPrevias2() {    
        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
        $medicoInfo->consulta_id = 0;
        $medicoInfo->save();

        $paciente_id = $medicoInfoAux->paciente_id;            

        $ultimaConsulta = DB::table('consultas')
                            ->where('consultas.paciente_id', $paciente_id)                            
                            ->orderBy('consultas.id', 'desc')
                            ->first();
        
        if($ultimaConsulta != null){                            
            $_consulta = Consulta::find($ultimaConsulta->id);
            $_paciente = Paciente::find($paciente_id);
            $date = date('d-m-Y');
            
            $img_cuerpo_ultimo = $this->getImagenDibujo($_consulta->id, $paciente_id, 1);
            
            $img_cuerpo_ultimo_lnh = $this->getImagenDibujo($_consulta->id, $paciente_id, 2);

            $img_cuerpo_ultimo_gm = $this->getImagenDibujo($_consulta->id, $paciente_id, 3);

        
            $pcmmPrimeroTabla = $this->getLaboratorioPCMMTabla($paciente_id, 'planilla_control_m_m_s');
            $pcmmTablaFechas = $this->getTablaFechas($paciente_id, 'planilla_control_m_m_s');
            $pcmmTablaTope = $this->getTablaTope($paciente_id, 'planilla_control_m_m_s');    

            $caPrimeroTabla = $this->getLaboratorioCATabla($paciente_id, 'control_anticoagulacions');
            $caTablaFechas = $this->getTablaFechas($paciente_id, 'control_anticoagulacions');
            $caTablaTope = $this->getTablaTope($paciente_id, 'control_anticoagulacions');    

            $lgPrimeroTabla = $this->getLaboratorioLGTabla($paciente_id, 'laboratorio_generals');
            $lgTablaFechas = $this->getTablaFechas($paciente_id, 'laboratorio_generals');
            $lgTablaTope = $this->getTablaTope($paciente_id, 'laboratorio_generals');    

            $tPrimeroTabla = $this->getLaboratorioTTabla($paciente_id, 'trombofilias');
            $tTablaFechas = $this->getTablaFechas($paciente_id, 'trombofilias');
            $tTablaTope = $this->getTablaTope($paciente_id, 'trombofilias');    

            $thPrimeroTabla = $this->getLaboratorioTHTabla($paciente_id, 'transtorno_hemorragiparos');
            $thTablaFechas = $this->getTablaFechas($paciente_id, 'transtorno_hemorragiparos');
            $thTablaTope = $this->getTablaTope($paciente_id, 'transtorno_hemorragiparos');    

            $user = \Auth::user();   
            $modulo_1Aux = DB::table('medico_configs')
                            ->where('medico_configs.medico_id', $user->id)
                            ->where('medico_configs.modulo_id', 1)                            
                            ->first();
            $modulo_1 = 0;
            if($modulo_1Aux != null)
                $modulo_1 = $modulo_1Aux->activo;       

            //$consultaDiag = Consulta::find($_consulta->id);

            //$diagnosticos = $consultaDiag ? $consultaDiag->diagnosticos()->get() : collect();
            
            return view('medico.consultas')
                    //->with('diagnosticos', $diagnosticos)

                    ->with('modulo_1', $modulo_1)
                    ->with('planilla_control_mm_tabla', $pcmmPrimeroTabla)
                    ->with('planilla_control_mm_tabla_fechas', $pcmmTablaFechas)
                    ->with('planilla_control_mm_tabla_tope', $pcmmTablaTope)

                    ->with('control_anticoagulacion_tabla', $caPrimeroTabla)
                    ->with('control_anticoagulacion_tabla_fechas', $caTablaFechas)
                    ->with('control_anticoagulacion_tabla_tope', $caTablaTope)

                    ->with('laboratorio_general_tabla', $lgPrimeroTabla)
                    ->with('laboratorio_general_tabla_fechas', $lgTablaFechas)
                    ->with('laboratorio_general_tabla_tope', $lgTablaTope)

                    ->with('trombofilia_tabla', $tPrimeroTabla)
                    ->with('trombofilia_tabla_fechas', $tTablaFechas)
                    ->with('trombofilia_tabla_tope', $tTablaTope)

                    ->with('trastorno_hemorragiparo_tabla', $thPrimeroTabla)
                    ->with('trastorno_hemorragiparo_tabla_fechas', $thTablaFechas)
                    ->with('trastorno_hemorragiparo_tabla_tope', $thTablaTope)

                    ->with('img_cuerpo_ultimo', $img_cuerpo_ultimo)
                    ->with('img_cuerpo_ultimo_lnh', $img_cuerpo_ultimo_lnh)
                    ->with('img_cuerpo_ultimo_gm', $img_cuerpo_ultimo_gm)
                    ->with('date', $date)
                    ->with('nueva_consulta', 0)
                    ->with('consulta',$_consulta)                
                    ->with('paciente',$_paciente);  
        } else {
            $mensaje = "El paciente no tiene consultas.";
            return view('medico.mostrar_mensaje')
                        ->with('mensaje', $mensaje);
        }
    }
    
    function getConfigSecciones(Request $request) {
        $modulo = 2;        
        $user = \Auth::user();   
        $medicoSecciones = DB::table('medico_configs')
                            ->where('medico_configs.medico_id', $user->id)
                            ->where('medico_configs.modulo_id', $modulo)                            
                            ->first();

        return response()->json(array('medicoSecciones'=>$medicoSecciones));
    }    

    function guardarConfigSecciones(Request $request) {
        $modulo = $request->modulo;
        $activo = $request->activo;
        $user = \Auth::user();   
        $medicoConfig = DB::table('medico_configs')
                            ->where('medico_configs.medico_id', $user->id)
                            ->where('medico_configs.modulo_id', $modulo)                            
                            ->first();        
        if($medicoConfig != null) {
            $medicoAux = MedicoConfig::find($medicoConfig->id);
        } else {
            $medicoAux = new MedicoConfig;
            $medicoAux->modulo_id = $modulo;
            $medicoAux->valor_integer = 0;
            $medicoAux->medico_id = $user->id;                        
            $medicoAux->activo = $activo;
        }                
        if($request->seccionesSeleccionadas == null)
            $medicoAux->valor_string = "";
        else                        
            $medicoAux->valor_string = $request->seccionesSeleccionadas;                    
        
        $medicoAux->save();

        return response()->json(array('medicoConfig'=>$medicoConfig));
    }

    function guardarConfig(Request $request){
        $modulo = $request->modulo;
        $activo = $request->activo;
        $user = \Auth::user();   
        $medicoConfig = DB::table('medico_configs')
                            ->where('medico_configs.medico_id', $user->id)
                            ->where('medico_configs.modulo_id', $modulo)                            
                            ->first();        
        if($medicoConfig != null){
            $medicoAux = MedicoConfig::find($medicoConfig->id);
        } else {
            $medicoAux = new MedicoConfig;
            $medicoAux->modulo_id = $modulo;
            $medicoAux->valor_integer = 0;
            $medicoAux->medico_id = $user->id;            
            $medicoAux->valor_string = "";                    
        }        
        $medicoAux->activo = $activo;
        $medicoAux->save();

        return response()->json(array('medicoConfig'=>$medicoConfig)); 
    }

    function cargarConfig(Request $request) {
        $modulo = $request->modulo;
        $user = \Auth::user();   
        $medicoConfig = DB::table('medico_configs')
                            ->where('medico_configs.medico_id', $user->id)
                            ->where('medico_configs.modulo_id', $modulo)
                            ->where('medico_configs.activo', 1)
                            ->first();        

        $medicoSecciones = DB::table('medico_configs')
                            ->where('medico_configs.medico_id', $user->id)
                            ->where('medico_configs.modulo_id', 2)
                            ->where('medico_configs.activo', 1)
                            ->first();                                    

        return response()->json(array('medicoConfig'=>$medicoConfig, 'medicoSecciones'=>$medicoSecciones)); 
    }

    function navegarConsultaSeleccionada() {
        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        $paciente_id = $medicoInfoAux->paciente_id;
        $consulta_id = $medicoInfoAux->consulta_id;
        $esNuevaConsulta = $medicoInfoAux->es_nueva_consulta;

        $_consulta = Consulta::find($consulta_id);
        $_paciente = Paciente::find($paciente_id);
        $date = date('d-m-Y');
        
        $img_cuerpo_ultimo = $this->getImagenDibujo($consulta_id, $paciente_id, 1);
        
        $img_cuerpo_ultimo_lnh = $this->getImagenDibujo($consulta_id, $paciente_id, 2);

        $img_cuerpo_ultimo_gm = $this->getImagenDibujo($consulta_id, $paciente_id, 3);

        if($_consulta->tipo_consulta == 1){            
            $pcmmPrimeroTabla = $this->getLaboratorioPCMMTabla($paciente_id, 'planilla_control_m_m_s');
            $pcmmTablaFechas = $this->getTablaFechas($paciente_id, 'planilla_control_m_m_s');
            $pcmmTablaTope = $this->getTablaTope($paciente_id, 'planilla_control_m_m_s');    
            $pcmmUltimoRegistro = $this->getUltimoRegistroGuardado($paciente_id, 'planilla_control_m_m_s');    

            $caPrimeroTabla = $this->getLaboratorioCATabla($paciente_id, 'control_anticoagulacions');
            $caTablaFechas = $this->getTablaFechas($paciente_id, 'control_anticoagulacions');
            $caTablaTope = $this->getTablaTope($paciente_id, 'control_anticoagulacions');    
            $caUltimoRegistro = $this->getUltimoRegistroGuardado($paciente_id, 'control_anticoagulacions');    

            $lgPrimeroTabla = $this->getLaboratorioLGTabla($paciente_id, 'laboratorio_generals');
            $lgTablaFechas = $this->getTablaFechas($paciente_id, 'laboratorio_generals');
            $lgTablaTope = $this->getTablaTope($paciente_id, 'laboratorio_generals');    
            $lgUltimoRegistro = $this->getUltimoRegistroGuardado($paciente_id, 'laboratorio_generals');    

            $tPrimeroTabla = $this->getLaboratorioTTabla($paciente_id, 'trombofilias');
            $tTablaFechas = $this->getTablaFechas($paciente_id, 'trombofilias');
            $tTablaTope = $this->getTablaTope($paciente_id, 'trombofilias');    
            $tUltimoRegistro = $this->getUltimoRegistroGuardado($paciente_id, 'trombofilias');    

            $thPrimeroTabla = $this->getLaboratorioTHTabla($paciente_id, 'transtorno_hemorragiparos');
            $thTablaFechas = $this->getTablaFechas($paciente_id, 'transtorno_hemorragiparos');
            $thTablaTope = $this->getTablaTope($paciente_id, 'transtorno_hemorragiparos');
            $thUltimoRegistro = $this->getUltimoRegistroGuardado($paciente_id, 'transtorno_hemorragiparos');    
            //$lgTablaFechas = ["Fecha","2021-05-20","2021-04-07","2021-09-24","2021-09-24","2021-09-24"];

            $medicoConfig = DB::table('medico_configs')
                            ->where('medico_configs.medico_id', $user->id)
                            ->where('medico_configs.modulo_id', 1)
                            ->first();
            $medicoConfigValue = 0;
            if($medicoConfig != null){
                $medicoConfigValue = $medicoConfig->activo;
            }

            $anteultimaConsulta = $this->copiarUltimoDiagnostico($consulta_id, $paciente_id);
        
            return view('medico.nueva_consulta')
                    ->with('modulo_1', $medicoConfigValue)
                    ->with('anteultimaConsulta', $anteultimaConsulta)
                    ->with('planilla_control_mm_tabla', $pcmmPrimeroTabla)
                    ->with('planilla_control_mm_tabla_fechas', $pcmmTablaFechas)
                    ->with('planilla_control_mm_tabla_tope', $pcmmTablaTope)

                    ->with('control_anticoagulacion_tabla', $caPrimeroTabla)
                    ->with('control_anticoagulacion_tabla_fechas', $caTablaFechas)
                    ->with('control_anticoagulacion_tabla_tope', $caTablaTope)
                    ->with('control_anticoagulacion_tabla_ultimo_registro', $caUltimoRegistro)

                    ->with('laboratorio_general_tabla', $lgPrimeroTabla)
                    ->with('laboratorio_general_tabla_fechas', $lgTablaFechas)
                    ->with('laboratorio_general_tabla_tope', $lgTablaTope)
                    ->with('laboratorio_general_tabla_ultimo_registro', $lgUltimoRegistro)

                    ->with('trombofilia_tabla', $tPrimeroTabla)
                    ->with('trombofilia_tabla_fechas', $tTablaFechas)
                    ->with('trombofilia_tabla_tope', $tTablaTope)
                    ->with('trombofilia_tabla_ultimo_registro', $tUltimoRegistro)

                    ->with('trastorno_hemorragiparo_tabla', $thPrimeroTabla)
                    ->with('trastorno_hemorragiparo_tabla_fechas', $thTablaFechas)
                    ->with('trastorno_hemorragiparo_tabla_tope', $thTablaTope)
                    ->with('trastorno_hemorragiparo_tabla_ultimo_registro', $thUltimoRegistro)

                    ->with('img_cuerpo_ultimo', $img_cuerpo_ultimo)
                    ->with('img_cuerpo_ultimo_lnh', $img_cuerpo_ultimo_lnh)
                    ->with('img_cuerpo_ultimo_gm', $img_cuerpo_ultimo_gm)
                    ->with('date', $date)
                    ->with('nueva_consulta', $esNuevaConsulta)
                    ->with('consulta',$_consulta)                
                    ->with('paciente',$_paciente);  
        }

        if($_consulta->tipo_consulta == 2){            
            return view('medico.nueva_consulta_digital')
                    ->with('nueva_consulta', $esNuevaConsulta)
                    ->with('consulta',$_consulta)                
                    ->with('paciente',$_paciente);  
        }
        // consulta -> telemedicina
        if($_consulta->tipo_consulta == 3){            
            return view('medico.nueva_consulta_telemedicina')
                    ->with('perfil', $user->perfil)
                    ->with('nueva_consulta', $esNuevaConsulta)
                    ->with('consulta',$_consulta)                
                    ->with('paciente',$_paciente);  
        }            
    }

    function copiarUltimoDiagnostico($consulta_id, $paciente_id) {        
        $anteultimaConsulta = DB::table('consultas')
            ->where('paciente_id', $paciente_id)
            ->orderBy('id', 'desc')
            ->skip(1) // Salta la última
            ->take(1) // Toma la anteúltima
            ->first(); // Devuelve un solo resultado
        if($anteultimaConsulta != null) { 
            
            $consultaOrigen = Consulta::find($anteultimaConsulta->id);
            $consultaNueva = Consulta::find($consulta_id);

            if (!$consultaOrigen || !$consultaNueva) {
                return response()->json(['response' => 0, 'error' => 'Consulta no encontrada']);
            }

            // Obtener IDs de diagnósticos asignados a la consulta original
            $diagnosticosOrigen = $consultaOrigen->diagnosticos()->pluck('diagnosticos.id')->toArray();

            // Asignar los mismos diagnósticos a la nueva consulta
            $consultaNueva->diagnosticos()->sync($diagnosticosOrigen);
            return $consultaNueva;
        }
        else {
            return null;                                
        }
    }

    function getImagenDibujo($consulta_id, $paciente_id, $opcion){
        if($opcion == 1){
            $img_aux = DB::table('examen_fisicos')
                            //->where('examen_fisicos.consulta_id', $consulta_id)
                            ->where('examen_fisicos.paciente_id', $paciente_id)
                            ->where('examen_fisicos.linfoma_hodgkin', 1)
                            ->where('examen_fisicos.activo', 1)
                            ->orderBy('examen_fisicos.id')
                            ->get();
        }

        if($opcion == 2){
            $img_aux = DB::table('examen_fisicos')
                            //->where('examen_fisicos.consulta_id', $consulta_id)
                            ->where('examen_fisicos.paciente_id', $paciente_id)
                            ->where('examen_fisicos.linfoma_no_hodgkin', 1)
                            ->where('examen_fisicos.activo', 1)
                            ->orderBy('examen_fisicos.id')
                            ->get();
        }

        if($opcion == 3){
            $img_aux = DB::table('examen_fisicos')
                            //->where('examen_fisicos.consulta_id', $consulta_id)
                            ->where('examen_fisicos.paciente_id', $paciente_id)
                            ->where('examen_fisicos.gammapatia_monoclonal', 1)
                            ->where('examen_fisicos.activo', 1)
                            ->orderBy('examen_fisicos.id')
                            ->get();
        }

        $img_ultimo_aux = $img_aux->count(); 
        if($img_ultimo_aux > 0)
            $img_aux_ultimo = $img_aux[$img_ultimo_aux - 1];
        else
            $img_aux_ultimo = null;

        return $img_aux_ultimo;
    }

    function getUltimoRegistroGuardado($paciente_id, $tabla) {
        $tablaAux = DB::table($tabla)                            
                        ->select($tabla.'.created_at')
                        ->where($tabla.'.paciente_id', $paciente_id)
                        ->where($tabla.'.activo', 1)
                        ->orderby($tabla.'.created_at', 'desc')
                        ->first();

        if($tablaAux != null) {
            // Crear un objeto DateTime con la hora original
            $fechaOriginal = new DateTime($tablaAux->created_at);

            // Cambiar la zona horaria a Buenos Aires
            $zonaHorariaBsAs = new DateTimeZone('America/Argentina/Buenos_Aires');
            $fechaOriginal->setTimezone($zonaHorariaBsAs);

            // Mostrar la fecha y hora convertida en el formato deseado
            return $fechaOriginal->format('d-m-Y H:i:s');
            
        } else {
            return "N/A";
        }
    }

    function getTablaTope($paciente_id, $tabla) {
        $tablaAux = DB::table($tabla)                            
                            ->where($tabla.'.paciente_id', $paciente_id)
                            ->where($tabla.'.activo', 1)
                            ->get();

        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        /*if(strcmp($tabla, 'laboratorio_generals') != 0) {
            $tablaAux2 = DB::table($tabla)                            
                                ->where($tabla.'.paciente_id', $paciente_id)
                                ->where($tabla.'.consulta_id', $medicoInfoAux->consulta_id)
                                ->get();
            $cantidad = $tablaAux->count() + $tablaAux2->count();
        } else {
            $cantidad = $tablaAux->count();
        } */
        $cantidad = $tablaAux->count();

        return $cantidad;
    }

    function getTablaFechas($paciente_id, $tabla) {
        $json = array();
        $json = $this->getLaboratorioTablaAux($json, 'fecha', 'Fecha', $paciente_id, $tabla);
        return $json;

    }

    function getLaboratorioLGTabla($paciente_id, $tabla){
        $json = array();        
        $json = $this->getLaboratorioTablaAux($json, 'rto_gr', 'Rto GR (/mm3)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'hto', 'Hto (%)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'hb_g_dl', 'Hb (g/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'vcm_fl', 'VCM (fl)', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'hcm', 'HCM (pg)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'chcm', 'CHCM (g/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'gb', 'GB (/mm3)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'pqt', 'Pqt (/mm3)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'fsp', 'FSP', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ldh', 'LDH (U/L)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ers', 'ERS (mmh)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'b2_microglob', 'B2 microglob', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'urea', 'Urea (mg/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'creatinina', 'Creatinina (mg/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'glucemia', 'Glucemia', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'tgo', 'TGO (U/L)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'tgp', 'TGP (U/L)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'fal', 'FAL (U/L)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'bb_total', 'Bb total (mg/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ferremia', 'Ferremia (mcg/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'transferrina', 'Transferrina (mg/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'sat_transferrina', 'Sat Transferrina (%)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'tibc', 'TIBC (mcg/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ferritina', 'Ferritina (ng/mL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'vit_b12', 'Vit B12 (pg/mL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'folato', 'Folato (ng/mL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'prot_totales', 'Prot Totales (g/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'albumina', 'Albumina (g/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'alfa', 'Alfa (g/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'beta', 'Beta (g/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'gamma', 'Gamma (g/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'pico_monotomas', 'Pico Monoclonal (g/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'lg_g', 'Ig G', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'lg_a', 'Ig A', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'lg_m', 'Ig M', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'lg_e', 'Ig E', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'lg_d', 'Ig D', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'interpretacion', 'Interpretacion', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'inmunofijacion', 'Inmunofijacion', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'cll', 'CLL', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'kappa', 'Kappa', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'lambda', 'Lambda', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'calcio', 'Calcio (mg/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'fosforo', 'Fosforo (mg/dL)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'proteinuria', 'Proteinuria (gr/24hs)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'tp', 'TP (seg/%)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'rin', 'RIN', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'aptt', 'APTT (seg)', $paciente_id, $tabla);
        
                
        return $json;
    }

    function getLaboratorioTTabla($paciente_id, $tabla){
        $json = array();
        $json = $this->getLaboratorioTablaAux($json, 'tp', 'TP (seg/%)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'rin', 'RIN', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'aptt', 'APTT (seg)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'tt', 'TT (seg)', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'ts', 'TS (min)', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'f_viii', 'F VIII', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'pc', 'PC', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'ps', 'PS', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'rpca', 'RPCA', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'ac_anti_b2_gp_igg', 'Ac Anti B2 GP IgG', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ac_anti_b2_gp_igm', 'Ac Anti B2 GP IgM', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ac_anti_cardiolipina_igg', 'Ac Anti Cardiolipina IgG', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ac_anti_cardiolipina_igm', 'Ac Anti Cardiolipina IgM', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'anticoagulante_lupico', 'Anticoagulante Lupico', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'mutacion_fv_leiden', 'Mutacion FV Leiden', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'mutacion_pt_20210', 'Mutacion PT 20210', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'homocisteinemia', 'Homocisteinemia', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'antitrombina_iii', 'Antitrombina III', $paciente_id, $tabla);        

        return $json;
    }

    function getLaboratorioCATabla($paciente_id, $tabla){
        $json = array();
        $json = $this->getLaboratorioTablaAux($json, 'tp', 'TP(seg%)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'rin', 'RIN', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'aptt', 'APTT (seg)', $paciente_id, $tabla);        
                
        return $json;
    }

    function getLaboratorioTHTabla($paciente_id, $tabla){
        $json = array();
        $json = $this->getLaboratorioTablaAux($json, 'plaquetas', 'Plaquetas (/mm3)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'tp', 'TP (seg/%)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'rin', 'RIN', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'aptt', 'APTT (seg)', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'factor_v', 'Factor V', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'fibrinogeno', 'Fibrinogeno', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'tt', 'TT (seg)', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'ts', 'TS (min)', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'retraccion_del_coagulo', 'Retracción del coagulo', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'factor_de_vw', 'Factor de VW (Ag)', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'cofactor_de_ristocetina', 'Cofactor de Ristocetina', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'tp_correccion', 'TP Correccion', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'aptt_correccion', 'APTT Correccion', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'factor_ii', 'Factor II', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'factor_vii', 'Factor VII', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'factor_viii', 'Factor VIII', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'factor_ix', 'Factor IX', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'factor_x', 'Factor X', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'inh_viii', 'Inh. VIII', $paciente_id, $tabla);        
        $json = $this->getLaboratorioTablaAux($json, 'inh_ix', 'Inh. IX', $paciente_id, $tabla);        
                
        return $json;
    }

    function getLaboratorioPCMMTabla($paciente_id, $tabla){
        $json = array();
        $json = $this->getLaboratorioTablaAux($json, 'hto_hb', 'Hto/Hb', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'vcm', 'VCM', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'gb_pmn', 'GB/PMN', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'plaquetas', 'Plaquetas', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ldh', 'LDH', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ferremia', 'Ferremia', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ferritina', 'Ferritina', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'transferrina', 'Transferrina', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'sat_transf', 'Sat. Transf.', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'n_ugr', 'NºUGR', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'p_coombs_d', 'P. Coombs D', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'n_unidades_pqt', 'Nº Unidades PQT', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'dosaje_epo', 'Dosaje EPO', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'epo_ui_sem', 'EPO (ui/sem)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'ahm_dosis_diaria', 'AHM (dosis diaria)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'g_csf_dosis_semanal', 'G - CSF (dosis semanal)', $paciente_id, $tabla);
        $json = $this->getLaboratorioTablaAux($json, 'agonistas_trombopoy', 'Agonistas Trombopoy', $paciente_id, $tabla);
                
        return $json;
    }

    function getLaboratorioTablaAux($json, $nombreColumna, $nombreColumnaMostrar, $paciente_id, $tabla) {        
        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        
        /*if(strcmp($tabla, 'laboratorio_generals') != 0) {
            $tablaAux = DB::table($tabla)
                                ->select($tabla.'.'.$nombreColumna)
                                ->where($tabla.'.paciente_id', $paciente_id)
                                ->where($tabla.'.consulta_id', $medicoInfoAux->consulta_id)
                                ->orderby($tabla.'.fecha', 'desc')
                                ->get();

            $json[] = $nombreColumnaMostrar;
            foreach ($tablaAux as $val) {
                $json[] = $val->$nombreColumna;   
            }                      
        } else {
            $json[] = $nombreColumnaMostrar;
        } */
        $json[] = $nombreColumnaMostrar;
        $tablaAux = DB::table($tabla)
                            ->select($tabla.'.'.$nombreColumna)
                            ->where($tabla.'.paciente_id', $paciente_id)
                            ->where($tabla.'.activo', 1)
                            ->orderby($tabla.'.fecha', 'desc')
                            ->get();
        
        
        foreach ($tablaAux as $val) {
            $json[] = $val->$nombreColumna;   
        }

        return $json;        
    }

    function guardarNuevaConsultaFoto(Request $request){
        $consulta_id = $request->consulta_id;
        $paciente_id = $request->paciente_id;
        
        $_consulta = Consulta::find($consulta_id);
        $_consulta->activo = 1;        
        $_consulta->save();

        $cantidadFotos = intval($request->nueva_consulta_fotos_cantidad_fotos);
        $usuario_actual_nombre=\Auth::user()->email;   
        $pathFolderMedico_aux = explode('@', $usuario_actual_nombre);
        $pathFolderMedico = $pathFolderMedico_aux[0];
        for ($i = 1; $i <= $cantidadFotos; $i++) {
            $request_foto = 'nueva_consulta_foto_'.$i;

            if($request->$request_foto != null){
                
                if($request->hasfile($request_foto)){
                    $nuevaConsultaFoto = new ConsultaFoto;
                    $nuevaConsultaFoto->activo = 1;
                    $nuevaConsultaFoto->paciente_id = $paciente_id;
                    $nuevaConsultaFoto->consulta_id = $consulta_id;
                    $nuevaConsultaFoto->numero = $this->getNumeroFotosNuevaConsulta($paciente_id, $consulta_id);                    
                    $pathName = $request->file($request_foto)->store('img/'.$pathFolderMedico.'consulta_foto');
                    $name = collect(explode('/', $pathName))->last();
                    $image = $request->file($request_foto);
                    //$name  = $image->getClientOriginalName().time().'.'.$image->getClientOriginalExtension();
                    $path = 'img/'.$pathFolderMedico.'/consulta_foto/'.$name;        
                    Image::make($image->getRealPath())->resize(1980, 1920)->save($path);  
                    $nuevaConsultaFoto->foto = $pathFolderMedico.'/consulta_foto/'.$name;
                    $nuevaConsultaFoto->save();           
                }               
            } 
        }

        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
        $medicoInfo->es_nueva_consulta = 3;
        $medicoInfo->save();

        return redirect()->route('navegarconsultaseleccionada');
    }

    function getNumeroFotosNuevaConsulta($paciente_id, $consulta_id){
        $cantidadFotos = DB::table('consulta_fotos')                                
                                ->where('consulta_fotos.paciente_id', $paciente_id)
                                ->where('consulta_fotos.consulta_id', $consulta_id)
                                ->where(function ($query) {
                                     $query->where('consulta_fotos.activo', 1)
                                           ->orWhere('consulta_fotos.activo', 2);
                                })                                    
                                ->get();
        return $cantidadFotos->count()+1;
    }

    function getFotosNuevaConsulta(Request $request){
         $fotos_aux = DB::table('consulta_fotos')                                
                                ->where('consulta_fotos.paciente_id', $request->paciente)
                                ->where('consulta_fotos.consulta_id', $request->consulta)                                
                                ->where(function ($query) {
                                     $query->where('consulta_fotos.activo', 1)
                                           ->orWhere('consulta_fotos.activo', 2);
                                })                                
                                ->orderBy('id','desc')
                                ->first();        
        return response()->json(array('response'=>1, 'consultaFotos'=>$fotos_aux)); 
    }

    function cargarConsultasPreviasPm(Request $request){
        $paciente_id = $request->paciente;        
        $aux = DB::table('consultas')                            
                            ->where('consultas.paciente_id', $paciente_id)
                            ->where('consultas.planilla_mielodisplasia', 1)
                            ->where('consultas.activo', 1)
                            ->orderBy('consultas.id')
                            ->get();
        $ultimo_aux = $aux->count(); 
        if($ultimo_aux > 0){
            $response = 1;
            $ultimo = $aux[$ultimo_aux - 1];
        } else {
            $response = 0;
            $ultimo = null;
        }

        return response()->json(array('response'=>$response, 'response_data' => $ultimo));
    }

    function cargarConsultasPreviasGm(Request $request){
        $paciente_id = $request->paciente;        
        $aux = DB::table('consultas')                            
                            ->where('consultas.paciente_id', $paciente_id)
                            ->where('consultas.gammapatia_monoclonal', 1)
                            ->where('consultas.activo', 1)
                            ->orderBy('consultas.id')
                            ->get();
        $ultimo_aux = $aux->count(); 
        if($ultimo_aux > 0){
            $response = 1;
            $ultimo = $aux[$ultimo_aux - 1];
        } else {
            $response = 0;
            $ultimo = null;
        }

        return response()->json(array('response'=>$response, 'response_data' => $ultimo));
    }

    function cargarConsultasPreviasLnh(Request $request){
        $paciente_id = $request->paciente;        
        $aux = DB::table('consultas')                            
                            ->where('consultas.paciente_id', $paciente_id)
                            ->where('consultas.linfoma_no_hodgkin', 1)
                            ->where('consultas.activo', 1)
                            ->orderBy('consultas.id')
                            ->get();
        $ultimo_aux = $aux->count(); 
        if($ultimo_aux > 0){
            $response = 1;
            $ultimo = $aux[$ultimo_aux - 1];
        } else {
            $response = 0;
            $ultimo = null;
        }

        return response()->json(array('response'=>$response, 'response_data' => $ultimo));
    }

    function cargarConsultasPreviasLh(Request $request){
        $paciente_id = $request->paciente;        
        $aux = DB::table('consultas')                            
                            ->where('consultas.paciente_id', $paciente_id)
                            ->where('consultas.linfoma_hodgkin', 1)
                            ->where('consultas.activo', 1)
                            ->orderBy('consultas.id')
                            ->get();
        $ultimo_aux = $aux->count(); 
        if($ultimo_aux > 0){
            $response = 1;
            $ultimo = $aux[$ultimo_aux - 1];
        } else {
            $response = 0;
            $ultimo = null;
        }

        return response()->json(array('response'=>$response, 'response_data' => $ultimo));
    }

    function cargarImagenExamenFisico(Request $request){
        $paciente_id = $request->paciente;        
        $consulta_id = $request->consulta;        
        $opcion = $request->examen_fisico;        

        if($opcion == 1){
            if($consulta_id == null){
                $img_aux = DB::table('examen_fisicos')                            
                            ->where('examen_fisicos.paciente_id', $paciente_id)
                            ->where('examen_fisicos.linfoma_hodgkin', 1)
                            ->where('examen_fisicos.activo', 1)
                            ->orderBy('examen_fisicos.id')
                            ->get();
            } else {
                $img_aux = DB::table('examen_fisicos')
                            ->where('examen_fisicos.consulta_id', $consulta_id)
                            ->where('examen_fisicos.paciente_id', $paciente_id)
                            ->where('examen_fisicos.linfoma_hodgkin', 1)
                            ->where('examen_fisicos.activo', 1)
                            ->orderBy('examen_fisicos.id')
                            ->get();
            }
        }

        if($opcion == 2){
            if($consulta_id == null){
                $img_aux = DB::table('examen_fisicos')                            
                            ->where('examen_fisicos.paciente_id', $paciente_id)
                            ->where('examen_fisicos.linfoma_no_hodgkin', 1)
                            ->where('examen_fisicos.activo', 1)
                            ->orderBy('examen_fisicos.id')
                            ->get();
            } else {
                $img_aux = DB::table('examen_fisicos')
                            ->where('examen_fisicos.consulta_id', $consulta_id)
                            ->where('examen_fisicos.paciente_id', $paciente_id)
                            ->where('examen_fisicos.linfoma_no_hodgkin', 1)
                            ->where('examen_fisicos.activo', 1)
                            ->orderBy('examen_fisicos.id')
                            ->get();
            }
        }

        if($opcion == 3){
            if($consulta_id == null){
                $img_aux = DB::table('examen_fisicos')                            
                            ->where('examen_fisicos.paciente_id', $paciente_id)
                            ->where('examen_fisicos.gammapatia_monoclonal', 1)
                            ->where('examen_fisicos.activo', 1)
                            ->orderBy('examen_fisicos.id')
                            ->get();
            } else {
                $img_aux = DB::table('examen_fisicos')
                            ->where('examen_fisicos.consulta_id', $consulta_id)
                            ->where('examen_fisicos.paciente_id', $paciente_id)
                            ->where('examen_fisicos.gammapatia_monoclonal', 1)
                            ->where('examen_fisicos.activo', 1)
                            ->orderBy('examen_fisicos.id')
                            ->get();
            }
        }

        $img_ultimo_aux = $img_aux->count(); 
        if($img_ultimo_aux > 0)
            $img_aux_ultimo = $img_aux[$img_ultimo_aux - 1];
        else
            $img_aux_ultimo = null;

        return response()->json(array('response'=>1, 'examen_fisico' => $img_aux_ultimo, 'opcion'=>$opcion, 'consulta_id'=>$consulta_id, 'paciente_id'=>$paciente_id));        
    }

    function cargarFotosNuevaConsultaAntSigFoto(Request $request){
        $paciente_id = $request->paciente;        
        $consulta_id = $request->consulta;        
        
        $numero = $request->numero;
        if($numero < 1){
            $numero = 1;
        }
        $cantidad_fotos_aux = DB::table('consulta_fotos')                                
                                ->where('consulta_fotos.paciente_id', $paciente_id) 
                                ->where('consulta_fotos.consulta_id', $consulta_id)                                
                                ->where('consulta_fotos.activo', 1)
                                ->get();    
        $cantidadFotos = $cantidad_fotos_aux->count();
        if($numero>$cantidadFotos)
            $numero = $cantidadFotos;

        $response_data = DB::table('consulta_fotos')                                
                                        ->where('consulta_fotos.paciente_id', $paciente_id)  
                                        ->where('consulta_fotos.consulta_id', $consulta_id)                                       
                                        ->where('consulta_fotos.numero', $numero)
                                        ->where('consulta_fotos.activo', 1)                                        
                                        ->first();

        return response()->json(array('response'=>1, 'cantidadFotos' => $cantidadFotos,'response_data'=>$response_data));
    }


    // deprecado
    function nuevaConsulta(){    	
        $user=\Auth::user();
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();        

        $paciente = Paciente::find($medicoInfoAux->paciente_id);
                       
        $consulta = new Consulta;
        $consulta->paciente_id = $paciente->id;
        $consulta->medico_id = $user->id;
        $consulta->tipo_consulta = 1;
        $consulta->es_foto = 0;        
        $consulta->edad_mostrar = '';
        $consulta->linfoma_hodgkin = 0;
        $consulta->linfoma_no_hodgkin = 0;
        $consulta->gammapatia_monoclonal = 0;
        $consulta->planilla_mielodisplasia = 0;
        $consulta->activo = 2;
        $consulta->save();                      
                
        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
        $medicoInfo->paciente_id = $paciente->id;
        $medicoInfo->consulta_id = $consulta->id;
        $medicoInfo->es_nueva_consulta = 1;
        $medicoInfo->save();        

        return redirect()->route('navegarconsultaseleccionada');
    }

    function guardarPlanillaControlMM(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $planillaControl = new PlanillaControlMM;
        $planillaControl->consulta_id = $consulta;
        $planillaControl->paciente_id = $paciente;

        if($request->hto_hb != null && strcmp($request->hto_hb, '') != 0){
            $planillaControl->hto_hb = $request->hto_hb;                        
        } else {
            $planillaControl->hto_hb = '';                        
        }

        if($request->vcm != null && strcmp($request->vcm, '') != 0){
            $planillaControl->vcm = $request->vcm;                        
        } else {
            $planillaControl->vcm = '';                        
        }

        if($request->gb_pmn != null && strcmp($request->gb_pmn, '') != 0){
            $planillaControl->gb_pmn = $request->gb_pmn;                        
        } else {
            $planillaControl->gb_pmn = '';                        
        }

        if($request->plaquetas != null && strcmp($request->plaquetas, '') != 0){
            $planillaControl->plaquetas = $request->plaquetas;                        
        } else {
            $planillaControl->plaquetas = '';                        
        }

        if($request->ldh != null && strcmp($request->ldh, '') != 0){
            $planillaControl->ldh = $request->ldh;                        
        } else {
            $planillaControl->ldh = '';                        
        }

        if($request->ferremia != null && strcmp($request->ferremia, '') != 0){
            $planillaControl->ferremia = $request->ferremia;                        
        } else {
            $planillaControl->ferremia = '';                        
        }

        if($request->ferritina != null && strcmp($request->ferritina, '') != 0){
            $planillaControl->ferritina = $request->ferritina;                        
        } else {
            $planillaControl->ferritina = '';                        
        }

        if($request->transferrina != null && strcmp($request->transferrina, '') != 0){
            $planillaControl->transferrina = $request->transferrina;                        
        } else {
            $planillaControl->transferrina = '';                        
        }

        if($request->sat_transf != null && strcmp($request->sat_transf, '') != 0){
            $planillaControl->sat_transf = $request->sat_transf;                        
        } else {
            $planillaControl->sat_transf = '';                        
        }

        if($request->n_ugr != null && strcmp($request->n_ugr, '') != 0){
            $planillaControl->n_ugr = $request->n_ugr;                        
        } else {
            $planillaControl->n_ugr = '';                        
        }

        if($request->p_coombs_d != null && strcmp($request->p_coombs_d, '') != 0){
            $planillaControl->p_coombs_d = $request->p_coombs_d;                        
        } else {
            $planillaControl->p_coombs_d = '';                        
        }

        if($request->n_unidades_pqt != null && strcmp($request->n_unidades_pqt, '') != 0){
            $planillaControl->n_unidades_pqt = $request->n_unidades_pqt;                        
        } else {
            $planillaControl->n_unidades_pqt = '';                        
        }

        if($request->dosaje_epo != null && strcmp($request->dosaje_epo, '') != 0){
            $planillaControl->dosaje_epo = $request->dosaje_epo;                        
        } else {
            $planillaControl->dosaje_epo = '';                        
        }

        if($request->epo_ui_sem != null && strcmp($request->epo_ui_sem, '') != 0){
            $planillaControl->epo_ui_sem = $request->epo_ui_sem;                        
        } else {
            $planillaControl->epo_ui_sem = '';                        
        }
        
        if($request->ahm_dosis_diaria != null && strcmp($request->ahm_dosis_diaria, '') != 0){
            $planillaControl->ahm_dosis_diaria = $request->ahm_dosis_diaria;                        
        } else {
            $planillaControl->ahm_dosis_diaria = '';                        
        }

        if($request->g_csf_dosis_semanal != null && strcmp($request->g_csf_dosis_semanal, '') != 0){
            $planillaControl->g_csf_dosis_semanal = $request->g_csf_dosis_semanal;                        
        } else {
            $planillaControl->g_csf_dosis_semanal = '';                        
        }

        if($request->agonistas_trombopoy != null && strcmp($request->agonistas_trombopoy, '') != 0){
            $planillaControl->agonistas_trombopoy = $request->agonistas_trombopoy;                        
        } else {
            $planillaControl->agonistas_trombopoy = '';                        
        }
                
        if($request->fecha != null && strcmp($request->fecha, '') != 0){            
            $fecha_aux = explode('/', $request->fecha);        
            $fecha = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];                          
            $planillaControl->fecha = $fecha;                        
        } else {
            $planillaControl->fecha = '2000-01-01';                        
        }

        $planillaControl->activo = 1;
        $planillaControl->save();

        return response()->json(array('response'=>1));  
    }

    function existeConsultaPacienteTabla($consulta, $paciente, $tabla){
        $aux = DB::table($tabla)
                    ->where($tabla.'.consulta_id', $consulta)
                    ->where($tabla.'.paciente_id', $paciente)
                    ->first();
        return $aux;        
    }

    function existePacienteTabla($paciente, $tabla){
        $aux = DB::table($tabla)                    
                    ->where($tabla.'.paciente_id', $paciente)
                    ->first();
        return $aux;        
    }

    function guardarLhSangre(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'l_h_sangres');
        if($existeConsulta != null){
            $lh_sangre = LHSangre::find($existeConsulta->id);
        } else {
            $lh_sangre = new LHSangre;
            $lh_sangre->consulta_id = $consulta;
            $lh_sangre->paciente_id = $paciente;    
        }
        
        if($request->hto_hb_vcm != null && strcmp($request->hto_hb_vcm, '') != 0){
            $lh_sangre->hto_hb_vcm = $request->hto_hb_vcm;                        
        } else {
            $lh_sangre->hto_hb_vcm = '';                        
        }

        if($request->leucocitos != null && strcmp($request->leucocitos, '') != 0){
            $lh_sangre->leucocitos = $request->leucocitos;                        
        } else {
            $lh_sangre->leucocitos = '';                        
        }

        if($request->pqts != null && strcmp($request->pqts, '') != 0){
            $lh_sangre->pqts = $request->pqts;                        
        } else {
            $lh_sangre->pqts = '';                        
        }

        if($request->urea_creatinina != null && strcmp($request->urea_creatinina, '') != 0){
            $lh_sangre->urea_creatinina = $request->urea_creatinina;                        
        } else {
            $lh_sangre->urea_creatinina = '';                        
        }

        if($request->ci_creat_ml_min != null && strcmp($request->ci_creat_ml_min, '') != 0){
            $lh_sangre->ci_creat_ml_min = $request->ci_creat_ml_min;                        
        } else {
            $lh_sangre->ci_creat_ml_min = '';                        
        }

        if($request->tgo_tgp_fal_bb != null && strcmp($request->tgo_tgp_fal_bb, '') != 0){
            $lh_sangre->tgo_tgp_fal_bb = $request->tgo_tgp_fal_bb;                        
        } else {
            $lh_sangre->tgo_tgp_fal_bb = '';                        
        }

        if($request->uricemia != null && strcmp($request->uricemia, '') != 0){
            $lh_sangre->uricemia = $request->uricemia;                        
        } else {
            $lh_sangre->uricemia = '';                        
        }

        if($request->vsg != null && strcmp($request->vsg, '') != 0){
            $lh_sangre->vsg = $request->vsg;                        
        } else {
            $lh_sangre->vsg = '';                        
        }

        if($request->ldh != null && strcmp($request->ldh, '') != 0){
            $lh_sangre->ldh = $request->ldh;                        
        } else {
            $lh_sangre->ldh = '';                        
        }

        if($request->b2_microglobulina != null && strcmp($request->b2_microglobulina, '') != 0){
            $lh_sangre->b2_microglobulina = $request->b2_microglobulina;                        
        } else {
            $lh_sangre->b2_microglobulina = '';                        
        }

        if($request->proteinograma != null && strcmp($request->proteinograma, '') != 0){
            $lh_sangre->proteinograma = $request->proteinograma;                        
        } else {
            $lh_sangre->proteinograma = '';                        
        }

        if($request->serologia_hbv != null && strcmp($request->serologia_hbv, '') != 0){
            $lh_sangre->serologia_hbv = $request->serologia_hbv;                        
        } else {
            $lh_sangre->serologia_hbv = '';                        
        }

        if($request->serologia_hcv != null && strcmp($request->serologia_hcv, '') != 0){
            $lh_sangre->serologia_hcv = $request->serologia_hcv;                        
        } else {
            $lh_sangre->serologia_hcv = '';                        
        }

        if($request->serologia_hzv != null && strcmp($request->serologia_hzv, '') != 0){
            $lh_sangre->serologia_hzv = $request->serologia_hzv;                        
        } else {
            $lh_sangre->serologia_hzv = '';                        
        }

        if($request->serologia_cmv != null && strcmp($request->serologia_cmv, '') != 0){
            $lh_sangre->serologia_cmv = $request->serologia_cmv;                        
        } else {
            $lh_sangre->serologia_cmv = '';                        
        }

        if($request->serologia_hiv_4 != null && strcmp($request->serologia_hiv_4, '') != 0){
            $lh_sangre->serologia_hiv_4 = $request->serologia_hiv_4;                        
        } else {
            $lh_sangre->serologia_hiv_4 = '';                        
        }

        if($request->serologia_vdrl != null && strcmp($request->serologia_vdrl, '') != 0){
            $lh_sangre->serologia_vdrl = $request->serologia_vdrl;                        
        } else {
            $lh_sangre->serologia_vdrl = '';                        
        }

        $lh_sangre->activo = 1;
        $lh_sangre->save();

        return response()->json(array('response'=>1));  
    }

    function guardarLhImagenes(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'l_h_imagenes');
        if($existeConsulta != null){
            $lh_imagenes = LHImagenes::find($existeConsulta->id);
        } else {
            $lh_imagenes = new LHImagenes;
            $lh_imagenes->consulta_id = $consulta;
            $lh_imagenes->paciente_id = $paciente;    
        }
        
        if($request->lh_tc_fecha != null && strcmp($request->lh_tc_fecha, '') != 0){            
            $fecha_aux = explode('/', $request->lh_tc_fecha);        
            $fecha = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];                          
            $lh_imagenes->fecha_tc = $fecha;                        
        } else {
            $lh_imagenes->fecha_tc = '2000-01-01';                        
        }

        if($request->tc_descripcion != null && strcmp($request->tc_descripcion, '') != 0){
            $lh_imagenes->tc = $request->tc_descripcion;                        
        } else {
            $lh_imagenes->tc = '';                        
        }

        if($request->lh_pet_fecha != null && strcmp($request->lh_pet_fecha, '') != 0){            
            $fecha_aux = explode('/', $request->lh_pet_fecha);        
            $fecha = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];                          
            $lh_imagenes->fecha_pet = $fecha;                        
        } else {
            $lh_imagenes->fecha_pet = '2000-01-01';                        
        }

        if($request->pet_descripcion != null && strcmp($request->pet_descripcion, '') != 0){
            $lh_imagenes->pet = $request->pet_descripcion;                        
        } else {
            $lh_imagenes->pet = '';                        
        }

        $lh_imagenes->activo = 1;
        $lh_imagenes->save();

        return response()->json(array('response'=>1));  
    }

    function guardarLhBiopsia(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'l_h_biopsias');
        if($existeConsulta != null){
            $lh_biposia = LHBiopsias::find($existeConsulta->id);
        } else {
            $lh_biposia = new LHBiopsias;
            $lh_biposia->consulta_id = $consulta;
            $lh_biposia->paciente_id = $paciente;    
        }
        
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $lh_biposia->descripcion = $request->descripcion;                        
        } else {
            $lh_biposia->descripcion = '';                        
        }
        
        $lh_biposia->activo = 1;
        $lh_biposia->save();

        return response()->json(array('response'=>1));  
    }

    function guardarLhEstadio(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'l_h_estadios');
        if($existeConsulta != null){
            $lh_estadios = LHEstadios::find($existeConsulta->id);
        } else {
            $lh_estadios = new LHEstadios;
            $lh_estadios->consulta_id = $consulta;
            $lh_estadios->paciente_id = $paciente;    
        }
        
        if($request->ann_arbor != null && strcmp($request->ann_arbor, '') != 0){
            $lh_estadios->ann_arbor = $request->ann_arbor;                        
        } else {
            $lh_estadios->ann_arbor = '';                        
        }
        
        $lh_estadios->opcion_favorable_desfavorable = $request->opcion_favorable_desfavorable;   
        $lh_estadios->opcion_bajo_inter_alto = $request->opcion_bajo_inter_alto;

        $lh_estadios->texto_favorable_desfavorable = '';                            
        $lh_estadios->texto_bajo_inter_alto = '';                        
        $lh_estadios->activo = 1;
        $lh_estadios->save();

        return response()->json(array('response'=>1));  
    }

    function guardarLhAntecedentes(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'l_h_antecedentes');
        if($existeConsulta != null){
            $lh_antecedentes = LHAntecedentes::find($existeConsulta->id);
        } else {
            $lh_antecedentes = new LHAntecedentes;
            $lh_antecedentes->consulta_id = $consulta;
            $lh_antecedentes->paciente_id = $paciente;    
        }
        
        $lh_antecedentes->opcion_antigripal = $request->antigripal;   
        $lh_antecedentes->opcion_antineumococica = $request->antineumococica;   
        $lh_antecedentes->opcion_ecog = $request->lh_opcion_antecedentes_ecog;   
        $lh_antecedentes->insuficiencia_cardiaca = $request->insuficiencia_cardiaca;   
        $lh_antecedentes->epoc = $request->epoc;   
        $lh_antecedentes->insuficiencia_renal = $request->insuficiencia_renal;   
        $lh_antecedentes->hep = $request->hep;   
        $lh_antecedentes->diabetes = $request->diabetes;   
        $lh_antecedentes->hiv = $request->hiv;   

        if($request->lh_score_charlson_puntaje != null && strcmp($request->lh_score_charlson_puntaje, '') != 0){
            $lh_antecedentes->score_charlson = $request->lh_score_charlson_puntaje;                        
        } else {
            $lh_antecedentes->score_charlson = '';                        
        }        
        
        $lh_antecedentes->activo = 1;
        $lh_antecedentes->save();

        return response()->json(array('response'=>1));  
    }

    function guardarImagenesLnh(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'l_n_h_imagenes');
        if($existeConsulta != null){
            $lnh_imagenes = LNHImagenes::find($existeConsulta->id);
        } else {
            $lnh_imagenes = new LNHImagenes;
            $lnh_imagenes->consulta_id = $consulta;
            $lnh_imagenes->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $lnh_imagenes->descripcion = $request->descripcion;                        
        } else {
            $lnh_imagenes->descripcion = '';                        
        }        
        
        $lnh_imagenes->activo = 1;
        $lnh_imagenes->save();

        return response()->json(array('response'=>1));     
    }

    function guardarBiopsiaCmfLnh(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'l_n_h_biopsia_c_mfs');
        if($existeConsulta != null){
            $lnh_biopsia_cmf = LNHBiopsiaCMf::find($existeConsulta->id);
        } else {
            $lnh_biopsia_cmf = new LNHBiopsiaCMf;
            $lnh_biopsia_cmf->consulta_id = $consulta;
            $lnh_biopsia_cmf->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $lnh_biopsia_cmf->descripcion = $request->descripcion;                        
        } else {
            $lnh_biopsia_cmf->descripcion = '';                        
        }        
        
        $lnh_biopsia_cmf->activo = 1;
        $lnh_biopsia_cmf->save();

        return response()->json(array('response'=>1));     
    }   

    function guardarEstadioLnh(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'l_n_h_estadios');
        if($existeConsulta != null){
            $lnh_estadios = LNHEstadios::find($existeConsulta->id);
        } else {
            $lnh_estadios = new LNHEstadios;
            $lnh_estadios->consulta_id = $consulta;
            $lnh_estadios->paciente_id = $paciente;    
        }
                
        if($request->ann_arbor != null && strcmp($request->ann_arbor, '') != 0){
            $lnh_estadios->ann_arbor = $request->ann_arbor;                        
        } else {
            $lnh_estadios->ann_arbor = '';                        
        }        

        if($request->lugano != null && strcmp($request->lugano, '') != 0){
            $lnh_estadios->lugano = $request->lugano;                        
        } else {
            $lnh_estadios->lugano = '';                        
        }        

        if($request->murphy != null && strcmp($request->murphy, '') != 0){
            $lnh_estadios->murphy = $request->murphy;                        
        } else {
            $lnh_estadios->murphy = '';                        
        }        
        
        $lnh_estadios->activo = 1;
        $lnh_estadios->save();

        return response()->json(array('response'=>1));     
    }

    function guardarAntecedentesLnh(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'l_n_h_antecedentes');
        if($existeConsulta != null){
            $lnh_antecedentes = LNHAntecedentes::find($existeConsulta->id);
        } else {
            $lnh_antecedentes = new LNHAntecedentes;
            $lnh_antecedentes->consulta_id = $consulta;
            $lnh_antecedentes->paciente_id = $paciente;    
        }
                
        if($request->serologia_hbv != null && strcmp($request->serologia_hbv, '') != 0){
            $lnh_antecedentes->serologia_hbv = $request->serologia_hbv;                        
        } else {
            $lnh_antecedentes->serologia_hbv = '';                        
        }

        if($request->serologia_hcv != null && strcmp($request->serologia_hcv, '') != 0){
            $lnh_antecedentes->serologia_hcv = $request->serologia_hcv;                        
        } else {
            $lnh_antecedentes->serologia_hcv = '';                        
        }

        if($request->serologia_hzv != null && strcmp($request->serologia_hzv, '') != 0){
            $lnh_antecedentes->serologia_hzv = $request->serologia_hzv;                        
        } else {
            $lnh_antecedentes->serologia_hzv = '';                        
        }

        if($request->serologia_cmv != null && strcmp($request->serologia_cmv, '') != 0){
            $lnh_antecedentes->serologia_cmv = $request->serologia_cmv;                        
        } else {
            $lnh_antecedentes->serologia_cmv = '';                        
        }

        if($request->serologia_hiv_4 != null && strcmp($request->serologia_hiv_4, '') != 0){
            $lnh_antecedentes->serologia_hiv_4 = $request->serologia_hiv_4;                        
        } else {
            $lnh_antecedentes->serologia_hiv_4 = '';                        
        }

        if($request->serologia_vdrl != null && strcmp($request->serologia_vdrl, '') != 0){
            $lnh_antecedentes->serologia_vdrl = $request->serologia_vdrl;                        
        } else {
            $lnh_antecedentes->serologia_vdrl = '';                        
        }

        $lnh_antecedentes->opcion_antigripal = $request->antigripal;                        
        $lnh_antecedentes->opcion_antineumococica = $request->antineumococica;
        $lnh_antecedentes->opcion_ecog = $request->opcion_antecedentes_ecog;

        if($request->insuficiencia_cardiaca != null && strcmp($request->insuficiencia_cardiaca, '') != 0){
            $lnh_antecedentes->insuficiencia_cardiaca = $request->insuficiencia_cardiaca;                        
        } else {
            $lnh_antecedentes->insuficiencia_cardiaca = '';                        
        }

        if($request->epoc != null && strcmp($request->epoc, '') != 0){
            $lnh_antecedentes->epoc = $request->epoc;                        
        } else {
            $lnh_antecedentes->epoc = '';                        
        }

        if($request->insuficiencia_renal != null && strcmp($request->insuficiencia_renal, '') != 0){
            $lnh_antecedentes->insuficiencia_renal = $request->insuficiencia_renal;                        
        } else {
            $lnh_antecedentes->insuficiencia_renal = '';                        
        }

        if($request->hepatopatia != null && strcmp($request->hepatopatia, '') != 0){
            $lnh_antecedentes->hepatopatia = $request->hepatopatia;                        
        } else {
            $lnh_antecedentes->hepatopatia = '';                        
        }

        if($request->diabetes != null && strcmp($request->diabetes, '') != 0){
            $lnh_antecedentes->diabetes = $request->diabetes;                        
        } else {
            $lnh_antecedentes->diabetes = '';                        
        }

        if($request->hiv != null && strcmp($request->hiv, '') != 0){
            $lnh_antecedentes->hiv = $request->hiv;                        
        } else {
            $lnh_antecedentes->hiv = '';                        
        }

        if($request->score_charlson != null && strcmp($request->score_charlson, '') != 0){
            $lnh_antecedentes->score_charlson = $request->score_charlson;                        
        } else {
            $lnh_antecedentes->score_charlson = '';                        
        }

        
        $lnh_antecedentes->activo = 1;
        $lnh_antecedentes->save();

        return response()->json(array('response'=>1));     
    }

    function guardarPronosticoLnh(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'l_n_h_pronosticos');
        if($existeConsulta != null){
            $lnh_pronosticos = LNHPronosticos::find($existeConsulta->id);
        } else {
            $lnh_pronosticos = new LNHPronosticos;
            $lnh_pronosticos->consulta_id = $consulta;
            $lnh_pronosticos->paciente_id = $paciente;    
        }
                
        if($request->ecog != null && strcmp($request->ecog, '') != 0){
            $lnh_pronosticos->ecog = $request->ecog;                        
        } else {
            $lnh_pronosticos->ecog = '';                        
        }

        if($request->ldh != null && strcmp($request->ldh, '') != 0){
            $lnh_pronosticos->ldh = $request->ldh;                        
        } else {
            $lnh_pronosticos->ldh = '';                        
        }

        if($request->testiculo != null && strcmp($request->testiculo, '') != 0){
            $lnh_pronosticos->testiculo = $request->testiculo;                        
        } else {
            $lnh_pronosticos->testiculo = '';                        
        }

        if($request->extra_nodal != null && strcmp($request->extra_nodal, '') != 0){
            $lnh_pronosticos->extra_nodal_renal = $request->extra_nodal;                        
        } else {
            $lnh_pronosticos->extra_nodal_renal = '';                        
        }

        if($request->snc != null && strcmp($request->snc, '') != 0){
            $lnh_pronosticos->snc = $request->snc;                        
        } else {
            $lnh_pronosticos->snc = '';                        
        }

        if($request->edad_60 != null && strcmp($request->edad_60, '') != 0){
            $lnh_pronosticos->edad_60 = $request->edad_60;                        
        } else {
            $lnh_pronosticos->edad_60 = '';                        
        }
    
        if($request->doble_hit != null && strcmp($request->doble_hit, '') != 0){
            $lnh_pronosticos->doble_hit = $request->doble_hit;                        
        } else {
            $lnh_pronosticos->doble_hit = '';                        
        }

        if($request->sintomas_b != null && strcmp($request->sintomas_b, '') != 0){
            $lnh_pronosticos->sintomas_b = $request->sintomas_b;                        
        } else {
            $lnh_pronosticos->sintomas_b = '';                        
        }

        if($request->m_osea != null && strcmp($request->m_osea, '') != 0){
            $lnh_pronosticos->m_osea = $request->m_osea;                        
        } else {
            $lnh_pronosticos->m_osea = '';                        
        }

        if($request->bulky != null && strcmp($request->bulky, '') != 0){
            $lnh_pronosticos->bulky = $request->bulky;                        
        } else {
            $lnh_pronosticos->bulky = '';                        
        }

        if($request->hiv != null && strcmp($request->hiv, '') != 0){
            $lnh_pronosticos->hiv = $request->hiv;                        
        } else {
            $lnh_pronosticos->hiv = '';                        
        }

        $lnh_pronosticos->opcion_ripi = $request->opcion_ripi;
        $lnh_pronosticos->checkbox_ripi_riesgo_bajo = $request->ripi_bajo;
        $lnh_pronosticos->checkbox_ripi_riesgo_intermedio_bajo = $request->ripi_bajo_2;
        $lnh_pronosticos->checkbox_ripi_riesgo_intermedio_alto = $request->ripi_intermedio;
        $lnh_pronosticos->checkbox_ripi_riesgo_alto = $request->ripi_alto;

        $lnh_pronosticos->opcion_flipi = $request->opcion_flipi;
        $lnh_pronosticos->checkbox_flipi_bajo = $request->flipi_bajo;
        $lnh_pronosticos->checkbox_flipi_intermedio_bajo = $request->flipi_intermedio;
        $lnh_pronosticos->checkbox_flipi_alto = $request->flipi_alto;

        $lnh_pronosticos->opcion_mipi_edad = $request->opcion_mipi_edad;
        $lnh_pronosticos->opcion_mipi_ecog = $request->opcion_mipi_ecog;
        $lnh_pronosticos->opcion_mipi_ldh = $request->opcion_mipi_ldh;
        $lnh_pronosticos->opcion_mipi_leucocitos = $request->opcion_mipi_leucocitos;

        $lnh_pronosticos->activo = 1;
        $lnh_pronosticos->save();

        return response()->json(array('response'=>1));  
    }

    function guardarSangreGm(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'g_m_sangres');
        if($existeConsulta != null){
            $gm_sangre = GMSangre::find($existeConsulta->id);
        } else {
            $gm_sangre = new GMSangre;
            $gm_sangre->consulta_id = $consulta;
            $gm_sangre->paciente_id = $paciente;    
        }
                
        if($request->hto_hb_vcm != null && strcmp($request->hto_hb_vcm, '') != 0){
            $gm_sangre->hto_hb_vcm = $request->hto_hb_vcm;                        
        } else {
            $gm_sangre->hto_hb_vcm = '';                        
        }

        if($request->leucocitos != null && strcmp($request->leucocitos, '') != 0){
            $gm_sangre->leucocitos = $request->leucocitos;                        
        } else {
            $gm_sangre->leucocitos = '';                        
        }

        
        if($request->plaquetas != null && strcmp($request->plaquetas, '') != 0){
            $gm_sangre->plaquetas = $request->plaquetas;                        
        } else {
            $gm_sangre->plaquetas = '';                        
        }

        if($request->urea_creatinina != null && strcmp($request->urea_creatinina, '') != 0){
            $gm_sangre->urea_creatinina = $request->urea_creatinina;                        
        } else {
            $gm_sangre->urea_creatinina = '';                        
        }

        if($request->ci_creat != null && strcmp($request->ci_creat, '') != 0){
            $gm_sangre->ci_creat_ml_min = $request->ci_creat;                        
        } else {
            $gm_sangre->ci_creat_ml_min = '';                        
        }

        if($request->calcemia != null && strcmp($request->calcemia, '') != 0){
            $gm_sangre->calcemia = $request->calcemia;                        
        } else {
            $gm_sangre->calcemia = '';                        
        }

        if($request->vsg != null && strcmp($request->vsg, '') != 0){
            $gm_sangre->vsg = $request->vsg;                        
        } else {
            $gm_sangre->vsg = '';                        
        }

        if($request->ldh != null && strcmp($request->ldh, '') != 0){
            $gm_sangre->ldh = $request->ldh;                        
        } else {
            $gm_sangre->ldh = '';                        
        }

        if($request->b2_microglobulina != null && strcmp($request->b2_microglobulina, '') != 0){
            $gm_sangre->b2_microglobulina = $request->b2_microglobulina;                        
        } else {
            $gm_sangre->b2_microglobulina = '';                        
        }

        if($request->prot_totales != null && strcmp($request->prot_totales, '') != 0){
            $gm_sangre->proteinograma_prot_totales = $request->prot_totales;                        
        } else {
            $gm_sangre->proteinograma_prot_totales = '';                        
        }

        if($request->albumina != null && strcmp($request->albumina, '') != 0){
            $gm_sangre->proteinograma_albumina = $request->albumina;                        
        } else {
            $gm_sangre->proteinograma_albumina = '';                        
        }


        if($request->alfa != null && strcmp($request->alfa, '') != 0){
            $gm_sangre->proteinograma_alfa = $request->alfa;                        
        } else {
            $gm_sangre->proteinograma_alfa = '';                        
        }

        if($request->beta != null && strcmp($request->beta, '') != 0){
            $gm_sangre->proteinograma_beta = $request->beta;                        
        } else {
            $gm_sangre->proteinograma_beta = '';                        
        }

        if($request->gamma != null && strcmp($request->gamma, '') != 0){
            $gm_sangre->proteinograma_gamma = $request->gamma;                        
        } else {
            $gm_sangre->proteinograma_gamma = '';                        
        }

        if($request->obs != null && strcmp($request->obs, '') != 0){
            $gm_sangre->proteinograma_obs = $request->obs;                        
        } else {
            $gm_sangre->proteinograma_obs = '';                        
        }

        $gm_sangre->opcion_issr = $request->opcion_issr;                                

        if($request->dosaje_igg != null && strcmp($request->dosaje_igg, '') != 0){
            $gm_sangre->dosaje_igg = $request->dosaje_igg;                        
        } else {
            $gm_sangre->dosaje_igg = '';                        
        }

        if($request->dosaje_iga != null && strcmp($request->dosaje_iga, '') != 0){
            $gm_sangre->dosaje_iga = $request->dosaje_iga;                        
        } else {
            $gm_sangre->dosaje_iga = '';                        
        }

        if($request->dosaje_igm != null && strcmp($request->dosaje_igm, '') != 0){
            $gm_sangre->dosaje_igm = $request->dosaje_igm;                        
        } else {
            $gm_sangre->dosaje_igm = '';                        
        }

        if($request->dosaje_igd != null && strcmp($request->dosaje_igd, '') != 0){
            $gm_sangre->dosaje_igd = $request->dosaje_igd;                        
        } else {
            $gm_sangre->dosaje_igd = '';                        
        }

        if($request->dosaje_ige != null && strcmp($request->dosaje_ige, '') != 0){
            $gm_sangre->dosaje_ige = $request->dosaje_ige;                        
        } else {
            $gm_sangre->dosaje_ige = '';                        
        }

        if($request->inmunofijacion != null && strcmp($request->inmunofijacion, '') != 0){
            $gm_sangre->inmunofijacion = $request->inmunofijacion;                        
        } else {
            $gm_sangre->inmunofijacion = '';                        
        }

        if($request->klibre_llibre != null && strcmp($request->klibre_llibre, '') != 0){
            $gm_sangre->k_libre_l_libre = $request->klibre_llibre;                        
        } else {
            $gm_sangre->k_libre_l_libre = '';                        
        }

        if($request->componente_m != null && strcmp($request->componente_m, '') != 0){
            $gm_sangre->componente_m = $request->componente_m;                        
        } else {
            $gm_sangre->componente_m = '';                        
        }

        if($request->b_cross_laps != null && strcmp($request->b_cross_laps, '') != 0){
            $gm_sangre->b_cross_laps = $request->b_cross_laps;                        
        } else {
            $gm_sangre->b_cross_laps = '';                        
        }

        if($request->dosaje_b_cross_laps != null && strcmp($request->dosaje_b_cross_laps, '') != 0){
            $gm_sangre->b_cross_laps = $request->dosaje_b_cross_laps;                        
        } else {
            $gm_sangre->b_cross_laps = '';                        
        }

        $gm_sangre->activo = 1;
        $gm_sangre->save();

        return response()->json(array('response'=>1));  
    }

    function guardarOrinaGm(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'g_m_orinas');
        if($existeConsulta != null){
            $gm_orina = GMOrina::find($existeConsulta->id);
        } else {
            $gm_orina = new GMOrina;
            $gm_orina->consulta_id = $consulta;
            $gm_orina->paciente_id = $paciente;    
        }
                
        if($request->proteinuria != null && strcmp($request->proteinuria, '') != 0){
            $gm_orina->proteinuria = $request->proteinuria;                        
        } else {
            $gm_orina->proteinuria = '';                        
        }

        if($request->proteinograma != null && strcmp($request->proteinograma, '') != 0){
            $gm_orina->proteinograma = $request->proteinograma;                        
        } else {
            $gm_orina->proteinograma = '';                        
        }

        if($request->if_orina != null && strcmp($request->if_orina, '') != 0){
            $gm_orina->if_orina = $request->if_orina;                        
        } else {
            $gm_orina->if_orina = '';                        
        }

        if($request->comp_mbence_jones != null && strcmp($request->comp_mbence_jones, '') != 0){
            $gm_orina->comp_m_bence_jones = $request->comp_mbence_jones;                        
        } else {
            $gm_orina->comp_m_bence_jones = '';                        
        }

        $gm_orina->activo = 1;
        $gm_orina->save();

        return response()->json(array('response'=>1)); 
    }

    function guardarMedulaOseaGm(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'g_m_medula_oseas');
        if($existeConsulta != null){
            $gm_medual_osea = GMMedulaOsea::find($existeConsulta->id);
        } else {
            $gm_medual_osea = new GMMedulaOsea;
            $gm_medual_osea->consulta_id = $consulta;
            $gm_medual_osea->paciente_id = $paciente;    
        }
                
        if($request->plasmocitos != null && strcmp($request->plasmocitos, '') != 0){
            $gm_medual_osea->cmf_plasmocitos = $request->plasmocitos;                        
        } else {
            $gm_medual_osea->cmf_plasmocitos = '';                        
        }

        if($request->aberrantes != null && strcmp($request->aberrantes, '') != 0){
            $gm_medual_osea->cmf_aberrantes = $request->aberrantes;                        
        } else {
            $gm_medual_osea->cmf_aberrantes = '';                        
        }

        if($request->bandeo_g != null && strcmp($request->bandeo_g, '') != 0){
            $gm_medual_osea->citogenetico_bandeo_g = $request->bandeo_g;                        
        } else {
            $gm_medual_osea->citogenetico_bandeo_g = '';                        
        }

        if($request->fish_17 != null && strcmp($request->fish_17, '') != 0){
            $gm_medual_osea->citogenetico_fish_17p = $request->fish_17;                        
        } else {
            $gm_medual_osea->citogenetico_fish_17p = '';                        
        }

        if($request->fish_1 != null && strcmp($request->fish_1, '') != 0){
            $gm_medual_osea->citogenetico_fish_1q = $request->fish_1;                        
        } else {
            $gm_medual_osea->citogenetico_fish_1q = '';                        
        }

        if($request->fish_14 != null && strcmp($request->fish_14, '') != 0){
            $gm_medual_osea->citogenetico_fish_14q_32 = $request->fish_14;                        
        } else {
            $gm_medual_osea->citogenetico_fish_14q_32 = '';                        
        }

        if($request->biopsia_plasmocitos != null && strcmp($request->biopsia_plasmocitos, '') != 0){
            $gm_medual_osea->biopsia_plasmocitos = $request->biopsia_plasmocitos;                        
        } else {
            $gm_medual_osea->biopsia_plasmocitos = '';                        
        }

        $gm_medual_osea->activo = 1;
        $gm_medual_osea->save();

        return response()->json(array('response'=>1)); 
    }

    function guardarAntecedentesPersonalesGm(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'g_m_antecedentes_personales');
        if($existeConsulta != null){
            $gm_antecedentes_personales = GMAntecedentesPersonales::find($existeConsulta->id);
        } else {
            $gm_antecedentes_personales = new GMAntecedentesPersonales;
            $gm_antecedentes_personales->consulta_id = $consulta;
            $gm_antecedentes_personales->paciente_id = $paciente;    
        }
                
        if($request->serologia_hbv != null && strcmp($request->serologia_hbv, '') != 0){
            $gm_antecedentes_personales->serologia_hbv = $request->serologia_hbv;                        
        } else {
            $gm_antecedentes_personales->serologia_hbv = '';                        
        }

        if($request->serologia_hcv != null && strcmp($request->serologia_hcv, '') != 0){
            $gm_antecedentes_personales->serologia_hcv = $request->serologia_hcv;                        
        } else {
            $gm_antecedentes_personales->serologia_hcv = '';                        
        }

        if($request->serologia_hzv != null && strcmp($request->serologia_hzv, '') != 0){
            $gm_antecedentes_personales->serologia_hzv = $request->serologia_hzv;                        
        } else {
            $gm_antecedentes_personales->serologia_hzv = '';                        
        }

        if($request->serologia_cmv != null && strcmp($request->serologia_cmv, '') != 0){
            $gm_antecedentes_personales->serologia_cmv = $request->serologia_cmv;                        
        } else {
            $gm_antecedentes_personales->serologia_cmv = '';                        
        }

        if($request->serologia_hiv_4 != null && strcmp($request->serologia_hiv_4, '') != 0){
            $gm_antecedentes_personales->serologia_hiv_4 = $request->serologia_hiv_4;                        
        } else {
            $gm_antecedentes_personales->serologia_hiv_4 = '';                        
        }

        if($request->serologia_vdrl != null && strcmp($request->serologia_vdrl, '') != 0){
            $gm_antecedentes_personales->serologia_vdrl = $request->serologia_vdrl;                        
        } else {
            $gm_antecedentes_personales->serologia_vdrl = '';                        
        }

        $gm_antecedentes_personales->antigripal = $request->antigripal;                                
        $gm_antecedentes_personales->antineumococica = $request->antineumococica;                                
        $gm_antecedentes_personales->opcion_ecog = $request->opcion_ecog;                                
        

        if($request->insuficiencia_cardiaca != null && strcmp($request->insuficiencia_cardiaca, '') != 0){
            $gm_antecedentes_personales->ant_enfermedad_insuficiencia_cardiaca = $request->insuficiencia_cardiaca;                        
        } else {
            $gm_antecedentes_personales->ant_enfermedad_insuficiencia_cardiaca = '';                        
        }

        if($request->epoc != null && strcmp($request->epoc, '') != 0){
            $gm_antecedentes_personales->ant_enfermedad_epoc = $request->epoc;                        
        } else {
            $gm_antecedentes_personales->ant_enfermedad_epoc = '';                        
        }

        if($request->insuficiencia_renal != null && strcmp($request->insuficiencia_renal, '') != 0){
            $gm_antecedentes_personales->ant_enfermedad_insuficiencia_renal = $request->insuficiencia_renal;                        
        } else {
            $gm_antecedentes_personales->ant_enfermedad_insuficiencia_renal = '';                        
        }

        if($request->hepatopatia != null && strcmp($request->hepatopatia, '') != 0){
            $gm_antecedentes_personales->ant_enfermedad_hepatopatia = $request->hepatopatia;                        
        } else {
            $gm_antecedentes_personales->ant_enfermedad_hepatopatia = '';                        
        }

        if($request->diabetes != null && strcmp($request->diabetes, '') != 0){
            $gm_antecedentes_personales->ant_enfermedad_diabetes = $request->diabetes;                        
        } else {
            $gm_antecedentes_personales->ant_enfermedad_diabetes = '';                        
        }

        if($request->hiv != null && strcmp($request->hiv, '') != 0){
            $gm_antecedentes_personales->ant_enfermedad_hiv = $request->hiv;                        
        } else {
            $gm_antecedentes_personales->ant_enfermedad_hiv = '';                        
        }

        if($request->otro != null && strcmp($request->otro, '') != 0){
            $gm_antecedentes_personales->ant_enfermedad_otro = $request->otro;                        
        } else {
            $gm_antecedentes_personales->ant_enfermedad_otro = '';                        
        }

        if($request->score_charlson_puntaje != null && strcmp($request->score_charlson_puntaje, '') != 0){
            $gm_antecedentes_personales->score_charlson_puntaje = $request->score_charlson_puntaje;
        } else {
            $gm_antecedentes_personales->score_charlson_puntaje = '';                        
        }

        $gm_antecedentes_personales->indice_katz_banio = $request->opcion_indice_katz_gm_1;
        $gm_antecedentes_personales->indice_katz_vestimenta = $request->opcion_indice_katz_gm_2;
        $gm_antecedentes_personales->indice_katz_movilidad = $request->opcion_indice_katz_gm_3;
        $gm_antecedentes_personales->indice_katz_continencia = $request->opcion_indice_katz_gm_4;
        $gm_antecedentes_personales->indice_katz_alimentacion = $request->opcion_indice_katz_gm_5;
        
        $gm_antecedentes_personales->activo = 1;
        $gm_antecedentes_personales->save();

        return response()->json(array('response'=>1)); 
    }

    function guardarDiagnosticoGm(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'g_m_diagnosticos');
        if($existeConsulta != null){
            $gm_diagnostico = GMDiagnostico::find($existeConsulta->id);
        } else {
            $gm_diagnostico = new GMDiagnostico;
            $gm_diagnostico->consulta_id = $consulta;
            $gm_diagnostico->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $gm_diagnostico->descripcion = $request->descripcion;                        
        } else {
            $gm_diagnostico->descripcion = '';                        
        }

        $gm_diagnostico->activo = 1;
        $gm_diagnostico->save();

        return response()->json(array('response'=>1)); 
    }

    function guardarTratamientoGm(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'g_m_tratamientos');
        if($existeConsulta != null){
            $gm_tratamiento = GMTratamiento::find($existeConsulta->id);
        } else {
            $gm_tratamiento = new GMTratamiento;
            $gm_tratamiento->consulta_id = $consulta;
            $gm_tratamiento->paciente_id = $paciente;    
        }
                
        if($request->rvd != null && strcmp($request->rvd, '') != 0){
            $gm_tratamiento->rvd = $request->rvd;                        
        } else {
            $gm_tratamiento->rvd = '';                        
        }

        if($request->rd != null && strcmp($request->rd, '') != 0){
            $gm_tratamiento->rd = $request->rd;                        
        } else {
            $gm_tratamiento->rd = '';                        
        }

        if($request->cybord != null && strcmp($request->cybord, '') != 0){
            $gm_tratamiento->cybord = $request->cybord;                        
        } else {
            $gm_tratamiento->cybord = '';                        
        }

        if($request->mpv != null && strcmp($request->mpv, '') != 0){
            $gm_tratamiento->mpv = $request->mpv;                        
        } else {
            $gm_tratamiento->mpv = '';                        
        }

        if($request->mp != null && strcmp($request->mp, '') != 0){
            $gm_tratamiento->mp = $request->mp;                        
        } else {
            $gm_tratamiento->mp = '';                        
        }

        $gm_tratamiento->activo = 1;
        $gm_tratamiento->save();

        return response()->json(array('response'=>1)); 
    }

    function guardarEstudioDiagnosticoPm(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'p_m_estudios_diagnosticos');
        if($existeConsulta != null){
            $pm_estudios_diagnosticos = PMEstudiosDiagnosticos::find($existeConsulta->id);
        } else {
            $pm_estudios_diagnosticos = new PMEstudiosDiagnosticos;
            $pm_estudios_diagnosticos->consulta_id = $consulta;
            $pm_estudios_diagnosticos->paciente_id = $paciente;    
        }
        
        if($request->fecha1 != null && strcmp($request->fecha1, '') != 0){            
            $fecha_aux = explode('/', $request->fecha1);        
            $fecha = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];                          
            $pm_estudios_diagnosticos->fecha1 = $fecha;                        
        } else {
            $pm_estudios_diagnosticos->fecha1 = '2000-01-01';                        
        }

        if($request->fecha2 != null && strcmp($request->fecha2, '') != 0){            
            $fecha_aux = explode('/', $request->fecha2);        
            $fecha = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];                          
            $pm_estudios_diagnosticos->fecha2 = $fecha;                        
        } else {
            $pm_estudios_diagnosticos->fecha2 = '2000-01-01';                        
        }

        if($request->hto_hb != null && strcmp($request->hto_hb, '') != 0){
            $pm_estudios_diagnosticos->hto_hb = $request->hto_hb;                        
        } else {
            $pm_estudios_diagnosticos->hto_hb = '';                        
        }

        if($request->hiv != null && strcmp($request->hiv, '') != 0){
            $pm_estudios_diagnosticos->hiv = $request->hiv;                        
        } else {
            $pm_estudios_diagnosticos->hiv = '';                        
        }    

        if($request->biopsia_mo != null && strcmp($request->biopsia_mo, '') != 0){
            $pm_estudios_diagnosticos->biopsia_mo = $request->biopsia_mo;                        
        } else {
            $pm_estudios_diagnosticos->biopsia_mo = '';                        
        }

        if($request->vcm != null && strcmp($request->vcm, '') != 0){
            $pm_estudios_diagnosticos->vcm = $request->vcm;                        
        } else {
            $pm_estudios_diagnosticos->vcm = '';                        
        }

        if($request->vdrl != null && strcmp($request->vdrl, '') != 0){
            $pm_estudios_diagnosticos->vdrl = $request->vdrl;                        
        } else {
            $pm_estudios_diagnosticos->vdrl = '';                        
        }

        if($request->gb_pmn != null && strcmp($request->gb_pmn, '') != 0){
            $pm_estudios_diagnosticos->gb_pmn = $request->gb_pmn;                        
        } else {
            $pm_estudios_diagnosticos->gb_pmn = '';                        
        }

        if($request->hbv != null && strcmp($request->hbv, '') != 0){
            $pm_estudios_diagnosticos->hbv = $request->hbv;                        
        } else {
            $pm_estudios_diagnosticos->hbv = '';                        
        }

        if($request->citogenetico != null && strcmp($request->citogenetico, '') != 0){
            $pm_estudios_diagnosticos->citogenetico = $request->citogenetico;                        
        } else {
            $pm_estudios_diagnosticos->citogenetico = '';                        
        }

        if($request->plaquetas != null && strcmp($request->plaquetas, '') != 0){
            $pm_estudios_diagnosticos->plaquetas = $request->plaquetas;                        
        } else {
            $pm_estudios_diagnosticos->plaquetas = '';                        
        }

        if($request->hcv != null && strcmp($request->hcv, '') != 0){
            $pm_estudios_diagnosticos->hcv = $request->hcv;                        
        } else {
            $pm_estudios_diagnosticos->hcv = '';                        
        }

        if($request->albumina != null && strcmp($request->albumina, '') != 0){
            $pm_estudios_diagnosticos->albumina = $request->albumina;                        
        } else {
            $pm_estudios_diagnosticos->albumina = '';                        
        }

        if($request->otro != null && strcmp($request->otro, '') != 0){
            $pm_estudios_diagnosticos->otro = $request->otro;                        
        } else {
            $pm_estudios_diagnosticos->otro = '';                        
        }

        if($request->categoria_who != null && strcmp($request->categoria_who, '') != 0){
            $pm_estudios_diagnosticos->categoria_who_2016 = $request->categoria_who;                        
        } else {
            $pm_estudios_diagnosticos->categoria_who_2016 = '';                        
        }

        if($request->ldh != null && strcmp($request->ldh, '') != 0){
            $pm_estudios_diagnosticos->ldh = $request->ldh;                        
        } else {
            $pm_estudios_diagnosticos->ldh = '';                        
        }

        if($request->gyf != null && strcmp($request->gyf, '') != 0){
            $pm_estudios_diagnosticos->gyf = $request->gyf;                        
        } else {
            $pm_estudios_diagnosticos->gyf = '';                        
        }

        if($request->puntaje_ipssr != null && strcmp($request->puntaje_ipssr, '') != 0){
            $pm_estudios_diagnosticos->puntaje_ipss_r = $request->puntaje_ipssr;                        
        } else {
            $pm_estudios_diagnosticos->puntaje_ipss_r = '';                        
        }

        if($request->ers != null && strcmp($request->ers, '') != 0){
            $pm_estudios_diagnosticos->ers = $request->ers;                        
        } else {
            $pm_estudios_diagnosticos->ers = '';                        
        }

        if($request->pcd != null && strcmp($request->pcd, '') != 0){
            $pm_estudios_diagnosticos->pcd = $request->pcd;                        
        } else {
            $pm_estudios_diagnosticos->pcd = '';                        
        }

        if($request->mortalidad != null && strcmp($request->mortalidad, '') != 0){
            $pm_estudios_diagnosticos->mortalidad = $request->mortalidad;                        
        } else {
            $pm_estudios_diagnosticos->mortalidad = '';                        
        }

        if($request->ferremia != null && strcmp($request->ferremia, '') != 0){
            $pm_estudios_diagnosticos->ferremia = $request->ferremia;                        
        } else {
            $pm_estudios_diagnosticos->ferremia = '';                        
        }

        if($request->pci != null && strcmp($request->pci, '') != 0){
            $pm_estudios_diagnosticos->pci = $request->pci;                        
        } else {
            $pm_estudios_diagnosticos->pci = '';                        
        }

        if($request->progresion_leucemia != null && strcmp($request->progresion_leucemia, '') != 0){
            $pm_estudios_diagnosticos->progresion_leucemia = $request->progresion_leucemia;                        
        } else {
            $pm_estudios_diagnosticos->progresion_leucemia = '';                        
        }

        if($request->ferritina != null && strcmp($request->ferritina, '') != 0){
            $pm_estudios_diagnosticos->ferritina = $request->ferritina;                        
        } else {
            $pm_estudios_diagnosticos->ferritina = '';                        
        }

        if($request->score_charlson != null && strcmp($request->score_charlson, '') != 0){
            $pm_estudios_diagnosticos->score_charlson = $request->score_charlson;                        
        } else {
            $pm_estudios_diagnosticos->score_charlson = '';                        
        }

        if($request->transferrina != null && strcmp($request->transferrina, '') != 0){
            $pm_estudios_diagnosticos->transferrina = $request->transferrina;                        
        } else {
            $pm_estudios_diagnosticos->transferrina = '';                        
        }

        if($request->sat_transf != null && strcmp($request->sat_transf, '') != 0){
            $pm_estudios_diagnosticos->sat_transf = $request->sat_transf;                        
        } else {
            $pm_estudios_diagnosticos->sat_transf = '';                        
        }

        if($request->comorbilidades != null && strcmp($request->comorbilidades, '') != 0){
            $pm_estudios_diagnosticos->comorbilidades = $request->comorbilidades;                        
        } else {
            $pm_estudios_diagnosticos->comorbilidades = '';                        
        }

        if($request->dosaje_epo != null && strcmp($request->dosaje_epo, '') != 0){
            $pm_estudios_diagnosticos->dosaje_epo = $request->dosaje_epo;                        
        } else {
            $pm_estudios_diagnosticos->dosaje_epo = '';                        
        }
        $pm_estudios_diagnosticos->activo = 1;
        $pm_estudios_diagnosticos->save();

        return response()->json(array('response'=>1)); 
    }

    function guardarTratamientoPm(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'p_m_tratamientos');
        if($existeConsulta != null){
            $pm_tratamiento = PMTratamiento::find($existeConsulta->id);
        } else {
            $pm_tratamiento = new PMTratamiento;
            $pm_tratamiento->consulta_id = $consulta;
            $pm_tratamiento->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $pm_tratamiento->descripcion = $request->descripcion;                        
        } else {
            $pm_tratamiento->descripcion = '';                        
        }
     
        $pm_tratamiento->activo = 1;
        $pm_tratamiento->save();

        return response()->json(array('response'=>1)); 
    }

    function guardarIpssrPm(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'p_m_ipssrs');
        if($existeConsulta != null){
            $pm_ippsr = PMIpssr::find($existeConsulta->id);
        } else {
            $pm_ippsr = new PMIpssr;
            $pm_ippsr->consulta_id = $consulta;
            $pm_ippsr->paciente_id = $paciente;    
        }
                        
        $pm_ippsr->fila_1_opcion = $request->opcion_fila_1;                        
        $pm_ippsr->fila_2_opcion = $request->opcion_fila_2;                        
        $pm_ippsr->fila_3_opcion = $request->opcion_fila_3;                        
        $pm_ippsr->fila_4_opcion = $request->opcion_fila_4;                        
        $pm_ippsr->fila_5_opcion = $request->opcion_fila_5;                        
             
        $pm_ippsr->activo = 1;
        $pm_ippsr->save();

        return response()->json(array('response'=>1));    
    }

    function guardarPuntajePm(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'p_m_puntajes');
        if($existeConsulta != null){
            $pm_puntaje = PMPuntaje::find($existeConsulta->id);
        } else {
            $pm_puntaje = new PMPuntaje;
            $pm_puntaje->consulta_id = $consulta;
            $pm_puntaje->paciente_id = $paciente;    
        }
                        
        $pm_puntaje->opcion_fila = $request->opcion_puntaje;                        
        
        $pm_puntaje->activo = 1;
        $pm_puntaje->save();

        return response()->json(array('response'=>1)); 
    }

    function guardarEvolucion(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'evolucions');
        if($existeConsulta != null){
            $evolucion = Evolucion::find($existeConsulta->id);
        } else {
            $evolucion = new Evolucion;
            $evolucion->consulta_id = $consulta;
            $evolucion->paciente_id = $paciente;    
            $evolucion->audio = '';    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $evolucion->descripcion = $request->descripcion;                        
        } else {
            $evolucion->descripcion = '';                        
        }
     
        $evolucion->activo = 1;
        $evolucion->save();

        return response()->json(array('response'=>1)); 
    }

    function cargarMedicacionActual(Request $request){        
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
        $parcial = $request->parcial;
                
        if($parcial == 1){
            $consulta = DB::table('medicacion_actuals')
                        ->join('consultas', 'consultas.id', 'medicacion_actuals.consulta_id')
                        ->join('users', 'users.id', 'consultas.medico_id')
                        ->select('medicacion_actuals.*', 'users.name')
                        ->where('medicacion_actuals.paciente_id', $paciente_id)                            
                        ->where('medicacion_actuals.consulta_id', $consulta_id)                            
                        ->where('medicacion_actuals.activo', 1)
                        ->orderby('medicacion_actuals.id', 'desc')                            
                        ->get();
        } else {
            $consulta = DB::table('medicacion_actuals')
                        ->join('consultas', 'consultas.id', 'medicacion_actuals.consulta_id')
                        ->join('users', 'users.id', 'consultas.medico_id')
                        ->select('medicacion_actuals.*', 'users.name')
                        ->where('medicacion_actuals.paciente_id', $paciente_id)              
                        ->where('medicacion_actuals.activo', 1)
                        ->orderby('medicacion_actuals.id', 'desc')                            
                        ->get();
        }

        $response = 0;
        if($consulta->count() > 0)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));
    }

    function guardarMedicacionActual(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'medicacion_actuals');
        if($existeConsulta != null){
            $medicacionActual = MedicacionActual::find($existeConsulta->id);
        } else {
            $medicacionActual = new MedicacionActual;
            $medicacionActual->consulta_id = $consulta;
            $medicacionActual->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $medicacionActual->descripcion = $request->descripcion;                        
        } else {
            $medicacionActual->descripcion = '';                        
        }
     
        $medicacionActual->activo = 1;
        $medicacionActual->save();

        return response()->json(array('response'=>1)); 
    }

    function guardarConductas(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'conductas');
        if($existeConsulta != null){
            $conducta = Conducta::find($existeConsulta->id);
        } else {
            $conducta = new Conducta;
            $conducta->consulta_id = $consulta;
            $conducta->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $conducta->descripcion = $request->descripcion;                        
        } else {
            $conducta->descripcion = '';                        
        }
     
        $conducta->activo = 1;
        $conducta->save();

        return response()->json(array('response'=>1)); 
    }

    function cargarEvolucion(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
        $parcial = $request->parcial;
                
        if($parcial == 1){
            $consulta = DB::table('evolucions')
                            ->where('evolucions.paciente_id', $paciente_id)                            
                            ->where('evolucions.consulta_id', $consulta_id)                            
                            ->where('evolucions.activo', 1)
                            ->orderby('evolucions.id', 'desc')                            
                            ->get();
                            
            $consulta_fotos = DB::table('evolucion_fotos')
                ->where('evolucion_fotos.consulta_id', $consulta_id)                            
                ->where('evolucion_fotos.activo', 1)
                ->orderby('evolucion_fotos.id', 'desc')                            
                ->get();
        } else {
            $consulta = DB::table('evolucions')
                            ->where('evolucions.paciente_id', $paciente_id)                            
                            ->where('evolucions.activo', 1)
                            ->orderby('evolucions.id', 'desc')                            
                            ->get();

            $consulta_fotos = DB::table('evolucion_fotos')
                                ->where('evolucion_fotos.consulta_id', $consulta_id)                            
                                ->where('evolucion_fotos.activo', 1)
                                ->orderby('evolucion_fotos.id', 'desc')                            
                                ->get();
        }

        $consulta_fotos_cantidad = $consulta_fotos->count();
        $response = 0;
        if($consulta->count() > 0)
            $response = 1;
        
        $data = $this->crearJsonEvolucion($paciente_id);            
        $evolucionImagen = json_decode($data, true);

        return response()->json(array('response'=>$response, 'response_data'=>$consulta, 'consulta_fotos_cantidad'=>$consulta_fotos_cantidad,'consulta_fotos'=>$consulta_fotos, 'evoluciones'=>$evolucionImagen));    
    }

    function crearJsonEvolucion($paciente_id){
        $evoluciones = DB::table('evolucions')
                                ->join('consultas', 'consultas.id', 'evolucions.consulta_id')
                                ->join('users', 'users.id', 'consultas.medico_id')
                                ->select('evolucions.*', 'users.name')
                                ->where('evolucions.paciente_id', $paciente_id)                            
                                ->where('evolucions.activo', 1)
                                //->orderby('evolucions.id', 'desc')                            
                                ->get();
        $json = array();
        $data = array();
        foreach ($evoluciones as $val) {
            $json['evolucion_id'] = $val->id;
            $json['audio'] = $val->audio;
            $json['descripcion'] = $val->descripcion;                   
            $json['imagen'] = $this->getImagenEvolucion($val->id);      
            $json['fecha'] = $val->created_at;
            $json['profesional'] = $this->getNombreProfesional($val->name);    //apellido, nombre                             
            $data[] = $json;
        }
        return json_encode($data);  
    }

    function getNombreProfesional($name){
        $name_aux = explode(',',$name);
        $apellido = $name_aux[0];
        $nombre = $name_aux[1];
        return $apellido.', '.strtoupper(substr($nombre, 0, 2));
    }

    function getImagenEvolucion($evolucion_id){
        $foto = DB::table('evolucion_fotos')
                    ->where('evolucion_fotos.evolucion_id', $evolucion_id)                            
                    ->where('evolucion_fotos.activo', 1)
                    ->orderby('evolucion_fotos.id', 'desc')                            
                    ->get();
        if($foto->count()>0){
            return $foto[0]->foto;
        } else {
            return "";
        }
    }

    function cargarConductas(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('conductas')
                            ->where('conductas.paciente_id', $paciente_id)
                            ->where('conductas.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null && strcmp($consulta->descripcion, '') != 0)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                   
    }

    function cargarSangreLh(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('l_h_sangres')
                            ->where('l_h_sangres.paciente_id', $paciente_id)
                            ->where('l_h_sangres.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                   
    }

    function cargarImagenesLh(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('l_h_imagenes')
                            ->where('l_h_imagenes.paciente_id', $paciente_id)
                            ->where('l_h_imagenes.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                   
    }

    function cargarBiopsiaLh(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('l_h_biopsias')
                            ->where('l_h_biopsias.paciente_id', $paciente_id)
                            ->where('l_h_biopsias.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                   
    }

    function cargarEstadioLh(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('l_h_estadios')
                            ->where('l_h_estadios.paciente_id', $paciente_id)
                            ->where('l_h_estadios.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }

    function cargarAntecedentesLh(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('l_h_antecedentes')
                            ->where('l_h_antecedentes.paciente_id', $paciente_id)
                            ->where('l_h_antecedentes.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }

    function cargarImagenesLnh(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('l_n_h_imagenes')
                            ->where('l_n_h_imagenes.paciente_id', $paciente_id)
                            ->where('l_n_h_imagenes.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }

    function cargarBiopsiaLnh(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('l_n_h_biopsia_c_mfs')
                            ->where('l_n_h_biopsia_c_mfs.paciente_id', $paciente_id)
                            ->where('l_n_h_biopsia_c_mfs.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }

    function cargarEstadioLnh(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('l_n_h_estadios')
                            ->where('l_n_h_estadios.paciente_id', $paciente_id)
                            ->where('l_n_h_estadios.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }

    function cargarAntecedentesLnh(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('l_n_h_antecedentes')
                            ->where('l_n_h_antecedentes.paciente_id', $paciente_id)
                            ->where('l_n_h_antecedentes.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }

    function cargarPronosticoLnh(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('l_n_h_pronosticos')
                            ->where('l_n_h_pronosticos.paciente_id', $paciente_id)
                            ->where('l_n_h_pronosticos.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }

    function cargarSangreGm(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('g_m_sangres')
                            ->where('g_m_sangres.paciente_id', $paciente_id)
                            ->where('g_m_sangres.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }

    function cargarOrinaGm(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('g_m_orinas')
                            ->where('g_m_orinas.paciente_id', $paciente_id)
                            ->where('g_m_orinas.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }
    
    function cargarMedulaOseaGm(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('g_m_medula_oseas')
                            ->where('g_m_medula_oseas.paciente_id', $paciente_id)
                            ->where('g_m_medula_oseas.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }
    
    function cargarAntecedentesPersonalesGm(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('g_m_antecedentes_personales')
                            ->where('g_m_antecedentes_personales.paciente_id', $paciente_id)
                            ->where('g_m_antecedentes_personales.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }

    function cargarDiagnosticoGm(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('g_m_diagnosticos')
                            ->where('g_m_diagnosticos.paciente_id', $paciente_id)
                            ->where('g_m_diagnosticos.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }
    
    function cargarTratamientoGm(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('g_m_tratamientos')
                            ->where('g_m_tratamientos.paciente_id', $paciente_id)
                            ->where('g_m_tratamientos.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }
    
    function cargarEstudioDiagnosticoPm(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('p_m_estudios_diagnosticos')
                            ->where('p_m_estudios_diagnosticos.paciente_id', $paciente_id)
                            ->where('p_m_estudios_diagnosticos.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }
    
    function cargarTratamientoPm(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('p_m_tratamientos')
                            ->where('p_m_tratamientos.paciente_id', $paciente_id)
                            ->where('p_m_tratamientos.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }
    
    function cargarIpssrPm(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('p_m_ipssrs')
                            ->where('p_m_ipssrs.paciente_id', $paciente_id)
                            ->where('p_m_ipssrs.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }
    
    function cargarPuntajePm(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('p_m_puntajes')
                            ->where('p_m_puntajes.paciente_id', $paciente_id)
                            ->where('p_m_puntajes.consulta_id', $consulta_id)
                            ->first();
        $response = 0;
        if($consulta != null)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));                      
    }

    function guardarDatosSubjetivos(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'datos_subjetivos');
        if($existeConsulta != null){
            $datosSubjetivos = DatosSubjetivo::find($existeConsulta->id);
        } else {
            $datosSubjetivos = new DatosSubjetivo;
            $datosSubjetivos->consulta_id = $consulta;
            $datosSubjetivos->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $datosSubjetivos->descripcion = $request->descripcion;                        
        } else {
            $datosSubjetivos->descripcion = '';                        
        }
     
        $datosSubjetivos->activo = 1;
        $datosSubjetivos->save();

        return response()->json(array('response'=>1));          
    }

    function cargarDatosSubjetivos(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('datos_subjetivos')
                            ->where('datos_subjetivos.paciente_id', $paciente_id)                            
                            ->where('datos_subjetivos.consulta_id', $consulta_id)                            
                            ->first();
        $response = 0;
        if($consulta != null && strcmp($consulta->descripcion, '') != 0)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));             
    }
    
    function guardarImagenCuerpoLnh(Request $request){
        $consulta_id = $request->cuerpo_consulta_id_lnh;
        $paciente_id = $request->cuerpo_paciente_id_lnh;                        
        
        $usuario_actual_nombre=\Auth::user()->email;   
        $pathFolderMedico_aux = explode('@', $usuario_actual_nombre);
        $pathFolderMedico = $pathFolderMedico_aux[0];
        
        $baseFromJavascript = $request->base64_lnh;

        if($baseFromJavascript != null){            
                $examenFisico = new ExamenFisico;
                $examenFisico->consulta_id = $consulta_id;
                $examenFisico->paciente_id = $paciente_id;                
                $examenFisico->linfoma_hodgkin = 0;
                $examenFisico->linfoma_no_hodgkin = 1;
                $examenFisico->gammapatia_monoclonal = 0;
                $examenFisico->activo = 1;
            //}

            // Obtener la extensión de la Imagen
            $img_extension = $this->getB64Extension($request->base64_lnh);
            // Crear un nombre aleatorio para la imagen
            $img_name = 'img_'. time() . '.' . $img_extension;             
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));
            $filepath = "img/".$pathFolderMedico."/linfoma_no_hodgkin/".$img_name;
            file_put_contents($filepath, $data);
            
            $examenFisico->foto = $pathFolderMedico.'/linfoma_no_hodgkin/'.$img_name;
            
            $examenFisico->save();

            $user=\Auth::user();   
            $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
            $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
            $medicoInfo->es_nueva_consulta = 6;
            $medicoInfo->save();

        }                
        return redirect()->route('navegarconsultaseleccionada'); 
        // return $baseFromJavascript;
    }

    function guardarImagenCuerpoGm(Request $request){
        $consulta_id = $request->cuerpo_consulta_id_gm;
        $paciente_id = $request->cuerpo_paciente_id_gm;                        
        
        $usuario_actual_nombre=\Auth::user()->email;   
        $pathFolderMedico_aux = explode('@', $usuario_actual_nombre);
        $pathFolderMedico = $pathFolderMedico_aux[0];
        
        $baseFromJavascript = $request->base64_gm;

        if($baseFromJavascript != null){            
                $examenFisico = new ExamenFisico;
                $examenFisico->consulta_id = $consulta_id;
                $examenFisico->paciente_id = $paciente_id;                
                $examenFisico->linfoma_hodgkin = 0;
                $examenFisico->linfoma_no_hodgkin = 0;
                $examenFisico->gammapatia_monoclonal = 1;
                $examenFisico->activo = 1;
            //}

            // Obtener la extensión de la Imagen
            $img_extension = $this->getB64Extension($request->base64_gm);
            // Crear un nombre aleatorio para la imagen
            $img_name = 'img_'. time() . '.' . $img_extension;             
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));
            $filepath = "img/".$pathFolderMedico."/gammapatia_monoclonal/".$img_name;
            file_put_contents($filepath, $data);
            
            $examenFisico->foto = $pathFolderMedico.'/gammapatia_monoclonal/'.$img_name;
            
            $examenFisico->save();

            $user=\Auth::user();   
            $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
            $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
            $medicoInfo->es_nueva_consulta = 7;
            $medicoInfo->save();

        }                
        return redirect()->route('navegarconsultaseleccionada'); 
        // return $baseFromJavascript;
    }

    function guardarImagenCuerpo(Request $request){
         // Obtener los datos de la imagen
        $consulta_id = $request->cuerpo_consulta_id;
        $paciente_id = $request->cuerpo_paciente_id;                        
        
        $usuario_actual_nombre=\Auth::user()->email;   
        $pathFolderMedico_aux = explode('@', $usuario_actual_nombre);
        $pathFolderMedico = $pathFolderMedico_aux[0];
        
        $baseFromJavascript = $request->base64;

        if($baseFromJavascript != null){            
                $examenFisico = new ExamenFisico;
                $examenFisico->consulta_id = $consulta_id;
                $examenFisico->paciente_id = $paciente_id;                
                $examenFisico->linfoma_hodgkin = 1;
                $examenFisico->linfoma_no_hodgkin = 0;
                $examenFisico->gammapatia_monoclonal = 0;
                $examenFisico->activo = 1;
            //}

            // Obtener la extensión de la Imagen
            $img_extension = $this->getB64Extension($request->base64);
            // Crear un nombre aleatorio para la imagen
            $img_name = 'img_'. time() . '.' . $img_extension;             
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));
            $filepath = "img/".$pathFolderMedico."/linfoma_hodgkin/".$img_name;
            file_put_contents($filepath, $data);
            
            $examenFisico->foto = $pathFolderMedico.'/linfoma_hodgkin/'.$img_name;
            
            $examenFisico->save();

            $user=\Auth::user();   
            $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
            $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
            $medicoInfo->es_nueva_consulta = 5;
            $medicoInfo->save();

        }                
        return redirect()->route('navegarconsultaseleccionada'); 
        // return $baseFromJavascript;
        
    }

    public function getB64Extension($base64_image, $full=null){  
        // Obtener mediante una expresión regular la extensión imagen y guardarla
        // en la variable "img_extension"        
        preg_match("/^data:image\/(.*);base64/i",$base64_image, $img_extension);   
        // Dependiendo si se pide la extensión completa o no retornar el arreglo con
        // los datos de la extensión en la posición 0 - 1
        return ($full) ?  $img_extension[0] : $img_extension[1];  
}


    function getImage64($filename){
        $file = Storage::disk('images_base64')->get($filename);
        return Response($file, 200);
    }

    function guardarControlAnticoagulacion(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $controlAnticoagulacion = new ControlAnticoagulacion;
        $controlAnticoagulacion->consulta_id = $consulta;
        $controlAnticoagulacion->paciente_id = $paciente;

        if($request->tp != null && strcmp($request->tp, '') != 0){
            $controlAnticoagulacion->tp = $request->tp;                        
        } else {
            $controlAnticoagulacion->tp = '';                        
        }

        if($request->rin != null && strcmp($request->rin, '') != 0){
            $controlAnticoagulacion->rin = $request->rin;                        
        } else {
            $controlAnticoagulacion->rin = '';                        
        }

        if($request->aptt != null && strcmp($request->aptt, '') != 0){
            $controlAnticoagulacion->aptt = $request->aptt;                        
        } else {
            $controlAnticoagulacion->aptt = '';                        
        }   
                
        if($request->fecha != null && strcmp($request->fecha, '') != 0){            
            $fecha_aux = explode('/', $request->fecha);        
            $fecha = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];                          
            $controlAnticoagulacion->fecha = $fecha;                        
        } else {
            $controlAnticoagulacion->fecha = '2000-01-01';                        
        }

        $controlAnticoagulacion->activo = 1;
        $controlAnticoagulacion->save();

        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);        
        $medicoInfo->es_nueva_consulta = 9 ;
        $medicoInfo->save();

        return response()->json(array('response'=>1));  
    }

    function guardarLaboratorioGeneral(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $laboratorioGeneral = new LaboratorioGeneral;
        $laboratorioGeneral->consulta_id = $consulta;
        $laboratorioGeneral->paciente_id = $paciente;

        if($request->hb != null && strcmp($request->hb, '') != 0){
            $laboratorioGeneral->hb_g_dl = $request->hb;                        
        } else {
            $laboratorioGeneral->hb_g_dl = '';                        
        }

        if($request->hto != null && strcmp($request->hto, '') != 0){
            $laboratorioGeneral->hto = $request->hto;                        
        } else {
            $laboratorioGeneral->hto = '';                        
        }  

        if($request->vcm != null && strcmp($request->vcm, '') != 0){
            $laboratorioGeneral->vcm_fl = $request->vcm;                        
        } else {
            $laboratorioGeneral->vcm_fl = '';                        
        }

        if($request->rto != null && strcmp($request->rto, '') != 0){
            $laboratorioGeneral->rto_gr = $request->rto;                        
        } else {
            $laboratorioGeneral->rto_gr = '';                        
        } 

        if($request->hcm != null && strcmp($request->hcm, '') != 0){
            $laboratorioGeneral->hcm = $request->hcm;                        
        } else {
            $laboratorioGeneral->hcm = '';                        
        }

        if($request->chcm != null && strcmp($request->chcm, '') != 0){
            $laboratorioGeneral->chcm = $request->chcm;                        
        } else {
            $laboratorioGeneral->chcm = '';                        
        }

        if($request->fsp != null && strcmp($request->fsp, '') != 0){
            $laboratorioGeneral->fsp = $request->fsp;                        
        } else {
            $laboratorioGeneral->fsp = '';                        
        }

        if($request->gb != null && strcmp($request->gb, '') != 0){
            $laboratorioGeneral->gb = $request->gb;                        
        } else {
            $laboratorioGeneral->gb = '';                        
        } 

        if($request->pqt != null && strcmp($request->pqt, '') != 0){
            $laboratorioGeneral->pqt = $request->pqt;                        
        } else {
            $laboratorioGeneral->pqt = '';                        
        }  

        if($request->ldh != null && strcmp($request->ldh, '') != 0){
            $laboratorioGeneral->ldh = $request->ldh;                        
        } else {
            $laboratorioGeneral->ldh = '';                        
        }   

        if($request->ers != null && strcmp($request->ers, '') != 0){
            $laboratorioGeneral->ers = $request->ers;                        
        } else {
            $laboratorioGeneral->ers = '';                        
        }

        if($request->b2 != null && strcmp($request->b2, '') != 0){
            $laboratorioGeneral->b2_microglob = $request->b2;                        
        } else {
            $laboratorioGeneral->b2_microglob = '';                        
        }
         
        if($request->urea != null && strcmp($request->urea, '') != 0){
            $laboratorioGeneral->urea = $request->urea;                        
        } else {
            $laboratorioGeneral->urea = '';                        
        }

        if($request->creatinina != null && strcmp($request->creatinina, '') != 0){
            $laboratorioGeneral->creatinina = $request->creatinina;                        
        } else {
            $laboratorioGeneral->creatinina = '';                        
        }
          
        if($request->tgo != null && strcmp($request->tgo, '') != 0){
            $laboratorioGeneral->tgo = $request->tgo;                        
        } else {
            $laboratorioGeneral->tgo = '';                        
        }

        if($request->tgp != null && strcmp($request->tgp, '') != 0){
            $laboratorioGeneral->tgp = $request->tgp;                        
        } else {
            $laboratorioGeneral->tgp = '';                        
        }

        if($request->fal != null && strcmp($request->fal, '') != 0){
            $laboratorioGeneral->fal = $request->fal;                        
        } else {
            $laboratorioGeneral->fal = '';                        
        }

        if($request->bb != null && strcmp($request->bb, '') != 0){
            $laboratorioGeneral->bb_total = $request->bb;                        
        } else {
            $laboratorioGeneral->bb_total = '';                        
        }

        if($request->ferremia != null && strcmp($request->ferremia, '') != 0){
            $laboratorioGeneral->ferremia = $request->ferremia;                        
        } else {
            $laboratorioGeneral->ferremia = '';                        
        }
           
        if($request->transferrina != null && strcmp($request->transferrina, '') != 0){
            $laboratorioGeneral->transferrina = $request->transferrina;                        
        } else {
            $laboratorioGeneral->transferrina = '';                        
        }

        if($request->sat_transferrina != null && strcmp($request->sat_transferrina, '') != 0){
            $laboratorioGeneral->sat_transferrina = $request->sat_transferrina;                        
        } else {
            $laboratorioGeneral->sat_transferrina = '';                        
        }

        if($request->tibc != null && strcmp($request->tibc, '') != 0){
            $laboratorioGeneral->tibc = $request->tibc;                        
        } else {
            $laboratorioGeneral->tibc = '';                        
        }

        if($request->ferritina != null && strcmp($request->ferritina, '') != 0){
            $laboratorioGeneral->ferritina = $request->ferritina;                        
        } else {
            $laboratorioGeneral->ferritina = '';                        
        }

        if($request->vit_b12 != null && strcmp($request->vit_b12, '') != 0){
            $laboratorioGeneral->vit_b12 = $request->vit_b12;                        
        } else {
            $laboratorioGeneral->vit_b12 = '';                        
        }

        if($request->folato != null && strcmp($request->folato, '') != 0){
            $laboratorioGeneral->folato = $request->folato;                        
        } else {
            $laboratorioGeneral->folato = '';                        
        }

        if($request->prot_totales != null && strcmp($request->prot_totales, '') != 0){
            $laboratorioGeneral->prot_totales = $request->prot_totales;                        
        } else {
            $laboratorioGeneral->prot_totales = '';                        
        }

        if($request->albumina != null && strcmp($request->albumina, '') != 0){
            $laboratorioGeneral->albumina = $request->albumina;                        
        } else {
            $laboratorioGeneral->albumina = '';                        
        }

        if($request->alfa != null && strcmp($request->alfa, '') != 0){
            $laboratorioGeneral->alfa = $request->alfa;                        
        } else {
            $laboratorioGeneral->alfa = '';                        
        }

        if($request->beta != null && strcmp($request->beta, '') != 0){
            $laboratorioGeneral->beta = $request->beta;                        
        } else {
            $laboratorioGeneral->beta = '';                        
        }

        if($request->gamma != null && strcmp($request->gamma, '') != 0){
            $laboratorioGeneral->gamma = $request->gamma;                        
        } else {
            $laboratorioGeneral->gamma = '';                        
        }

        if($request->interpretacion != null && strcmp($request->interpretacion, '') != 0){
            $laboratorioGeneral->interpretacion = $request->interpretacion;                        
        } else {
            $laboratorioGeneral->interpretacion = '';                        
        }

        if($request->inmufijacion != null && strcmp($request->inmufijacion, '') != 0){
            $laboratorioGeneral->inmunofijacion = $request->inmufijacion;                        
        } else {
            $laboratorioGeneral->inmunofijacion = '';                        
        }

        if($request->cll != null && strcmp($request->cll, '') != 0){
            $laboratorioGeneral->cll = $request->cll;                        
        } else {
            $laboratorioGeneral->cll = '';                        
        }

        if($request->kappa != null && strcmp($request->kappa, '') != 0){
            $laboratorioGeneral->kappa = $request->kappa;                        
        } else {
            $laboratorioGeneral->kappa = '';                        
        }

        if($request->lambda != null && strcmp($request->lambda, '') != 0){
            $laboratorioGeneral->lambda = $request->lambda;                        
        } else {
            $laboratorioGeneral->lambda = '';                        
        }

        if($request->calcio != null && strcmp($request->calcio, '') != 0){
            $laboratorioGeneral->calcio = $request->calcio;                        
        } else {
            $laboratorioGeneral->calcio = '';                        
        }

        if($request->fosforo != null && strcmp($request->fosforo, '') != 0){
            $laboratorioGeneral->fosforo = $request->fosforo;                        
        } else {
            $laboratorioGeneral->fosforo = '';                        
        }

        if($request->proteinuria != null && strcmp($request->proteinuria, '') != 0){
            $laboratorioGeneral->proteinuria = $request->proteinuria;                        
        } else {
            $laboratorioGeneral->proteinuria = '';                        
        }

        if($request->tp_seg != null && strcmp($request->tp_seg, '') != 0){
            $laboratorioGeneral->tp = $request->tp_seg;                        
        } else {
            $laboratorioGeneral->tp = '';                        
        }

        if($request->rin != null && strcmp($request->rin, '') != 0){
            $laboratorioGeneral->rin = $request->rin;                        
        } else {
            $laboratorioGeneral->rin = '';                        
        }

        if($request->aptt != null && strcmp($request->aptt, '') != 0){
            $laboratorioGeneral->aptt = $request->aptt;                        
        } else {
            $laboratorioGeneral->aptt = '';                        
        }

        if($request->glucemia != null && strcmp($request->glucemia, '') != 0){
            $laboratorioGeneral->glucemia = $request->glucemia;                        
        } else {
            $laboratorioGeneral->glucemia = '';                        
        }

        if($request->pico_monotonas != null && strcmp($request->pico_monotonas, '') != 0){
            $laboratorioGeneral->pico_monotomas = $request->pico_monotonas;                        
        } else {
            $laboratorioGeneral->pico_monotomas = '';                        
        }

        if($request->lg_g != null && strcmp($request->lg_g, '') != 0){
            $laboratorioGeneral->lg_g = $request->lg_g;                        
        } else {
            $laboratorioGeneral->lg_g = '';                        
        }        

        if($request->lg_a != null && strcmp($request->lg_a, '') != 0){
            $laboratorioGeneral->lg_a = $request->lg_a;                        
        } else {
            $laboratorioGeneral->lg_a = '';                        
        }        

        if($request->lg_m != null && strcmp($request->lg_m, '') != 0){
            $laboratorioGeneral->lg_m = $request->lg_m;                        
        } else {
            $laboratorioGeneral->lg_m = '';                        
        }        

        if($request->lg_e != null && strcmp($request->lg_e, '') != 0){
            $laboratorioGeneral->lg_e = $request->lg_e;                        
        } else {
            $laboratorioGeneral->lg_e = '';                        
        }        

        if($request->lg_d != null && strcmp($request->lg_d, '') != 0){
            $laboratorioGeneral->lg_d = $request->lg_d;                        
        } else {
            $laboratorioGeneral->lg_d = '';                        
        }        
              
        if($request->fecha != null && strcmp($request->fecha, '') != 0){            
            $fecha_aux = explode('/', $request->fecha);        
            $fecha = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];                          
            $laboratorioGeneral->fecha = $fecha;                        
        } else {
            $laboratorioGeneral->fecha = '2000-01-01';                        
        }

        $laboratorioGeneral->activo = 1; 
        $laboratorioGeneral->save();

        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);        
        $medicoInfo->es_nueva_consulta = 8;
        $medicoInfo->save();        

        return response()->json(array('response'=>1));
    }

    function guardarLaboratoriosActivo1($paciente_id, $consulta_id, $tabla){
        $labs = DB::table($tabla)
                    ->where($tabla.'.paciente_id', $paciente_id)
                    ->where($tabla.'.consulta_id', $consulta_id)
                    ->get();

        foreach ($labs as $lab) {
            if($lab!=null){
                $aux = null;
                if(strcmp($tabla, 'laboratorio_generals') == 0){
                    $aux = LaboratorioGeneral::find($lab->id);                
                }
                if(strcmp($tabla, 'trombofilias') == 0){
                    $aux = Trombofilia::find($lab->id);                
                }
                if(strcmp($tabla, 'transtorno_hemorragiparos') == 0){
                    $aux = TranstornoHemorragiparo::find($lab->id);                
                }
                if(strcmp($tabla, 'control_anticoagulacions') == 0){
                    $aux = ControlAnticoagulacion::find($lab->id);                
                }
                if(strcmp($tabla, 'evolucions') == 0){
                    $aux = Evolucion::find($lab->id);                
                }
                if($aux != null){
                    $aux->activo = 1;
                    $aux->save();
                }
            }
        }
    }

    function guardarTrombofilia(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $trombofilia = new Trombofilia;
        $trombofilia->consulta_id = $consulta;
        $trombofilia->paciente_id = $paciente;

        if($request->tp != null && strcmp($request->tp, '') != 0){
            $trombofilia->tp = $request->tp;                        
        } else {
            $trombofilia->tp = '';                        
        }

        if($request->rin != null && strcmp($request->rin, '') != 0){
            $trombofilia->rin = $request->rin;                        
        } else {
            $trombofilia->rin = '';                        
        }

        if($request->aptt != null && strcmp($request->aptt, '') != 0){
            $trombofilia->aptt = $request->aptt;                        
        } else {
            $trombofilia->aptt = '';                        
        }

        if($request->tt != null && strcmp($request->tt, '') != 0){
            $trombofilia->tt = $request->tt;                        
        } else {
            $trombofilia->tt = '';                        
        }

        if($request->ts != null && strcmp($request->ts, '') != 0){
            $trombofilia->ts = $request->ts;                        
        } else {
            $trombofilia->ts = '';                        
        }

        if($request->f_viii != null && strcmp($request->f_viii, '') != 0){
            $trombofilia->f_viii = $request->f_viii;                        
        } else {
            $trombofilia->f_viii = '';                        
        }

        if($request->pc != null && strcmp($request->pc, '') != 0){
            $trombofilia->pc = $request->pc;                        
        } else {
            $trombofilia->pc = '';                        
        }

        if($request->ps != null && strcmp($request->ps, '') != 0){
            $trombofilia->ps = $request->ps;                        
        } else {
            $trombofilia->ps = '';                        
        }

        if($request->rpca != null && strcmp($request->rpca, '') != 0){
            $trombofilia->rpca = $request->rpca;                        
        } else {
            $trombofilia->rpca = '';                        
        }

        if($request->ac_anti_b2_gp_igg != null && strcmp($request->ac_anti_b2_gp_igg, '') != 0){
            $trombofilia->ac_anti_b2_gp_igg = $request->ac_anti_b2_gp_igg;                        
        } else {
            $trombofilia->ac_anti_b2_gp_igg = '';                        
        }

        if($request->ac_anti_b2_gp_igm != null && strcmp($request->ac_anti_b2_gp_igm, '') != 0){
            $trombofilia->ac_anti_b2_gp_igm = $request->ac_anti_b2_gp_igm;                        
        } else {
            $trombofilia->ac_anti_b2_gp_igm = '';                        
        }

        if($request->ac_anti_cardiolipina_igg != null && strcmp($request->ac_anti_cardiolipina_igg, '') != 0){
            $trombofilia->ac_anti_cardiolipina_igg = $request->ac_anti_cardiolipina_igg;                        
        } else {
            $trombofilia->ac_anti_cardiolipina_igg = '';                        
        }

        if($request->ac_anti_cardiolipina_igm != null && strcmp($request->ac_anti_cardiolipina_igm, '') != 0){
            $trombofilia->ac_anti_cardiolipina_igm = $request->ac_anti_cardiolipina_igm;                        
        } else {
            $trombofilia->ac_anti_cardiolipina_igm = '';                        
        }

        if($request->anticoagulante_lupico != null && strcmp($request->anticoagulante_lupico, '') != 0){
            $trombofilia->anticoagulante_lupico = $request->anticoagulante_lupico;                        
        } else {
            $trombofilia->anticoagulante_lupico = '';                        
        }

        if($request->mutacion_fv_leiden != null && strcmp($request->mutacion_fv_leiden, '') != 0){
            $trombofilia->mutacion_fv_leiden = $request->mutacion_fv_leiden;                        
        } else {
            $trombofilia->mutacion_fv_leiden = '';                        
        }

        if($request->mutacion_pt_20210 != null && strcmp($request->mutacion_pt_20210, '') != 0){
            $trombofilia->mutacion_pt_20210 = $request->mutacion_pt_20210;                        
        } else {
            $trombofilia->mutacion_pt_20210 = '';                        
        }

        if($request->homocisteinemia != null && strcmp($request->homocisteinemia, '') != 0){
            $trombofilia->homocisteinemia = $request->homocisteinemia;                        
        } else {
            $trombofilia->homocisteinemia = '';                        
        }

        if($request->antitrombina != null && strcmp($request->antitrombina, '') != 0){
            $trombofilia->antitrombina_iii = $request->antitrombina;                        
        } else {
            $trombofilia->antitrombina_iii = '';                        
        }
   
        if($request->fecha != null && strcmp($request->fecha, '') != 0){            
            $fecha_aux = explode('/', $request->fecha);        
            $fecha = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];                          
            $trombofilia->fecha = $fecha;                        
        } else {
            $trombofilia->fecha = '2000-01-01';                        
        }

        $trombofilia->activo = 1;
        $trombofilia->save();

        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);        
        $medicoInfo->es_nueva_consulta = 10;
        $medicoInfo->save();

        return response()->json(array('response'=>1));  
    }

    function guardarTrastornoHemorragiparo(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $transtornoHemorragiparo = new TranstornoHemorragiparo;
        $transtornoHemorragiparo->consulta_id = $consulta;
        $transtornoHemorragiparo->paciente_id = $paciente;

        if($request->plaquetas != null && strcmp($request->plaquetas, '') != 0){
            $transtornoHemorragiparo->plaquetas = $request->plaquetas;                        
        } else {
            $transtornoHemorragiparo->plaquetas = '';                        
        }

        if($request->tp != null && strcmp($request->tp, '') != 0){
            $transtornoHemorragiparo->tp = $request->tp;                        
        } else {
            $transtornoHemorragiparo->tp = '';                        
        }

        if($request->rin != null && strcmp($request->rin, '') != 0){
            $transtornoHemorragiparo->rin = $request->rin;                        
        } else {
            $transtornoHemorragiparo->rin = '';                        
        }

        if($request->aptt != null && strcmp($request->aptt, '') != 0){
            $transtornoHemorragiparo->aptt = $request->aptt;                        
        } else {
            $transtornoHemorragiparo->aptt = '';                        
        }

        if($request->factor_v != null && strcmp($request->factor_v, '') != 0){
            $transtornoHemorragiparo->factor_v = $request->factor_v;                        
        } else {
            $transtornoHemorragiparo->factor_v = '';                        
        }

        if($request->fibrinogeno != null && strcmp($request->fibrinogeno, '') != 0){
            $transtornoHemorragiparo->fibrinogeno = $request->fibrinogeno;                        
        } else {
            $transtornoHemorragiparo->fibrinogeno = '';                        
        }

        if($request->tt != null && strcmp($request->tt, '') != 0){
            $transtornoHemorragiparo->tt = $request->tt;                        
        } else {
            $transtornoHemorragiparo->tt = '';                        
        }

        if($request->ts != null && strcmp($request->ts, '') != 0){
            $transtornoHemorragiparo->ts = $request->ts;                        
        } else {
            $transtornoHemorragiparo->ts = '';                        
        }

        if($request->retraccion_del_coagulo != null && strcmp($request->retraccion_del_coagulo, '') != 0){
            $transtornoHemorragiparo->retraccion_del_coagulo = $request->retraccion_del_coagulo;                        
        } else {
            $transtornoHemorragiparo->retraccion_del_coagulo = '';                        
        }

        if($request->factor_vw != null && strcmp($request->factor_vw, '') != 0){
            $transtornoHemorragiparo->factor_de_vw = $request->factor_vw;                        
        } else {
            $transtornoHemorragiparo->factor_de_vw = '';                        
        } 
        
        if($request->coafactor != null && strcmp($request->coafactor, '') != 0){
            $transtornoHemorragiparo->cofactor_de_ristocetina = $request->coafactor;                        
        } else {
            $transtornoHemorragiparo->cofactor_de_ristocetina = '';                        
        }

        if($request->tp_correccion != null && strcmp($request->tp_correccion, '') != 0){
            $transtornoHemorragiparo->tp_correccion = $request->tp_correccion;                        
        } else {
            $transtornoHemorragiparo->tp_correccion = '';                        
        }

        if($request->aptt_correccion != null && strcmp($request->aptt_correccion, '') != 0){
            $transtornoHemorragiparo->aptt_correccion = $request->aptt_correccion;                        
        } else {
            $transtornoHemorragiparo->aptt_correccion = '';                        
        }

        if($request->factor_ii != null && strcmp($request->factor_ii, '') != 0){
            $transtornoHemorragiparo->factor_ii = $request->factor_ii;                        
        } else {
            $transtornoHemorragiparo->factor_ii = '';                        
        }

        if($request->factor_vii != null && strcmp($request->factor_vii, '') != 0){
            $transtornoHemorragiparo->factor_vii = $request->factor_vii;                        
        } else {
            $transtornoHemorragiparo->factor_vii = '';                        
        }

        if($request->factor_viii != null && strcmp($request->factor_viii, '') != 0){
            $transtornoHemorragiparo->factor_viii = $request->factor_viii;                        
        } else {
            $transtornoHemorragiparo->factor_viii = '';                        
        }

        if($request->factor_ix != null && strcmp($request->factor_ix, '') != 0){
            $transtornoHemorragiparo->factor_ix = $request->factor_ix;                        
        } else {
            $transtornoHemorragiparo->factor_ix = '';                        
        }

        if($request->factor_x != null && strcmp($request->factor_x, '') != 0){
            $transtornoHemorragiparo->factor_x = $request->factor_x;                        
        } else {
            $transtornoHemorragiparo->factor_x = '';                        
        }

        if($request->inh_viii != null && strcmp($request->inh_viii, '') != 0){
            $transtornoHemorragiparo->inh_viii = $request->inh_viii;                        
        } else {
            $transtornoHemorragiparo->inh_viii = '';                        
        }

        if($request->inh_ix != null && strcmp($request->inh_ix, '') != 0){
            $transtornoHemorragiparo->inh_ix = $request->inh_ix;                        
        } else {
            $transtornoHemorragiparo->inh_ix = '';                        
        }
                
        if($request->fecha != null && strcmp($request->fecha, '') != 0){            
            $fecha_aux = explode('/', $request->fecha);        
            $fecha = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];                          
            $transtornoHemorragiparo->fecha = $fecha;                        
        } else {
            $transtornoHemorragiparo->fecha = '2000-01-01';                        
        }

        $transtornoHemorragiparo->activo = 1;
        $transtornoHemorragiparo->save();

        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);        
        $medicoInfo->es_nueva_consulta = 11;
        $medicoInfo->save();

        return response()->json(array('response'=>1)); 
    }

    function guardarResumen(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'resumens');
        if($existeConsulta != null){
            $resumen = Resumen::find($existeConsulta->id);
        } else {
            $resumen = new Resumen;
            $resumen->consulta_id = $consulta;
            $resumen->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $resumen->descripcion = $request->descripcion;                        
        } else {
            $resumen->descripcion = '';                        
        }
     
        $resumen->activo = 1;
        $resumen->save();

        return response()->json(array('response'=>1));    
    }

    function cargarResumen(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
        $parcial = $request->parcial;
                
        if($parcial == 1){
            $consulta = DB::table('resumens')
                        ->join('consultas', 'consultas.id', 'resumens.consulta_id')
                        ->join('users', 'users.id', 'consultas.medico_id')
                        ->select('resumens.*', 'users.name')
                        ->where('resumens.paciente_id', $paciente_id)                            
                        ->where('resumens.consulta_id', $consulta_id)                            
                        ->where('resumens.activo', 1)
                        ->orderby('resumens.id', 'desc')                            
                        ->get();
        } else {
            $consulta = DB::table('resumens')
                        ->join('consultas', 'consultas.id', 'resumens.consulta_id')
                        ->join('users', 'users.id', 'consultas.medico_id')
                        ->select('resumens.*', 'users.name')
                        ->where('resumens.paciente_id', $paciente_id)              
                        ->where('resumens.activo', 1)
                        ->orderby('resumens.id', 'desc')                            
                        ->get();
        }

        $response = 0;
        if($consulta->count() > 0)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));
    }

    function guardarExamenFisicoTexto(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'examen_fisico_textos');
        if($existeConsulta != null){
            $examenFisicoTexto = ExamenFisicoTexto::find($existeConsulta->id);
        } else {
            $examenFisicoTexto = new ExamenFisicoTexto;
            $examenFisicoTexto->consulta_id = $consulta;
            $examenFisicoTexto->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $examenFisicoTexto->descripcion = $request->descripcion;                        
        } else {
            $examenFisicoTexto->descripcion = '';                        
        }
     
        $examenFisicoTexto->activo = 1;
        $examenFisicoTexto->save();

        return response()->json(array('response'=>1));
    }

    function cargarExamenFisicoTexto(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;       
        $parcial = $request->parcial; 
        
        if($parcial == 1){
            $consulta = DB::table('examen_fisico_textos')
                        ->join('consultas', 'consultas.id', 'examen_fisico_textos.consulta_id')
                        ->join('users', 'users.id', 'consultas.medico_id')
                        ->select('examen_fisico_textos.*', 'users.name')
                        ->where('examen_fisico_textos.paciente_id', $paciente_id)                            
                        ->where('examen_fisico_textos.consulta_id', $consulta_id)                            
                        ->where('examen_fisico_textos.activo', 1)
                        ->orderby('examen_fisico_textos.id', 'desc')                            
                        ->get();
        } else {
            $consulta = DB::table('examen_fisico_textos')
                        ->join('consultas', 'consultas.id', 'examen_fisico_textos.consulta_id')
                        ->join('users', 'users.id', 'consultas.medico_id')
                        ->select('examen_fisico_textos.*', 'users.name')
                        ->where('examen_fisico_textos.paciente_id', $paciente_id)                            
                        ->where('examen_fisico_textos.activo', 1)
                        ->orderby('examen_fisico_textos.id', 'desc')                            
                        ->get();
        }

        $response = 0;
        if($consulta->count() > 0)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));    
    }

    function guardarPlan(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'plans');
        if($existeConsulta != null){
            $plan = Plan::find($existeConsulta->id);
        } else {
            $plan = new Plan;
            $plan->consulta_id = $consulta;
            $plan->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $plan->descripcion = $request->descripcion;                        
        } else {
            $plan->descripcion = '';                        
        }
     
        $plan->activo = 1;
        $plan->save();

        return response()->json(array('response'=>1));
    }

    function cargarPlan(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
        $parcial = $request->parcial;
                
        if($parcial == 1){
            $consulta = DB::table('plans')
                        ->join('consultas', 'consultas.id', 'plans.consulta_id')
                        ->join('users', 'users.id', 'consultas.medico_id')
                        ->select('plans.*', 'users.name')
                        ->where('plans.paciente_id', $paciente_id)                            
                        ->where('plans.consulta_id', $consulta_id)                            
                        ->where('plans.activo', 1)
                        ->orderby('plans.id', 'desc')                            
                        ->get();
        } else {
            $consulta = DB::table('plans')
                        ->join('consultas', 'consultas.id', 'plans.consulta_id')
                        ->join('users', 'users.id', 'consultas.medico_id')
                        ->select('plans.*', 'users.name')
                        ->where('plans.paciente_id', $paciente_id)              
                        ->where('plans.activo', 1)
                        ->orderby('plans.id', 'desc')                            
                        ->get();
        }

        $response = 0;
        if($consulta->count() > 0)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));
    }

    function guardarImpresionDiagnostica(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'impresion_diagnosticas');
        if($existeConsulta != null){
            $impresionDiagnostica = ImpresionDiagnostica::find($existeConsulta->id);
        } else {
            $impresionDiagnostica = new ImpresionDiagnostica;
            $impresionDiagnostica->consulta_id = $consulta;
            $impresionDiagnostica->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $impresionDiagnostica->descripcion = $request->descripcion;                        
        } else {
            $impresionDiagnostica->descripcion = '';                        
        }
     
        $impresionDiagnostica->activo = 1;
        $impresionDiagnostica->save();

        return response()->json(array('response'=>1));
    }

    function cargarImpresionDiagnostica(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
        $parcial = $request->parcial;

        if($parcial == 1){
            $consulta = DB::table('impresion_diagnosticas')
                        ->join('consultas', 'consultas.id', 'impresion_diagnosticas.consulta_id')
                        ->join('users', 'users.id', 'consultas.medico_id')
                        ->select('impresion_diagnosticas.*', 'users.name')
                        ->where('impresion_diagnosticas.paciente_id', $paciente_id)
                        ->where('impresion_diagnosticas.consulta_id', $consulta_id)
                        ->where('impresion_diagnosticas.activo', 1)
                        ->orderby('impresion_diagnosticas.id', 'desc')                            
                        ->get();
        } else {                 
            $consulta = DB::table('impresion_diagnosticas')
                        ->join('consultas', 'consultas.id', 'impresion_diagnosticas.consulta_id')
                        ->join('users', 'users.id', 'consultas.medico_id')
                        ->select('impresion_diagnosticas.*', 'users.name')
                        ->where('impresion_diagnosticas.paciente_id', $paciente_id)                           
                        ->where('impresion_diagnosticas.activo', 1)
                        ->orderby('impresion_diagnosticas.id', 'desc')                            
                        ->get();
        }
        $response = 0;
        if($consulta->count() > 0)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));
    }

    function guardarMotivoConsulta(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'motivo_consultas');
        if($existeConsulta != null){
            $motivoConsulta = MotivoConsulta::find($existeConsulta->id);
        } else {
            $motivoConsulta = new MotivoConsulta;
            $motivoConsulta->consulta_id = $consulta;
            $motivoConsulta->paciente_id = $paciente;    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $motivoConsulta->descripcion = $request->descripcion;                        
        } else {
            $motivoConsulta->descripcion = '';                        
        }
     
        $motivoConsulta->activo = 1;
        $motivoConsulta->save();

        return response()->json(array('response'=>1));
    }   

    function cargarMotivoConsulta(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
        $parcial = $request->parcial;

        if($parcial == 1){
            $consulta = DB::table('motivo_consultas')
                            ->join('consultas', 'consultas.id', 'motivo_consultas.consulta_id')
                            ->join('users', 'users.id', 'consultas.medico_id')
                            ->select('motivo_consultas.*', 'users.name')
                            ->where('motivo_consultas.paciente_id', $paciente_id)                            
                            ->where('motivo_consultas.consulta_id', $consulta_id)                            
                            ->where('motivo_consultas.activo', 1)
                            ->orderby('motivo_consultas.id', 'desc')                            
                            ->get();
        } else {
            $consulta = DB::table('motivo_consultas')
                            ->join('consultas', 'consultas.id', 'motivo_consultas.consulta_id')
                            ->join('users', 'users.id', 'consultas.medico_id')
                            ->select('motivo_consultas.*', 'users.name')
                            ->where('motivo_consultas.paciente_id', $paciente_id)                            
                            ->where('motivo_consultas.activo', 1)
                            ->orderby('motivo_consultas.id', 'desc')                            
                            ->get();
        }
        $response = 0;
        if($consulta->count() > 0)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));
    }

    function guardarAntecedentesPersonales(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'antecedentes');
        if($existeConsulta != null){
            $antecedente = Antecedente::find($existeConsulta->id);
        } else {
            $antecedente = new Antecedente;
            $antecedente->consulta_id = $consulta;
            $antecedente->paciente_id = $paciente;    
            $antecedente->antecedentes_familiares = '';    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $antecedente->antecedentes_personales = $request->descripcion;                        
        } else {
            $antecedente->antecedentes_personales = '';                        
        }
     
        $antecedente->activo = 1;
        $antecedente->save();

        return response()->json(array('response'=>1));
    }

     function guardarAntecedentesFamiliares(Request $request){
        $paciente = $request->paciente;
        $consulta = $request->consulta;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'antecedentes');
        if($existeConsulta != null){
            $antecedente = Antecedente::find($existeConsulta->id);
        } else {
            $antecedente = new Antecedente;
            $antecedente->consulta_id = $consulta;
            $antecedente->paciente_id = $paciente;    
            $antecedente->antecedentes_personales = '';    
        }
                
        if($request->descripcion != null && strcmp($request->descripcion, '') != 0){
            $antecedente->antecedentes_familiares = $request->descripcion;                        
        } else {
            $antecedente->antecedentes_familiares = '';                        
        }
     
        $antecedente->activo = 1;
        $antecedente->save();

        return response()->json(array('response'=>1));
    }

    function cargarAntecedentes(Request $request){
        $paciente_id = $request->paciente;
        $consulta_id = $request->consulta;        
                
        $consulta = DB::table('antecedentes')
                            ->join('consultas', 'consultas.id', 'antecedentes.consulta_id')
                            ->join('users', 'users.id', 'consultas.medico_id')
                            ->select('users.name', 'antecedentes.*')
                        ->where('antecedentes.paciente_id', $paciente_id)                                                        
                            ->where('antecedentes.activo', 1)
                            ->orderby('antecedentes.created_at')
                            ->get();
        $response = 0;
        if($consulta->count() > 0)
            $response = 1;

        return response()->json(array('response'=>$response, 'response_data'=>$consulta));
    }

    // funciona perfecto, falta crear una tabla en la base de datos para guardar la direccion.
    // y desp falta poder reproducir el audio en la pagina.
    function guardarAudio(Request $request){                
        $medico_id =\Auth::user()->id;
        $usuario_actual_nombre=\Auth::user()->email;   
        $pathFolderMedico_aux = explode('@', $usuario_actual_nombre);
        $pathFolderMedico = $pathFolderMedico_aux[0];

        if (count($_FILES) <= 0 || empty($_FILES["audio"])) {
            exit("No hay archivos");
        }

        $medicoInfo = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $medico_id)
                            ->first();

        $paciente = $medicoInfo->paciente_id;
        $consulta = $medicoInfo->consulta_id;

        $existeConsulta = $this->existeConsultaPacienteTabla($consulta, $paciente, 'evolucions');
        if($existeConsulta != null){
            $evolucion = Evolucion::find($existeConsulta->id);
        } else {
            $evolucion = new Evolucion;
            $evolucion->consulta_id = $consulta;
            $evolucion->paciente_id = $paciente;    
            $evolucion->descripcion = '';            
        }

        # De dónde viene el audio y en dónde lo ponemos
        $rutaAudioSubido = $_FILES["audio"]["tmp_name"];
        $nuevoNombre = uniqid() . ".webm";
        //$path = 'img/'.$pathFolderMedico.'/consulta_foto/'.$name;
        //$rutaDeGuardado = __DIR__ . "/" . $nuevoNombre;
        $rutaDeGuardado = 'img/'.$pathFolderMedico.'/audios/'.$nuevoNombre;
        // Mover el archivo subido a la ruta de guardado
        move_uploaded_file($_FILES["audio"]["tmp_name"], $rutaDeGuardado);
        // Imprimir el nombre para que la petición lo lea
        
        $evolucion->audio = $rutaDeGuardado;    
        $evolucion->activo = 1;
        $evolucion->save();

        return $rutaDeGuardado;
    }

    function guardarEvolucionFotos(Request $request){
        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();

        $consulta_id = $medicoInfoAux->consulta_id;
        $paciente_id = $medicoInfoAux->paciente_id;
        $evolucion_id = $request->evolucion_id;     
        $es_nueva_consulta_cargar_fotos = $request->es_nueva_consulta_cargar_fotos;   

        // debo checkear que no existe una consulta, quizas exista si es que grabo audio primero.
        //if($evolucion_id == -1 || $evolucion_id == 0){
        $evolucion = Evolucion::find($evolucion_id); 
        if($evolucion == null) {
            $evolucion = new Evolucion;
            $evolucion->consulta_id = $consulta_id;
            $evolucion->paciente_id = $paciente_id;            
            $evolucion->audio = "";            

            if($request->evolucion_detalles != null)
                $evolucion->descripcion = $request->evolucion_detalles;
            else
                $evolucion->descripcion = "";    

            $evolucion->activo = 1;
            $evolucion->save();
        } 
 
        $cantidadFotos = intval($request->evolucion_cantidad_fotos);
        $usuario_actual_nombre=\Auth::user()->email;   
        $pathFolderMedico_aux = explode('@', $usuario_actual_nombre);
        $pathFolderMedico = $pathFolderMedico_aux[0];
        
        for ($i = 1; $i <= $cantidadFotos; $i++) {
            $request_foto = 'evolucion_foto_'.$i;

            if($request->$request_foto != null){
                
                if($request->hasfile($request_foto)){
                    //return $request_foto; 
                    $evolucionFotos = new EvolucionFoto;
                    $evolucionFotos->activo = 1;
                    $evolucionFotos->paciente_id = $paciente_id;
                    $evolucionFotos->consulta_id = $consulta_id;

                    if($request->foto_evolucion_id == 0)
                        $evolucionFotos->evolucion_id = $evolucion->id;
                    else
                        $evolucionFotos->evolucion_id = $request->foto_evolucion_id;

                    $pathName = $request->file($request_foto)->store('img/'.$pathFolderMedico.'/evolucion');
                    $name = collect(explode('/', $pathName))->last();
                    $image = $request->file($request_foto);
                    //$name  = $image->getClientOriginalName().time().'.'.$image->getClientOriginalExtension();
                    $path = 'img/'.$pathFolderMedico.'/evolucion/'.$name;        
                    //Image::make($image->getRealPath())->resize(1980, 1920)->save($path);  
                    Image::make($image->getRealPath())->save($path);  
                    $evolucionFotos->foto = $pathFolderMedico.'/evolucion/'.$name;
                    $evolucionFotos->save();           
                   // return 'hola foto';
                }               
            } 
        }
        
        $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
        /*if($es_nueva_consulta_cargar_fotos == null)
            $medicoInfo->es_nueva_consulta = 3;
        else
            $medicoInfo->es_nueva_consulta = 4;*/
        $medicoInfo->es_nueva_consulta = 4;
        $medicoInfo->save();        
        //return 'hola';
        return redirect()->route('navegarconsultaseleccionada');
    }

    function cargarEvolucionFoto(Request $request){
        $evolucion_id = $request->evolucion_id;
        $evolucionFotos = DB::table('evolucion_fotos')                                                                    
                                    ->where('evolucion_fotos.evolucion_id', $evolucion_id)
                                    ->where('evolucion_fotos.activo', 1)                                    
                                    ->orderBy('id','desc')
                                    ->get();  
        $response = 0;
        if($evolucionFotos->count()>0)
            $response = 1;     
        return response()->json(array('response_data'=>$evolucionFotos, 'response'=>$response));               
    }

    function cargarEvolucionFotos(Request $request){
        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();      
        $paciente_id = $medicoInfoAux->paciente_id;
        $consulta_id = $medicoInfoAux->consulta_id;
        $evolucion = DB::table('evolucions')
                            ->where('evolucions.consulta_id', $consulta_id)                            
                            ->first();      

        if($evolucion != null){
            $fotosEvolucion = DB::table('evolucion_fotos')                                
                                    ->where('evolucion_fotos.paciente_id', $paciente_id)
                                    ->where('evolucion_fotos.evolucion_id', $evolucion->id)
                                    ->where(function ($query) {
                                         $query->where('evolucion_fotos.activo', 1)
                                               ->orWhere('evolucion_fotos.activo', 2);
                                    })                                
                                    ->orderBy('id','desc')
                                    ->get();        
            $response = 0;
            $cantidad = $fotosEvolucion->count();
            $ultimaFotoEvolucion = null;
            if($cantidad > 0){
                $response = 1;
                $ultimaFotoEvolucion = $fotosEvolucion[0];            
            }
        } else {
            $response = 0;
            $ultimaFotoEvolucion = null;
            $cantidad = 0;
        }
        return response()->json(array('response'=>$response, 'ultimaFotoEvolucion'=>$ultimaFotoEvolucion, 'cantidadFotos'=>$cantidad));
    }

    function cargarEvolucionAntSigFoto(Request $request){
        $evolucion_id = $request->evolucion_id;        
        $numero = $request->numero;        
    
        $evolucions = DB::table('evolucion_fotos')
                        ->where('evolucion_fotos.evolucion_id', $evolucion_id)
                        ->orderby('evolucion_fotos.id')
                        ->get();                    
        
        $evolucion = null;
        $response = 0;
        if($evolucions[$numero - 1] != null){
            $evolucion = $evolucions[$numero - 1];
            $response = 1;        
        }
        
        return response()->json(array('response'=>$response, 'evolucion'=>$evolucion, 'evolucion_cantidad'=>$evolucions->count(), 'numero'=>$numero)); 
    }

    function cargarEvolucionAntSig(Request $request){
        $paciente_id = $request->paciente_id;        
        $numero = $request->numero;        
    
        $evolucions = DB::table('evolucions')
                        ->where('evolucions.paciente_id', $paciente_id)
                        ->where('evolucions.activo', 1)
                        ->orderby('evolucions.id')
                        ->get();                    
        
        $evolucion = null;
        $response = 0;
        if($evolucions[$numero - 1] != null){
            $evolucion = $evolucions[$numero - 1];
            $response = 1;        
        }
        
        return response()->json(array('response'=>$response, 'evolucion'=>$evolucion, 'evolucion_cantidad'=>$evolucions->count(), 'numero'=>$numero)); 
    }

    function seleccionarConsultaImprimir() {        
        $user=\Auth::user();                
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();         
        $paciente = Paciente::find($medicoInfoAux->paciente_id);                      
        
        
        $consultas = DB::table('consultas')
                            ->where('consultas.paciente_id', $paciente->id)
                            //->where('consultas.activo', 1)
                            ->orderby('consultas.id')
                            ->get(); 
        
        if($consultas->count() > 0){
            $consulta = Consulta::find($consultas[0]->id); 
            $tipo_consult = $consulta->tipo_consulta;     
        } else {
            $consulta = null;
            $tipo_consult = null;
        }
        
        $nueva_consulta = $medicoInfoAux->es_nueva_consulta;

        $listadoResumenes = DB::table('resumens')
                            ->join('consultas', 'consultas.id', 'resumens.consulta_id')
                            ->select('consultas.id as consulta_id', 'resumens.*')
                            ->where('resumens.paciente_id', $paciente->id)
                            ->where('resumens.activo', 1)
                            ->where('consultas.activo', 1)
                            ->orderby('consultas.created_at', 'desc')
                            ->get(); 

        return view('medico.imprimir.seleccionar_consulta_imprimir')
                        ->with('nueva_consulta', $nueva_consulta)
                        ->with('tipo_consulta', $tipo_consult)
                        ->with('paciente', $paciente) 
                        ->with('listadoResumenes', $listadoResumenes)
                        ->with('consulta', $consulta);                
    }

    function getInformacionImprimir(Request $request){
        $paciente_id = $request->paciente_id;
        $consulta_id = $request->consulta_id;

        $paciente = Paciente::find($paciente_id);

        $antecedentes = DB::table('antecedentes')                                                        
                            ->where('antecedentes.paciente_id', $paciente_id)                            
                            ->where('antecedentes.activo', 1) 
                            ->orderby('antecedentes.created_at')    
                            ->get();

        $resumen = DB::table('resumens')                                                        
                            ->where('resumens.paciente_id', $paciente_id)
                            ->where('resumens.consulta_id', $consulta_id)
                            ->where('resumens.activo', 1)                                                        
                            ->first();

        $evoluciones = DB::table('evolucions')                                                        
                            ->where('evolucions.paciente_id', $paciente_id)
                            //->where('evolucions.consulta_id', $consulta_id)
                            ->where('evolucions.activo', 1)                                                        
                            // ->take(5)
                            ->get();

        $laboratorioGeneralCantidadConsultas = DB::table('laboratorio_generals')
                            ->where('laboratorio_generals.paciente_id', $paciente_id)                            
                            ->where('laboratorio_generals.activo', 1)                                                        
                            ->take(5)
                            ->orderby('fecha', 'desc')
                            ->get();  
        $laboratorioGeneralArray = $this->getLaboratorioLGTablaImprimir($paciente_id, "laboratorio_generals", $consulta_id); 
        $laboratorioGeneralArraySize = sizeof($laboratorioGeneralArray);


        $controlAnticoagulacionCantidadConsultas = DB::table('control_anticoagulacions')
                            ->where('control_anticoagulacions.paciente_id', $paciente_id)
                            // ->where('control_anticoagulacions.consulta_id', $consulta_id)
                            ->where('control_anticoagulacions.activo', 1) 
                            ->take(5)
                            ->orderby('fecha', 'desc')
                            ->get();  
        $controlAnticoagulacionArray = $this->getControlAnticoagulacionTablaImprimir($paciente_id, "control_anticoagulacions", $consulta_id); 
        $controlAnticoagulacionArraySize = sizeof($controlAnticoagulacionArray);

        $trombofiliaCantidadConsultas = DB::table('trombofilias')
                            ->where('trombofilias.paciente_id', $paciente_id)
                            // ->where('trombofilias.consulta_id', $consulta_id)
                            ->where('trombofilias.activo', 1) 
                            ->take(5)
                            ->orderby('fecha', 'desc')
                            ->get();  
        $trombofiliaArray = $this->getTrombofiliaTablaImprimir($paciente_id, "trombofilias", $consulta_id); 
        $trombofiliaArraySize = sizeof($trombofiliaArray);

        $transtornoHemorragiparoCantidadConsultas = DB::table('transtorno_hemorragiparos')
                            ->where('transtorno_hemorragiparos.paciente_id', $paciente_id)
                            //->where('transtorno_hemorragiparos.consulta_id', $consulta_id)
                            ->where('transtorno_hemorragiparos.activo', 1) 
                            ->take(5)
                            ->orderby('fecha', 'desc')
                            ->get();  
        $transtornoHemorragiparoArray = $this->getControlTranstornoHemorragiparoTablaImprimir($paciente_id, "transtorno_hemorragiparos", $consulta_id); 
        $transtornoHemorragiparoArraySize = sizeof($transtornoHemorragiparoArray);

        $user = \Auth::user();
        $firmaMedico = DB::table('medico_firmas')
                            ->where('medico_firmas.medico_user_id', $user->id)
                            ->where('medico_firmas.activo', 1)
                            ->first();

        return response()->json(array('response'=>1, 'resumen'=>$resumen, 'antecedentes'=>$antecedentes,'evoluciones'=>$evoluciones, 'paciente'=>$paciente,'laboratorioGeneralArray'=>$laboratorioGeneralArray, 'laboratorioGeneralCantidadConsultas'=>$laboratorioGeneralCantidadConsultas, 'laboratorioGeneralArraySize'=>$laboratorioGeneralArraySize, 'controlAnticoagulacionCantidadConsultas'=>$controlAnticoagulacionCantidadConsultas, 'controlAnticoagulacionArray'=>$controlAnticoagulacionArray, 'controlAnticoagulacionArraySize'=>$controlAnticoagulacionArraySize, 'trombofiliaCantidadConsultas'=>$trombofiliaCantidadConsultas, 'trombofiliaArray'=>$trombofiliaArray, 'trombofiliaArraySize'=>$trombofiliaArraySize, 'transtornoHemorragiparoCantidadConsultas'=>$transtornoHemorragiparoCantidadConsultas, 'transtornoHemorragiparoArray'=>$transtornoHemorragiparoArray, 'transtornoHemorragiparoArraySize'=>$transtornoHemorragiparoArraySize, 'firmaMedico'=>$firmaMedico));
    }

    function configFirma() {
        $user = \Auth::user();
        $firmaActual = DB::table('medico_firmas')
                            ->where('medico_firmas.medico_user_id', $user->id)
                            ->where('medico_firmas.activo', 1)
                            ->first();

        return view('medico.config.config_firma')
                        ->with('firmaActual', $firmaActual);
    }

    function guardarFirma(Request $request){
        // Los PDF se convierten a PNG en el navegador y se guardan por guardarFirmaDibujada
        $request->validate([
            'firma_imagen' => 'required|file|mimes:png,jpg,jpeg|max:5120',
        ]);

        $user = \Auth::user();
        $usuario_actual_nombre = $user->email;
        $pathFolderMedico_aux = explode('@', $usuario_actual_nombre);
        $pathFolderMedico = $pathFolderMedico_aux[0];

        if($request->hasfile('firma_imagen')){
            $image = $request->file('firma_imagen');
            $dir = 'img/'.$pathFolderMedico.'/firma';
            if(!file_exists($dir)){
                mkdir($dir, 0775, true);
            }

            $pathName = $image->store('img/'.$pathFolderMedico.'/firma');
            $name = collect(explode('/', $pathName))->last();
            $path = $dir.'/'.$name;
            Image::make($image->getRealPath())->save($path);

            DB::table('medico_firmas')
                    ->where('medico_user_id', $user->id)
                    ->update(['activo' => 0]);

            $medicoFirma = new MedicoFirma;
            $medicoFirma->medico_user_id = $user->id;
            $medicoFirma->firma = $pathFolderMedico.'/firma/'.$name;
            $medicoFirma->activo = 1;
            $medicoFirma->save();
        }

        return redirect()->route('configfirma');
    }

    function guardarFirmaDibujada(Request $request){
        $user = \Auth::user();
        $usuario_actual_nombre = $user->email;
        $pathFolderMedico_aux = explode('@', $usuario_actual_nombre);
        $pathFolderMedico = $pathFolderMedico_aux[0];

        $baseFromJavascript = $request->base64;

        if($baseFromJavascript != null){
            $img_extension = $this->getB64Extension($baseFromJavascript);
            $img_name = 'firma_'.time().'.'.$img_extension;
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));

            $dir = 'img/'.$pathFolderMedico.'/firma';
            if(!file_exists($dir)){
                mkdir($dir, 0775, true);
            }

            $filepath = $dir.'/'.$img_name;
            file_put_contents($filepath, $data);

            DB::table('medico_firmas')
                    ->where('medico_user_id', $user->id)
                    ->update(['activo' => 0]);

            $medicoFirma = new MedicoFirma;
            $medicoFirma->medico_user_id = $user->id;
            $medicoFirma->firma = $pathFolderMedico.'/firma/'.$img_name;
            $medicoFirma->activo = 1;
            $medicoFirma->save();

            return response()->json(array('response'=>1, 'firma'=>$pathFolderMedico.'/firma/'.$img_name));
        }

        return response()->json(array('response'=>0));
    }

    //$json = $this->getLaboratorioTablaAuxImprimir($json, 'plaquetas', 'Plaquetas (/mm3)', $paciente_id, $tabla, $consulta_id);
    function getLaboratorioTablaAuxImprimir2($json, $nombreColumna, $nombreColumnaMostrar, $paciente_id, $tabla, $consulta_id){

        $tablaAux = DB::table($tabla)
                            ->select($tabla.'.'.$nombreColumna)
                            ->where($tabla.'.paciente_id', $paciente_id)
                            // ->where($tabla.'.consulta_id', $consulta_id)
                            ->orderby($tabla.'.fecha', 'desc')
                            ->take(5)
                            ->get();

        
        $existeValor = false;
        foreach ($tablaAux as $val) {
            if(strcmp($val->$nombreColumna, '') != 0)
                $existeValor = true;   
        }  
        if($existeValor){   
            $json[] = $nombreColumnaMostrar;
            foreach ($tablaAux as $val) {
                $json[] = $val->$nombreColumna;   
            }                
        }       
            
        return $json;        
    }

    function getLaboratorioTablaAuxImprimir($json, $nombreColumna, $nombreColumnaMostrar, $paciente_id, $tabla, $consulta_id){
        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        
        $tablaAux = DB::table($tabla)
                            ->select($tabla.'.'.$nombreColumna)
                            ->where($tabla.'.paciente_id', $paciente_id)
                            ->where($tabla.'.consulta_id', $consulta_id)
                            ->orderby($tabla.'.fecha', 'desc')
                            ->get();

        
        $existeValor = false;
        foreach ($tablaAux as $val) {
            if(strcmp($val->$nombreColumna, '') != 0)
                $existeValor = true;   
        }  
        if($existeValor){
            $json[] = $nombreColumnaMostrar;
            foreach ($tablaAux as $val) {
                $json[] = $val->$nombreColumna;   
            }                
        }       
            
        return $json;        
    }

    function getControlTranstornoHemorragiparoTablaImprimir($paciente_id, $tabla, $consulta_id){
        $json = array();
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'plaquetas', 'Plaquetas (/mm3)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'tp', 'TP (seg/%)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'rin', 'RIN', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'aptt', 'APTT (seg)', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'factor_v', 'Factor V', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'fibrinogeno', 'Fibrinogeno', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'tt', 'TT (seg)', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ts', 'TS (min)', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'retraccion_del_coagulo', 'Retracción del coagulo', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'factor_de_vw', 'Factor de VW (Ag)', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'cofactor_de_ristocetina', 'Cofactor de Ristocetina', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'tp_correccion', 'TP Correccion', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'aptt_correccion', 'APTT Correccion', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'factor_ii', 'Factor II', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'factor_vii', 'Factor VII', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'factor_viii', 'Factor VIII', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'factor_ix', 'Factor IX', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'factor_x', 'Factor X', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'inh_viii', 'Inh. VIII', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'inh_ix', 'Inh. IX', $paciente_id, $tabla, $consulta_id);        
                
        return $json;
    }

    function getTrombofiliaTablaImprimir($paciente_id, $tabla, $consulta_id){
        $json = array();
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'tp', 'TP (seg/%)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'rin', 'RIN', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'aptt', 'APTT (seg)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'tt', 'TT (seg)', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ts', 'TS (min)', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'f_viii', 'F VIII', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'pc', 'PC', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ps', 'PS', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'rpca', 'RPCA', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ac_anti_b2_gp_igg', 'Ac Anti B2 GP IgG', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ac_anti_b2_gp_igm', 'Ac Anti B2 GP IgM', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ac_anti_cardiolipina_igg', 'Ac Anti Cardiolipina IgG', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ac_anti_cardiolipina_igm', 'Ac Anti Cardiolipina IgM', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'anticoagulante_lupico', 'Anticoagulante Lupico', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'mutacion_fv_leiden', 'Mutacion FV Leiden', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'mutacion_pt_20210', 'Mutacion PT 20210', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'homocisteinemia', 'Homocisteinemia', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'antitrombina_iii', 'Antitrombina III', $paciente_id, $tabla, $consulta_id);        

        return $json;
    }

    function getControlAnticoagulacionTablaImprimir($paciente_id, $tabla, $consulta_id){
        $json = array();                
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'tp', 'TP(seg%)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'rin', 'RIN', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'aptt', 'APTT (seg)', $paciente_id, $tabla, $consulta_id);        
        return $json;
    }

    function getLaboratorioLGTablaImprimir($paciente_id, $tabla, $consulta_id){
        $json = array();        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'rto_gr', 'Rto GR (/mm3)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'hto', 'Hto (%)', $paciente_id, $tabla, $consulta_id) ;
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'hb_g_dl', 'Hb (g/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'vcm_fl', 'VCM (fl)', $paciente_id, $tabla, $consulta_id);        
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'hcm', 'HCM (pg)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'chcm', 'CHCM (g/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'gb', 'GB (/mm3)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'pqt', 'Pqt (/mm3)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'fsp', 'FSP', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ldh', 'LDH (U/L)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ers', 'ERS (mmh)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'b2_microglob', 'B2 microglob', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'urea', 'Urea (mg/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'creatinina', 'Creatinina (mg/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'glucemia', 'Glucemia', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'tgo', 'TGO (U/L)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'tgp', 'TGP (U/L)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'fal', 'FAL (U/L)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'bb_total', 'Bb total (mg/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ferremia', 'Ferremia (mcg/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'transferrina', 'Transferrina (mg/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'sat_transferrina', 'Sat Transferrina (%)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'tibc', 'TIBC (mcg/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'ferritina', 'Ferritina (ng/mL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'vit_b12', 'Vit B12 (pg/mL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'folato', 'Folato (ng/mL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'prot_totales', 'Prot Totales (g/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'albumina', 'Albumina (g/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'alfa', 'Alfa (g/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'beta', 'Beta (g/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'gamma', 'Gamma (g/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'pico_monotomas', 'Pico Monoclonal (g/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'lg_g', 'Ig G', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'lg_a', 'Ig A', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'lg_m', 'Ig M', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'lg_e', 'Ig E', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'lg_d', 'Ig D', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'interpretacion', 'Interpretacion', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'inmunofijacion', 'Inmunofijacion', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'cll', 'CLL', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'kappa', 'Kappa', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'lambda', 'Lambda', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'calcio', 'Calcio (mg/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'fosforo', 'Fosforo (mg/dL)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'proteinuria', 'Proteinuria (gr/24hs)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'tp', 'TP (seg/%)', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'rin', 'RIN', $paciente_id, $tabla, $consulta_id);
        $json = $this->getLaboratorioTablaAuxImprimir2($json, 'aptt', 'APTT (seg)', $paciente_id, $tabla, $consulta_id);
                       
        return $json;
    }

    function altaDiagnostico() {
        $diagnosticos = Diagnostico::all();
        return view('medico.base_datos.alta_diagnostico')
                        ->with('diagnosticos', $diagnosticos);             
    }

    function guardarNuevoDiagnostico(Request $request) {
        $nuevo = $request->diagnostico;
        $d = new Diagnostico;
        $d->nombre = $nuevo;
        $d->activo = 1;
        $d->save();

        $diagnosticos = Diagnostico::all();

        return response()->json(array('diagnosticos'=>$diagnosticos, 'd'=>$d)); 
    }

    function cargarListadoDiagnostico(Request $request) {
        $diagnosticos = Diagnostico::all();

        return response()->json(array('diagnosticos'=>$diagnosticos)); 
    }

    function guardarDiagnosticos(Request $request) {
        $consultaId = $request->consulta;
        $diagnosticosSeleccionados = $request->diagnosticos;

        $consulta = Consulta::find($consultaId);
        $consulta->diagnosticos()->sync($diagnosticosSeleccionados); // asigna diagnósticos con id 1 y 3

        return response()->json(array('response'=>1)); 
    }

    function cargarDiagnosticos(Request $request) {
        $consulta_id = $request->consulta;
        $paciente = $request->paciente;

        $consulta = Consulta::find($consulta_id);

        $diagnosticos = $consulta ? $consulta->diagnosticos()->get() : collect();

        $diagnosticosListado = Diagnostico::all();


        return response()->json(array('diagnosticos'=>$diagnosticos, 'diagnosticosListado'=>$diagnosticosListado)); 
    }

    function pacientesListadoBuscarBd() {
        $pacientesConDiagnosticos = DB::table('pacientes')
            ->join('consultas', 'consultas.paciente_id', '=', 'pacientes.id')
            ->join('consulta_diagnostico', 'consultas.id', '=', 'consulta_diagnostico.consulta_id')
            ->join('diagnosticos', 'consulta_diagnostico.diagnostico_id', '=', 'diagnosticos.id')
            ->select(
                'pacientes.id as paciente_id',
                'pacientes.nombre',
                'pacientes.apellido',
                'pacientes.dni',
                'pacientes.localidad',
                'pacientes.obra_social',
                'diagnosticos.nombre as diagnostico'
            )
            ->where('pacientes.activo', 1)
            ->where('consultas.activo', 1)
            ->where('diagnosticos.activo', 1)
            ->distinct()
            ->orderBy('pacientes.apellido')
            ->get();

        $agrupado = [];

        foreach ($pacientesConDiagnosticos as $row) {
            $id = $row->paciente_id;
            if (!isset($agrupado[$id])) {
                $agrupado[$id] = [
                    'id' => $id,
                    'nombre' => $row->nombre,
                    'apellido' => $row->apellido,
                    'dni' => $row->dni,
                    'localidad' => $row->localidad,
                    'obra_social' => $row->obra_social,
                    'diagnosticos' => [],
                ];
            }

            $agrupado[$id]['diagnosticos'][] = $row->diagnostico;
        }

        $listaFinal = collect($agrupado)->map(function ($p) {
            return [
                'id' => $p['id'],
                'nombre' => $p['nombre'],
                'apellido' => $p['apellido'],
                'dni' => $p['dni'],
                'localidad' => $p['localidad'],
                'obra_social' => $p['obra_social'],
                'diagnostico' => implode(', ', array_unique($p['diagnosticos'])),
            ];
        })->values();


        //return view('tu.vista', ['datos' => $listaFinal]);

        
        return datatables()->of($listaFinal)
                           ->addIndexColumn()
                           ->addColumn('seleccionar', function($row){                                   
                                    $val = $row['id'];                                                                                                                            
                                $btn = "<button onclick='seleccionarPaciente($val)' class='rodri_button_aceptar'>></button>";
                                return $btn;
                            })
                            ->rawColumns(['seleccionar'])
                            ->make(true);
    }

}