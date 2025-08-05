<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\caracteristica_examen;
use Illuminate\Support\Facades\DB;
use Session;

class caracteristica_examen_controller extends Controller
{
    
    public function index(){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/paciente',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                if(Session::get('usuario_rol_id')==1){
                    $resultado = caracteristica_examen::get();
                }else{
                    $resultado = caracteristica_examen::where('estado_caracteristica_examen',1)->get();
                }
                $valores_referencia = array();
                foreach ($resultado as $caracteristica) {
                    $valores_referencia[$caracteristica->id] = str_replace("<br />","",$caracteristica->valor_referencia_caracteristica_examen );
                }
                
                $permisos = Controller::permisos('caracteristicaExamen');
                
                return view ("caracteristica_examen.index", ["resultado"=>$resultado,'permisos'=>$permisos,"valores_referencia"=>$valores_referencia]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

 


    public function create(){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/caracteristicaExamen/create',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba 
                return view("caracteristica_examen.create");

            }
           
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function insert(Request $request){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/caracteristicaExamen/create',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba 
                if($request->has('txtEsObligatorio')){
                    $es_obligatorio =1;
                }else{
                    $es_obligatorio =0;
                }
                $obj_caracteristica_examen = new caracteristica_examen();
                $obj_caracteristica_examen->nombre_caracteristica_examen = $request->txtNombre;
                $obj_caracteristica_examen->unidad_caracteristica_examen = $request->txtUnidad;
                $obj_caracteristica_examen->es_obligatorio = $es_obligatorio;
                $valor_referencia = $request->txtValor;
                $valor_referencia = str_replace("<","	&lt;",$valor_referencia);
                $valor_referencia = str_replace(">","	&gt;",$valor_referencia);
                $valor_referencia = str_replace("↑",'<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',$valor_referencia);
                $valor_referencia = str_replace("↓",'<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',$valor_referencia);
                $obj_caracteristica_examen->valor_referencia_caracteristica_examen = nl2br($valor_referencia);
                $obj_caracteristica_examen->save();

                return redirect(route('caracteristica_examen.index'))->withErrors(['status' => "Se creó la caracteristica " .$obj_caracteristica_examen->nombre_caracteristica_examen ]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function update($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/caracteristicaExamen/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba 
                $resultado = caracteristica_examen::find($id);
                
                $valor_referencia = $resultado->valor_referencia_caracteristica_examen;
                $valor_referencia = str_replace("<br />","",$valor_referencia);
                $valor_referencia = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',"↓",$valor_referencia);
                $valor_referencia = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',"↑",$valor_referencia);
                $valor_referencia = str_replace('&lt;',"<",$valor_referencia);
                $valor_referencia = str_replace('&gt;',">",$valor_referencia);
                return view ("caracteristica_examen.update",  ["resultado"=>$resultado,"valor_referencia"=>$valor_referencia]);

            }
        
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
        
    }

    public function save(Request $request){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/caracteristicaExamen/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba 
                if($request->has('txtEsObligatorio')){
                    $es_obligatorio =1;
                }else{
                    $es_obligatorio =0;
                }
                $obj_caracteristica_examen = caracteristica_examen::find($request->txtId);
                $obj_caracteristica_examen->nombre_caracteristica_examen = $request->txtNombre;
                $obj_caracteristica_examen->unidad_caracteristica_examen = $request->txtUnidad;
                $obj_caracteristica_examen->es_obligatorio = $es_obligatorio;
                $valor_referencia = $request->txtValor;
                $valor_referencia = str_replace("<","	&lt;",$valor_referencia);
                $valor_referencia = str_replace(">","	&gt;",$valor_referencia);
                $valor_referencia = str_replace("↑",'<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',$valor_referencia);
                $valor_referencia = str_replace("↓",'<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',$valor_referencia);
                $obj_caracteristica_examen->valor_referencia_caracteristica_examen = nl2br($valor_referencia);
                $obj_caracteristica_examen->save();
                return redirect(route('caracteristica_examen.index'))->withErrors(['status' => "Se ha guardado la caracteristica ".$obj_caracteristica_examen->nombre_caracteristica_examen ]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        

    }

   

    public function delete($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
           
            if (in_array('/caracteristicaExamen/delete',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba 
                $obj_caracteristica_examen = caracteristica_examen::find($id);
    
                $obj_caracteristica_examen->estado_caracteristica_examen = 0;
                $obj_caracteristica_examen->save();
                return redirect(route('caracteristica_examen.index'))->withErrors(['danger' => "Se elimino la caracteristica ".$obj_caracteristica_examen->nombre_caracteristica_examen ]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
       

    }

    
    public function desbloquear($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
                if (in_array('/caracteristicaExamen/delete',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                    $obj_caracteristica_examen = caracteristica_examen::find($id);        
                    $obj_caracteristica_examen->estado_caracteristica_examen = 1;
                    $obj_caracteristica_examen->save();
                    return redirect(route('caracteristica_examen.index'))->withErrors(['status' => "Se desbloqueado la caracteristica ".$obj_caracteristica_examen->nombre_caracteristica_examen]);
                }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    

}