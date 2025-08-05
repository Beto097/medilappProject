<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\examen;
use App\Models\tipo_examen;
use App\Models\paciente;
use App\Models\resultado;
use App\Models\rol;
use App\Models\usuario;
use App\Models\orden_laboratorio;
use App\Models\caracteristica_examen;
use App\Models\examen_orden_laboratorio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResultadoLaboratorio;
use Session;

class pdfController extends Controller
{
    public function pdfResultado($id){
        
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/ordenesLaboratorio',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                
                                   
                $examen_orden = examen_orden_laboratorio::find($id);
                $examen = examen::find($examen_orden->examen->id);
                $rol = rol::where('nombre_rol','Paciente')->first();
                    
                if ($rol->id == Session::get('usuario_rol_id')) {
                    $usuario = usuario::find(Session::get('usuario_log_id'));                        
                    $paciente = paciente::where('identificacion_paciente',$usuario->nombre_usuario)->first();
                    $paciente_id = $examen_orden->orden_laboratorio->paciente_id;
                    if ($paciente->id != $paciente_id) {
                        return redirect(route('resultado.ver'));
                    }
                    
                }
                if($examen->tiene_referencia == '0'){
                    $conteo = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->get()->count();
                    
                    if ($conteo > '10') {
                        $max = round($conteo/2);
                        $min = round($conteo/2 , 0, PHP_ROUND_HALF_DOWN);
                        $resultados1 = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->take($max)->get();
                        $resultados2 = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->orderBy('id','desc')->take($min)->get();
                        

                        $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                        //calcular la edad del paciente;
                        $paciente = paciente::find($orden->paciente_id);
                        $fechaHoy = Carbon::parse(date($orden->fecha_orden));
                        $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
                        $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                            
                        $pdf= \PDF::loadView('PDF.Prueba', ["examen_orden"=>$examen_orden,"examen"=>$examen,"orden"=>$orden,"resultados1"=>$resultados1,"resultados2"=>$resultados2,"edad_paciente"=>$edad_paciente ,"maximo"=>$max,"min"=>$min]);
                        $nombreArchivo = $paciente->nombre_paciente.'_'.$paciente->apellido_paciente.'-'.$orden->fecha_orden.'-'.$examen_orden->id.'-'.$examen->id.'.pdf';
                        return $pdf->stream($nombreArchivo);
                    }
                    
                    $resultados = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->get();
                    
                    

                    $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                    //calcular la edad del paciente;
                    $paciente = paciente::find($orden->paciente_id);
                    $fechaHoy = Carbon::parse(date($orden->fecha_orden));
                    $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
                    $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                        
                    $pdf= \PDF::loadView('PDF.resultados', ["examen_orden"=>$examen_orden,"examen"=>$examen,"orden"=>$orden,"resultados"=>$resultados,"edad_paciente"=>$edad_paciente,"conteo"=>'1']);
                    $nombreArchivo = $paciente->nombre_paciente.'_'.$paciente->apellido_paciente.'-'.$orden->fecha_orden.'-'.$examen_orden->id.'-'.$examen->id.'.pdf';
                    return $pdf->stream($nombreArchivo);
                }else{
                    
                    $resultados = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->get();
                    
                    $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                    //calcular la edad del paciente;
                    $paciente = paciente::find($orden->paciente_id);
                    $fechaHoy = Carbon::parse(date($orden->fecha_orden));
                    $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
                    $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                        
                    $pdf= \PDF::loadView('PDF.resultados', ["examen_orden"=>$examen_orden,"examen"=>$examen,"orden"=>$orden,"resultados"=>$resultados,"edad_paciente"=>$edad_paciente,"conteo"=>'0']);
                    $nombreArchivo = $paciente->nombre_paciente.'_'.$paciente->apellido_paciente.'-'.$orden->fecha_orden.'-'.$examen_orden->id.'-'.$examen->id.'.pdf';
                    return $pdf->stream($nombreArchivo);
                }
            }
        
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }
    }

    public function pdfResultadoGrupo($id,$tipo){
        
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
           
            if (in_array('/ordenesLaboratorio',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                    
                
                
                $examenes_orden = examen_orden_laboratorio::where('orden_laboratorio_id',$id)->get();
                
                
                
                $lista_examenes = array();
                foreach($examenes_orden as $examen){
                    if($examen->examen->es_externo==0){
                        if($examen->examen->tipo_examen->id==$tipo){
                            
                            array_push($lista_examenes,$examen->id);
                        }
                    }
                }

                
                
                $examenes_ordenes = examen_orden_laboratorio::whereIn('id',$lista_examenes)->get();
                
                $lista_examenes_tipo = array();
                foreach($examenes_ordenes as $result){                  
                        
                    array_push($lista_examenes_tipo,$result->id);
                                                    
                }
                
                $tipo_examen = tipo_examen::find($tipo);

                $resultados = resultado::whereIn('examen_orden_laboratorio_id',$lista_examenes_tipo)->get();
                                    
                
                $orden = orden_laboratorio::find($id);
                //calcular la edad del paciente;
                $paciente = paciente::find($orden->paciente_id);
                $fechaHoy = Carbon::parse(date($orden->fecha_orden));
                $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
                $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);

                $count =0;
                
                foreach ($resultados as $resultado) {
                    if($resultado->caracteristica_examen->unidad_caracteristica_examen!=''){
                        $count = 1;
                        
                        break;
                    }
                    
                }
                
                
                if($count==1){                     
                
                    $dompdf= \PDF::loadView('PDF.resultados2', ["tipo_examen"=>$tipo_examen,"examen"=>$examen,"orden"=>$orden,"resultados"=>$resultados,"edad_paciente"=>$edad_paciente,"conteo"=>'0']);
                    $nombreArchivo = $paciente->nombre_paciente.'_'.$paciente->apellido_paciente.'-'.$orden->fecha_orden.'-.pdf';
                    return $dompdf->stream($nombreArchivo);
                }else{
                    $pdf= \PDF::loadView('PDF.resultados', ["tipo_examen"=>$tipo_examen,"examen"=>$examen,"orden"=>$orden,"resultados"=>$resultados,"edad_paciente"=>$edad_paciente,"conteo"=>'1']);
                    $nombreArchivo = $paciente->nombre_paciente.'_'.$paciente->apellido_paciente.'-'.$orden->fecha_orden.'-.pdf';
                    return $pdf->stream($nombreArchivo);
                }
                
            }
            
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }
    }

    public function pdfMailResultado($id){
        
        $id = decrypt($id);    
                
                                    
        $examen_orden = examen_orden_laboratorio::find($id);
        $examen = examen::find($examen_orden->examen->id);
        if($examen->tiene_referencia == '0'){
            $conteo = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->get()->count();
            
            if ($conteo > '10') {
                $max = round($conteo/2);
                $min = round($conteo/2 , 0, PHP_ROUND_HALF_DOWN);
                $resultados1 = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->take($max)->get();
                $resultados2 = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->orderBy('id','desc')->take($min)->get();
                

                $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                //calcular la edad del paciente;
                $paciente = paciente::find($orden->paciente_id);
                $fechaHoy = Carbon::parse(date($orden->fecha_orden));
                $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
                $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                    
                $pdf= \PDF::loadView('PDF.Prueba', ["examen_orden"=>$examen_orden,"examen"=>$examen,"orden"=>$orden,"resultados1"=>$resultados1,"resultados2"=>$resultados2,"edad_paciente"=>$edad_paciente ,"maximo"=>$max,"min"=>$min]);
                $nombreArchivo = $paciente->nombre_paciente.'_'.$paciente->apellido_paciente.'-'.$orden->fecha_orden.'-'.$examen_orden->id.'-'.$examen->id.'.pdf';
                return $pdf->download($nombreArchivo);
            }
            
            $resultados = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->get();
            
            

            $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
            //calcular la edad del paciente;
            $paciente = paciente::find($orden->paciente_id);
            $fechaHoy = Carbon::parse(date($orden->fecha_orden));
            $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
            $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                
            $pdf= \PDF::loadView('PDF.resultados', ["examen_orden"=>$examen_orden,"examen"=>$examen,"orden"=>$orden,"resultados"=>$resultados,"edad_paciente"=>$edad_paciente,"conteo"=>'1']);
            $nombreArchivo = $paciente->nombre_paciente.'_'.$paciente->apellido_paciente.'-'.$orden->fecha_orden.'-'.$examen_orden->id.'-'.$examen->id.'.pdf';
            return $pdf->download($nombreArchivo);
        }else{
            
            $resultados = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->get();
            
            $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
            //calcular la edad del paciente;
            $paciente = paciente::find($orden->paciente_id);
            $fechaHoy = Carbon::parse(date($orden->fecha_orden));
            $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
            $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                
            $pdf= \PDF::loadView('PDF.resultados', ["examen_orden"=>$examen_orden,"examen"=>$examen,"orden"=>$orden,"resultados"=>$resultados,"edad_paciente"=>$edad_paciente,"conteo"=>'0']);
            $nombreArchivo = $paciente->nombre_paciente.'_'.$paciente->apellido_paciente.'-'.$orden->fecha_orden.'-'.$examen_orden->id.'-'.$examen->id.'.pdf';
            return $pdf->download($nombreArchivo);
        }
    }
        
             
}
