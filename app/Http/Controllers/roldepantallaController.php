<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\pantalla;
use App\Models\rol;
use App\Models\rol_pantalla;
use Illuminate\Support\Facades\DB;
use Session;

class roldepantallaController extends Controller
{
    public function index(){
        
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
           
            if (in_array('/pantalla',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $resultado = pantalla::orderBy('padre')->orderBy('id')->get();
                $permisos = Controller::permisos('pantalla');
                $pantallas_padre = pantalla::where('padre',0)->get();
                return view('pantallas.index',["resultado"=>$resultado,'permisos'=>$permisos,"pantallas_padre"=>$pantallas_padre]);

            }
            
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }
        
    
    }
    public function create(){

        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/pantalla/create',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                $pantallas_padre = pantalla::where('padre',0)->get();
    
                return view('pantallas.create',["pantallas_padre"=>$pantallas_padre]);

            }
            
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }
        
    
    }   

   

    public function insert(Request $request){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/pantalla/create',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba
                if($request->txtEstado == 1){
                    $estado =1;
                }else{
                    $estado=0;
                }
                
                $obj_pantalla = new pantalla();        
                $obj_pantalla->nombre_pantalla=$request->txtNombre;
                $obj_pantalla->titulo_pantalla = str_replace(' ', '', $request->txtNombre);        
                $obj_pantalla->url_pantalla=$request->txtUrl;
                $obj_pantalla->padre = $request->txtPadre;
                $obj_pantalla->estado_pantalla = $estado;
                $obj_pantalla->save();
                return redirect(route('pantalla.index'))->withErrors(['status' => "Se ha creado la pantalla" ]);
            }
        
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    

    public function elimina($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/pantalla/delete',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                $resultado = pantalla::find($id);         
                $resultado->delete();
                
                return redirect(route('pantalla.index'))->withErrors(['status' => "Se ha eliminado la pantalla" ]);
            }
            
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }
       
    }

    public function update($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/pantalla/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                $res = pantalla::find($id);
                $pantallas_padre = pantalla::where('padre',0)->get();
                return view ('pantallas.modifica', ["pantalla"=>$res,"pantallas_padre"=>$pantallas_padre]);
            }
            
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function save(Request $request){

        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/pantalla/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                if($request->txtEstado == 1){
                    $estado =1;
                }else{
                    $estado=0;
                }
                
                $obj_panta= pantalla::find($request->txtId);
                $obj_panta->nombre_pantalla= $request->txtNombre;
                $obj_panta->titulo_pantalla = str_replace(' ', '', $request->txtNombre);        
                $obj_panta->url_pantalla= $request->txtUrl;
                $obj_panta->estado_pantalla = $estado;
                $obj_panta->padre = $request->txtPadre;
                $obj_panta->save();
        
                return redirect(route('pantalla.index'))->withErrors(['status' => "Se ha actualizado la pantalla" ]);
            }
        
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }
        

    }

    public function rolPantalla($id){

        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/roles/pantalla/0',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                $pantallas = pantalla::orderBy('padre')->orderBy('id')->get();
    
                $pantallas_rol= rol_pantalla::get()->where('rol_id',$id);
                $rol = rol::find($id);
                $lista_pantallas= array();
                foreach($pantallas_rol as $pantalla){
                    array_push($lista_pantallas,$pantalla->pantalla_id);
                }
        
                return view("rolpantalla.selectPantallaId",["pantallas"=>$pantallas,"rol"=>$rol,"lista_pantallas"=>$lista_pantallas]);
            }
            
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }
        
        
    }

    public function pantallaSave(Request $request){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/roles/pantalla/0',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                DB::table('rol_pantalla')->where('rol_id', '=', $request->txtid)->delete();
                if (empty($request->pantallas_id )) {
                    
                } else {
                    foreach($request->pantallas_id as $pantalla_id){ 

                        $obj_pantalla= new rol_pantalla();
                        $obj_pantalla->rol_id= $request->txtid;
                        $obj_pantalla->pantalla_id = $pantalla_id;
                        $obj_pantalla->save();
                        
                    }  
                }
                
                
                return redirect (route('rol.index'))->withErrors(['status' => "El rol se modifico correctamente" ]);
            }
            
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }

        

    }

    public function rolesPantalla($id){

        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/roles/pantalla/0',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                $pantallas = pantalla::get();
                $pantallas_rol= rol_pantalla::get()->where('rol_id',$id);
                $roles = rol::orderBy('id', 'ASC')->get();
                $rol = rol::find($id);
                $lista_pantallas= array();
                foreach($pantallas_rol as $pantalla){
                    array_push($lista_pantallas,$pantalla->pantalla_id);
                }
        
                return view("rolpantalla.selectPantalla",["pantallas"=>$pantallas,"rol"=>$rol,"roles"=>$roles,"lista_pantallas"=>$lista_pantallas]);
            }
            
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }

        

        
    }

    public function rolesPantallas(){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/roles/pantallas',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                $resultado = rol::where('estado_rol',1)->get();
                $pantallas = rol_pantalla::groupBy('rol_id')
                                ->selectRaw('count(*) as total, rol_id')
                                ->get();
                
        
                return view('rolpantalla.index',['resultado'=>$resultado,"pantallas"=>$pantallas]);
            }
            
              
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        }else{
            return redirect(route('login.index'));
        }

       
    }

    
}


