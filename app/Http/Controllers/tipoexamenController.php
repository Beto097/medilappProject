<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\usuario;
use App\Models\tipo_examen;
use Illuminate\Support\Facades\DB;
use Session; // Agregar 

class tipoexamenController extends Controller
{
    public function index(){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
           
            if (in_array('/medico',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                if(Session::get('usuario_rol_id')==1){
                    $resultado = tipo_examen::get(); 
                }else{
                    $resultado = tipo_examen::where('estado_tipo_examen',1)->get(); 
                }
                $permisos = Controller::permisos('tipoexamen');    
                return view ("tipo_examen.index", ["resultado"=>$resultado,"permisos"=>$permisos]);

            }
            
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function create(){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/tipoexamen/create',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                return view("tipo_examen.create");

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function insert(Request $request){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
           
            if (in_array('/tipoexamen/create',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $obj_tipo_examen = new tipo_examen();
                $obj_tipo_examen->nombre_tipo_examen = $request->txttipoexamen;  
        
        
                $obj_tipo_examen->save();
                return redirect(route('tipoexamen.index'))->withErrors(['status' => "Se creó el tipo de examen: "]);
    
            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }

           


        
    }

    public function update($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
           
            if (in_array('/tipoexamen/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $resultado = tipo_examen::get()->where('id',$id);
                return view ("tipo_examen.update",  ["resultado"=>$resultado]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function save(Request $request){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
                if (in_array('/tipoexamen/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                    //esto ya estaba
                    $obj_tipo_examen = tipo_examen::find($request->txtId);
                    $obj_tipo_examen->nombre_tipo_examen = $request->txttipoexamen;
                    $obj_tipo_examen->save();
                    return redirect(route('tipoexamen.index'))->withErrors(['status' => "Se ha actualizado el tipo de examen" ]);

                }
            
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }

        

    }

    public function delete($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/tipoexamen/delete',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $obj = tipo_examen::find($id);
                $obj->estado_tipo_examen =0;
                $obj->save();
                return redirect (route("tipoexamen.index"));

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
       
    }
    
    public function desbloquear($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
           
                if (in_array('/tipoexamen/delete',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                    //esto ya estaba 
                    $obj_tipo = tipo_examen::find($id);
                    $obj_tipo->estado_tipo_examen = 1;
                    $obj_tipo->save();
                    return redirect(route('tipoexamen.index'))->withErrors(['status' => "Se ha desbloqueado el tipo de examen" ]);

                }
            
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        

    }

    
}
