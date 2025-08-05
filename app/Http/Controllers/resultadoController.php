<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\examen;
use App\Models\tipo_examen;
use App\Models\paciente;
use App\Models\resultado;
use App\Models\orden_laboratorio;
use App\Models\rol;
use App\Models\usuario;
use App\Models\notificacion;
use App\Models\caracteristica_examen;
use App\Models\examen_orden_laboratorio;
use App\Models\examen_caracteristica_examen;
use App\Notifications\ordenTerminada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResultadoLaboratorio;
use Session;

class resultadoController extends Controller
{
    public function index(){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
                if (in_array('/ordenesLaboratorio',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                    $rol = rol::find(Session::get('usuario_rol_id'));
                   
                    if ($rol->tipo_rol != '2') {
                        
                        $resultado = orden_laboratorio::where('estado_orden_laboratorio','<>','Eliminado')->orderBy('id','Desc')->get();
                        
                        
                    }else{
                        if($rol->nombre_rol=='Paciente'){
                            $usuario = usuario::find(Session::get('usuario_log_id'));
                            $paciente = paciente::where('identificacion_paciente',$usuario->nombre_usuario)->first();
                            $resultado = orden_laboratorio::where('estado_orden_laboratorio','<>','Eliminado')->where('paciente_id',$paciente->id)->orderBy('id','Desc')->get();
                        }else{
                            $resultado = orden_laboratorio::where('estado_orden_laboratorio','<>','Eliminado')->where('externo_id',Session::get('usuario_log_id'))->orderBy('id','Desc')->get();
                        }
                    }
                    return view('resultado.index', ["resultado"=>$resultado]);
                }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }

        
    }

    public function examenes($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
                
                if (in_array('/ordenesLaboratorio',$pantallas_menu) or in_array('/orden_laboratorio',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                    $rol = rol::find(Session::get('usuario_rol_id'));
                    
                    if ($rol->tipo_rol != '2') {
                        if($orden = orden_laboratorio::where('id',$id)->where('estado_orden_laboratorio','<>','Eliminado')->count()>0){

                            $orden = orden_laboratorio::find($id);
                        
                            $resultado = examen_orden_laboratorio::where('orden_laboratorio_id',$id)->where('padre','<',1)->get();
                            
                            $lista_examen = array();
                            foreach($resultado as $resul){
                                array_push($lista_examen,$resul->examen_id);
                            }
                            $examenes = examen::whereIn('id',$lista_examen)->get();
                            
                            $lista_examenes = array();
                            foreach($examenes as $examen){
                            
                                if($examen->es_externo==0){
                                    array_push($lista_examenes,$examen->tipo_examen_id);
                                }
                            }
                            $lista_tipo = array();
                            foreach(array_unique($lista_examenes) as $tipo){
                                $i = 0;
                                foreach($lista_examenes as $exam){

                                    if($exam==$tipo){
                                        $i=$i+1;
                                    }
                                }
                                if($i>1){
                                    array_push($lista_tipo,$tipo);
                                }
                            }

                            

                            $tipos_examen =  tipo_examen::whereIn('id',$lista_tipo)->get();
                            
                            $count = 0;
                            
                            if(sizeof($lista_examenes)==sizeof($lista_tipo)){
                                $count = 1;
                            }
                            
                            $permisos = Controller::permisos('resultado');
                                               
                            return view('resultado.examenes', ["resultado"=>$resultado,
                                                                "orden"=>$orden,
                                                                "tipos_examen"=>$tipos_examen,
                                                                "count"=>$count,
                                                                'permisos'=>$permisos]);
                        }else{
                            return redirect(route('resultado.index'))->withErrors(['status' => "El examen no existe fue eliminado" ]);
                        }
                    }else{
                        
                        if($orden = orden_laboratorio::where('id',$id)->where('estado_orden_laboratorio','<>','Eliminado')->count()>0){

                            $orden = orden_laboratorio::find($id);
                            $rol = rol::find(Session::get('usuario_rol_id'));
                           
                            if ($rol->tipo_rol==2) {
                                if ($rol->nombre_rol=='Paciente') {                                    
                                    $usuario = usuario::find(Session::get('usuario_log_id'));
                                    $paciente = paciente::where('identificacion_paciente',$usuario->nombre_usuario)->first();
                                    if($orden->paciente_id != $paciente->id){
                                        return redirect()->back();
                                    }
                                    
                                }else{

                                    if($orden->externo_id != Session::get('usuario_log_id')){
                                        return redirect()->back();
                                    }

                                }
                                
                            }
                            
                            
                            $resultado = examen_orden_laboratorio::where('orden_laboratorio_id',$id)->where('padre','<',1)->get();
                            
                            $lista_examen = array();
                            foreach($resultado as $resul){
                                array_push($lista_examen,$resul->examen_id);
                            }
                            $examenes = examen::whereIn('id',$lista_examen)->get();
                            
                            $lista_examenes = array();
                            foreach($examenes as $examen){
                            
                                if($examen->es_externo==0){
                                    array_push($lista_examenes,$examen->tipo_examen_id);
                                }
                            }
                            $lista_tipo = array();
                            foreach(array_unique($lista_examenes) as $tipo){
                                $i = 0;
                                foreach($lista_examenes as $exam){

                                    if($exam==$tipo){
                                        $i=$i+1;
                                    }
                                }
                                if($i>1){
                                    array_push($lista_tipo,$tipo);
                                }
                            }

                            

                            $tipos_examen =  tipo_examen::whereIn('id',$lista_tipo)->get();
                            
                            $count = 0;
                            
                            if(sizeof($lista_examenes)==sizeof($lista_tipo)){
                                $count = 1;
                            }
                            
                            $permisos = Controller::permisos('resultado');
                                               
                            return view('resultado.examenes', ["resultado"=>$resultado,
                                                                "orden"=>$orden,
                                                                "tipos_examen"=>$tipos_examen,
                                                                "count"=>$count,
                                                                'permisos'=>$permisos]);
                        }else{
                            return redirect(route('resultado.index'))->withErrors(['status' => "El examen no existe fue eliminado" ]);
                        }
                    }
                }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }
    
    public function eliminarExamen($id){
        $examen = examen_orden_laboratorio::find($id);
        $examen->delete();

        return redirect()->back()->withErrors(['status' => "El examen fue eliminado" ]);
    }

    public function resultados($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
                if (in_array('/resultado/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                    
                    $examen_orden = examen_orden_laboratorio::find($id);
                    $examen = examen::find($examen_orden->examen_id);        
                    $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                    //calcular la edad del paciente;
                    $paciente = paciente::find($orden->paciente_id);
                    $fechaHoy = Carbon::parse(date($orden->fecha_orden));
                    $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
                    $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                          
                    $caracteristicas = examen_caracteristica_examen::where('examen_id',$examen->id)->orderBy('num_orden')->get();
                    return view('resultado.resultados', ["examen_orden"=>$examen_orden,"orden"=>$orden,"examen"=>$examen,"edad_paciente"=>$edad_paciente,'caracteristicas'=>$caracteristicas]);

                }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }
    public function resultados1($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/resultado/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                
                $examen_orden = examen_orden_laboratorio::find($id);
                $examen = examen::find($examen_orden->examen_id);        
                $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                
                //calcular la edad del paciente;
                $paciente = paciente::find($orden->paciente_id);
                $fechaHoy = Carbon::parse(date($orden->fecha_orden));
                $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
                $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                $examenes = examen_orden_laboratorio::where('orden_laboratorio_id',$orden->id)->where('padre',$examen->id)->get();
                $lista_caracteristicas = array();
                
                foreach($examenes as $fila){
                    array_push($lista_caracteristicas, $fila->examen_id);
                }  
                
                $caracteristicas = examen_caracteristica_examen::whereIn('examen_id',$lista_caracteristicas)->orderBy('num_orden')->get();
                
                return view('resultado.resultados', ["examen_orden"=>$examen_orden,"orden"=>$orden,"examen"=>$examen,"edad_paciente"=>$edad_paciente,'caracteristicas'=>$caracteristicas]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function insertarResultados(Request $request){         
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/resultado/insert',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                
                
                $resultado = $request->valores;
                
                
                
                foreach($request->caracteristica_id as $caracteristica){
                    
                    $obj_resultado = new resultado();
                    $obj_resultado->caracteristica_examen_id = $caracteristica;
                    $valor_resultado = $resultado[$caracteristica];
                    $valor_resultado = str_replace("<","	&lt;",$valor_resultado);
                    $valor_resultado = str_replace(">","	&gt;",$valor_resultado);
                    $valor_resultado = str_replace("↑",'<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',$valor_resultado);
                    $valor_resultado = str_replace("↓",'<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',$valor_resultado);
                    $obj_resultado->valor =  nl2br($valor_resultado);
                    $obj_resultado->examen_orden_laboratorio_id = $request->txtExamenOrdenLaboratorioId;
                    $obj_resultado->save();
                    
                    
                }

                $examen_orden = examen_orden_laboratorio::find($request->txtExamenOrdenLaboratorioId);
                $examen_orden->estado_examen ="Terminado";
                $examen_orden->save(); 
                
                $examenes_total =  examen_orden_laboratorio::where('orden_laboratorio_id',$examen_orden->orden_laboratorio_id)->where('padre','<=',0)->count();
                $examenes_terminados =  examen_orden_laboratorio::where('orden_laboratorio_id',$examen_orden->orden_laboratorio_id)->where('padre','<=',0)->where('estado_examen','Terminado')->count();
                if($examenes_total==$examenes_terminados){
                    $orden_laboratorio = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                    $orden_laboratorio->estado_orden_laboratorio="Terminado";
                    $orden_laboratorio->save();
                    //notificacion
                    $notificacion['orden_id'] = $orden_laboratorio->id;
                    $notificacion['mensaje'] = 'La orden de laboratorio N° '.$orden_laboratorio->id.' esta terminada';
                                  
                    
                    usuario::where('nombre_usuario',$orden_laboratorio->paciente->identificacion_paciente)                            
                            ->each(function(usuario $usuario) use ($notificacion){
                                $usuario->notify(new ordenTerminada($notificacion));
                            });
                    if($orden_laboratorio->esExterno == 1){
                        usuario::where('id',$orden_laboratorio->externo_id)                            
                            ->each(function(usuario $usuario) use ($notificacion){
                                $usuario->notify(new ordenTerminada($notificacion));
                            });
                    }
                    
                }else{
                    $orden_laboratorio = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                    $orden_laboratorio->estado_orden_laboratorio="En Proceso";
                    $orden_laboratorio->save();
                }
                
                

                return redirect(route('ordenLaboratorio.examenes', ['id' => $examen_orden->orden_laboratorio_id]))->withErrors(['status' => "Se guardo los resultados del examen" ]);
            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
        
  
       
    }

    public function verResultados($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/ordenesLaboratorio',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                $examen_orden = examen_orden_laboratorio::find($id);
                $resultados = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->get();
                $examen = examen::find($examen_orden->examen->id);      
                $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                //calcular la edad del paciente;
                $paciente = paciente::find($orden->paciente_id);
                $fechaHoy = Carbon::parse(date($orden->fecha_orden));
                $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
                $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
            
                    
                return view('resultado.verResultados', ["examen_orden"=>$examen_orden,"examen"=>$examen,"orden"=>$orden,"resultados"=>$resultados,"edad_paciente"=>$edad_paciente]);
            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
       
    }

    public function update($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/resultado/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                $examen_orden = examen_orden_laboratorio::find($id);
                $examen = examen::find($examen_orden->examen_id);        
                $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                //calcular la edad del paciente;
                $paciente = paciente::find($orden->paciente_id);
                $fechaHoy = Carbon::parse(date($orden->fecha_orden));
                $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
                $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                $resultados = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->get(); 
                
                
                foreach($resultados as $resultado){
                    $valor = $resultado->valor;
                    $valor = str_replace("<br />","",$valor);
                    $valor = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',"↓",$valor);
                    $valor = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',"↑",$valor);
                    $valor = str_replace('&lt;',"<",$valor);
                    $valor = str_replace('&gt;',">",$valor);
                    
                    $resultado->valor= $valor;
                    $referencia = $resultado->caracteristica_examen->valor_referencia_caracteristica_examen;
            
                    $referencia = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',"↓",$referencia);
                    $referencia = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',"↑",$referencia);
                    $referencia = str_replace('&lt;',"<",$referencia);
                    $referencia = str_replace('&gt;',">",$referencia);
                    $resultado->caracteristica_examen->valor_referencia_caracteristica_examen = $referencia;
                }
                
                return view('resultado.update', ["resultados"=>$resultados,"examen_orden"=>$examen_orden,"orden"=>$orden,"examen"=>$examen,"edad_paciente"=>$edad_paciente]);
            }
        
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function save(Request $request){

        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
           
            if (in_array('/resultado/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                $resultado = $request->valores;
                
                foreach($request->resultado_id as $result){
                    
                    $obj_resultado = resultado::find($result);   
                    
                    $valor_resultado = $resultado[$result];
                    $valor_resultado = str_replace("<","	&lt;",$valor_resultado);
                    $valor_resultado = str_replace(">","	&gt;",$valor_resultado);
                    $valor_resultado = str_replace("↑",'<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',$valor_resultado);
                    $valor_resultado = str_replace("↓",'<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',$valor_resultado);
                    $obj_resultado->valor =  nl2br($valor_resultado);            
                    $obj_resultado->save();
                    
                }
        
                $examen_orden = examen_orden_laboratorio::find($request->txtExamenOrdenLaboratorioId);
                
                
                $examenes_total =  examen_orden_laboratorio::where('orden_laboratorio_id',$examen_orden->orden_laboratorio_id)->count();
                $examenes_terminados =  examen_orden_laboratorio::where('orden_laboratorio_id',$examen_orden->orden_laboratorio_id)->where('estado_examen','Terminado')->count();
                if($examenes_total==$examenes_terminados){
                    $orden_laboratorio = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                    $orden_laboratorio->estado_orden_laboratorio="Terminado";
                    $orden_laboratorio->save();
                }
        
                return redirect(route('ordenLaboratorio.examenes', ['id' => $examen_orden->orden_laboratorio_id]))->withErrors(['status' => "Se actualizaron los resultados del examen" ]);
            }
        
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        

        

    }

    public function notificacion($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            if (in_array('/resultado/insert',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                
                $notificaciones = notificacion::where('type','App\Notifications\notificacionsOrdenes')->get();
                foreach($notificaciones as $notificacion){
                    $data = json_decode($notificacion->data, true);
                                                            
                    $id_orden =  $data["orden_id"]; 

                    if($id_orden == $id){
                        $notificacion->delete();
                    }
                }
                

                return redirect(route('ordenLaboratorio.examenes', ['id' => $id]));
            }else if(in_array('/ordenesLaboratorio',$pantallas_menu)){

                $notificaciones = notificacion::where('type','App\Notifications\notificacionsOrdenes')->get();
                foreach($notificaciones as $notificacion){
                    $data = json_decode($notificacion->data,true);                    
                    $id_orden =  $data['orden_id'];                       
                    
                    if($id_orden == $id){
                        $notificacion->delete();
                    }
                }
                

                return redirect(route('ordenLaboratorio.examenes', ['id' => $id]));
                
            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
    }

    public function examenTerminado($id){  
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/resultado/insert',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                $examen_orden = examen_orden_laboratorio::find($id);
        
       
                foreach($examen_orden->examen->examen_caracteristica_examen as $examen_caracteristica){

                    $obj_resultado = new resultado();
                    $obj_resultado->caracteristica_examen_id = $examen_caracteristica->caracteristica_examen_id;
                            
                    $obj_resultado->valor =  "Terminado";
                    $obj_resultado->examen_orden_laboratorio_id = $id;
                    $obj_resultado->save();
                }

                
                $examen_orden->estado_examen ="Terminado";
                $examen_orden->save(); 
                
                $examenes_total =  examen_orden_laboratorio::where('orden_laboratorio_id',$examen_orden->orden_laboratorio_id)->where('padre','<=',0)->count();
                $examenes_terminados =  examen_orden_laboratorio::where('orden_laboratorio_id',$examen_orden->orden_laboratorio_id)->where('padre','<=',0)->where('estado_examen','Terminado')->count();
                if($examenes_total==$examenes_terminados){
                    $orden_laboratorio = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                    $orden_laboratorio->estado_orden_laboratorio="Terminado";
                    $orden_laboratorio->save();
                }else{
                    $orden_laboratorio = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                    $orden_laboratorio->estado_orden_laboratorio="En Proceso";
                    $orden_laboratorio->save();
                }
                
                

                return redirect(route('ordenLaboratorio.examenes', ['id' => $examen_orden->orden_laboratorio_id]))->withErrors(['status' => "Se guardo los resultados del examen" ]);
            
              
            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function ordenTerminada($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            if(in_array('/ordenesLaboratorio',$pantallas_menu)){

                $notificaciones = notificacion::where('type','App\Notifications\ordenTerminada')
                                                ->where('notifiable_id',Session::get('usuario_log_id'))->get();
                foreach($notificaciones as $notificacion){
                    $data = json_decode($notificacion->data,true);                    
                    $id_orden =  $data['orden_id'];                       
                    
                    if($id_orden == $id){
                        $notificacion->delete();
                    }
                }
                

                return redirect(route('ordenLaboratorio.examenes', ['id' => $id]));
                
            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
    }
}
