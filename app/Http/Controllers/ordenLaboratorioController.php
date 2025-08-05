<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\usuario;
use App\Models\orden_laboratorio;
use App\Models\medico;
use App\Models\paciente;
use App\Models\rol;
use App\Models\examen;
use App\Notifications\notificacionsOrdenes;
use App\Models\tipo_examen;
use App\Models\examen_orden_laboratorio;
use Session; // Agregar 
use Carbon\Carbon;

class ordenLaboratorioController extends Controller
{
    public function index(){
        if (Session::has('usuario_rol_id')) {
            $pantallas = Controller::urlsPantallasXUsuario();
            
            if (in_array('/orden_laboratorio',$pantallas) or in_array('/ordenesLaboratorio',$pantallas)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                if(Session::get('usuario_rol_id')==1){
                    $resultado = orden_laboratorio::get(); 
                }else{
                    $resultado = orden_laboratorio::get()->where('estado_orden_laboratorio','<>','Eliminado'); 
                }
                $permisos = Controller::permisos('orden_laboratorio');
                                    
                return view ("ordenLaboratorio.index", ["resultado"=>$resultado,'permisos'=>$permisos]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }
    public function create(){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/orden_laboratorio/create',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $rol = rol::where('nombre_rol','like','laboratorio%')->first();
               
                $externos = usuario::where('rol_id',$rol->id)->get();
                
                return view("ordenLaboratorio.create",['externos'=>$externos]);

            }           
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
        
        
    }
    public function create2($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/orden_laboratorio/create',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $paciente = paciente::find($id);
                return redirect(route('orden_laboratorio.create'))->with(['txtCedula'=>$paciente->identificacion_paciente]);

            }
           
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
        
        
    }
    public function insert(Request $request){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            $txtFecha = Carbon::now()->format('Y-m-d');
            
            
            if (in_array('/orden_laboratorio/create',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $externo = 0;
                if($request->esExterno){
                    $externo = 1;
                }
                
                $paciente = paciente::where('identificacion_paciente',$request->txtCedula)->first();
                $medico = medico::where('numero_registro',$request->txtRegistro)->first();
                $obj_orden_laboratorio = new orden_laboratorio();
                $obj_orden_laboratorio->fecha_orden = $txtFecha;
                $obj_orden_laboratorio->paciente_id = $paciente->id; 
                $obj_orden_laboratorio->usuario_id = Session::get('usuario_log_id');               
                $obj_orden_laboratorio->medico_id = $medico->id;
                $obj_orden_laboratorio->estado_orden_laboratorio = "Pendiente";
                $obj_orden_laboratorio->esExterno = $externo;
                $obj_orden_laboratorio->externo_id = $request->selectExterno; 
                $obj_orden_laboratorio->save();
                $nueva_orden = $obj_orden_laboratorio->id;

                $tipo_examen = tipo_examen::get();
                $caracteristica_examen = examen::where('estado_examen',1)->get();
                
                return view ("ordenLaboratorio.createnext", ["tipo_examen"=>$tipo_examen,"caracteristica_examen"=>$caracteristica_examen, "nueva_orden"=>$nueva_orden]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
        

    }
    public function createnext(Request $request){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
                if (in_array('/orden_laboratorio/create',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                    //esto ya estaba
                    $conteo = array();
                    foreach($request->examenes_id as $examen){
            
                        $examen_1= examen::find($examen);
                        
                        
                        if($examen_1->padre>0){
                            if (empty($conteo[$examen_1->padre])) {
                                $obj_orden_examen = new examen_orden_laboratorio ();
                                $obj_orden_examen->orden_laboratorio_id = $request->txtNueva_Orden;
                                $obj_orden_examen->examen_id = $examen_1->padre;
                                $obj_orden_examen->padre=-1;
                                $obj_orden_examen->estado_examen = "Pendiente";
                                $obj_orden_examen->save();
                            }
                           $conteo[$examen_1->padre] =  1;
                        }
                        
                        $obj_orden_examen = new examen_orden_laboratorio ();
                        $obj_orden_examen->orden_laboratorio_id = $request->txtNueva_Orden;
                        $obj_orden_examen->examen_id = $examen;
                        $obj_orden_examen->estado_examen = "Pendiente";
                        $obj_orden_examen->padre=$examen_1->padre;
                        $obj_orden_examen->save();
                    
                    }

                    $orden_laboratorio = orden_laboratorio::find($request->txtNueva_Orden);

                   
                
                    //Enviar notificacionea a usuarios
                    $notificacion['orden_id'] = $request->txtNueva_Orden;
                    $notificacion['mensaje'] = 'El paciente '.$orden_laboratorio->paciente->nombre_paciente." ".$orden_laboratorio->paciente->apellido_paciente.' tiene una nueva orden';
                    
                    $roles = rol::where('nombre_rol','like','labora%')->get();
                    $lista_roles = array();
                    foreach($roles as $rol){
                        array_push($lista_roles,$rol->id);
                    }
                    
                    usuario::whereIn('rol_id',$lista_roles)                            
                            ->each(function(usuario $usuario) use ($notificacion){
                                $usuario->notify(new notificacionsOrdenes($notificacion));
                            });

                    return redirect (route("orden_laboratorio.index"));

                }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }

        


    }

    public function update($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
           
            if (in_array('/orden_laboratorio/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $resultado = orden_laboratorio::find($id);        
                $paciente = paciente::find($resultado->paciente_id);
                $medico = medico::find($resultado->medico_id);
                return view ("orden_laboratorio.update",  ["fila"=>$resultado,"medico"=>$medico,"paciente"=>$paciente]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
    
       
    }

    public function save(Request $request){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
         
            if (in_array('/orden_laboratorio/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $paciente = paciente::where('identificacion_paciente',$request->txtCedula)->first();
                $medico = medico::where('numero_registro',$request->txtRegistro)->first();

                $obj_orden_laboratorio = orden_laboratorio::find($request->txtId);
                $obj_orden_laboratorio->fecha_orden = $request->txtFecha;
                $obj_orden_laboratorio->paciente_id = $paciente->id;        
                $obj_orden_laboratorio->medico_id = $medico->id;
                $obj_orden_laboratorio->usuario_id = Session::get('usuario_log_id');
                $obj_orden_laboratorio->estado_orden_laboratorio = "Pendiente";
                $obj_orden_laboratorio->save();
                // $nueva_orden = $obj_orden_laboratorio->id;
                $resultados = examen_orden_laboratorio::where("orden_laboratorio_id",$obj_orden_laboratorio->id)->get();
                $tipo_examen = tipo_examen::get();

                $examenes = examen::get();
                $lista_examen = array();
                foreach($resultados as $resultado){
                    array_push($lista_examen,$resultado->examen_id);
                }
                
                return view ("orden_laboratorio.updatenext",  ["lista_examenes"=>$lista_examen, "examenes"=>$examenes, "tipo_examen"=>$tipo_examen, "id_orden_laboratorio"=>$obj_orden_laboratorio->id]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function updatenext(Request $request){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/orden_laboratorio/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                DB::table('examen_orden_laboratorio')->where('orden_laboratorio_id','=',$request->txtOrdenLaboratorio)->delete() ;
    
                foreach($request->examenes_id as $examen){
                
                    
                    $obj_orden_examen = new examen_orden_laboratorio ();
                    $obj_orden_examen->orden_laboratorio_id = $request->txtOrdenLaboratorio;
                    $obj_orden_examen->examen_id = $examen;
                    $obj_orden_examen->estado_examen = "Pendiente";
                    $obj_orden_examen->save();
                
                }
                        
                return redirect (route("orden_laboratorio.index"));
            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }

        
       

    }

    public function delete($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/orden_laboratorio/delete',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $obj = orden_laboratorio::find($id);
                $obj->estado_orden_laboratorio = "Eliminado";
                $obj->save();
                return redirect (route("orden_laboratorio.index"));

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function desbloquear($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/orden_laboratorio/delete',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                
                $examenes_total = examen_orden_laboratorio::where('orden_laboratorio_id',$id)->count();
                $examenes_terminados = examen_orden_laboratorio::where('orden_laboratorio_id',$id)->where('estado_examen','Terminado')->count();
                $obj = orden_laboratorio::find($id);
                if ($examenes_terminados==0) {
                    $obj->estado_orden_laboratorio = "Pendiente";
                }elseif($examenes_terminados<$examenes_total){
                    $obj->estado_orden_laboratorio = "En Proceso";
                }else{
                    $obj->estado_orden_laboratorio = "Terminado";
                }
                $obj->save();
                return redirect (route("orden_laboratorio.index"));
            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        

    }

    public function consultar($cedula){
        $valor= array();
        $existe = paciente::where('identificacion_paciente',$cedula)->count();
        if($existe ==1){
            $paciente = paciente::where('identificacion_paciente',$cedula)->first();
            $valor= array("cedula"=>$cedula,"nombre"=>$paciente->nombre_paciente." ".$paciente->apellido_paciente); 
            
        }

        return $valor;
    }

    public function consultarRegistro($registro){
        $valor= array();
        $existe = medico::where('numero_registro',$registro)->count();
        if($existe ==1){
            $medico = medico::where('numero_registro',$registro)->first();
            $valor= array("registro"=>$registro,"nombre"=>$medico->nombre_medico); 
            
        }

        return $valor;
    }

    public function verHistorial($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/paciente',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                if(Session::get('usuario_rol_id')==1){
                    $resultado = orden_laboratorio::where('paciente_id',$id)->get(); 
                }else{
                    $resultado = orden_laboratorio::get()->where('estado_orden_laboratorio','<>','Eliminado')->where('paciente_id',$id); 
                }
                $permisos = Controller::permisos('orden_laboratorio');
                                    
                return view ("ordenLaboratorio.index", ["resultado"=>$resultado,'permisos'=>$permisos]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
    }

}
