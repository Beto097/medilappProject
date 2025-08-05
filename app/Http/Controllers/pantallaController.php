<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\pantalla;
use App\Models\rol;

use Session;

class pantallaController extends Controller
{
    public function index(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/pantalla')){
                        
            if (Auth::user()->rol->tipo_rol == 1) {

                $resultado = pantalla::get(); 

            } else {

                $resultado=pantalla::where('estado_pantalla',1)->get();
        
            }
            
            return view ("pantalla.index", ["resultado"=>$resultado]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function create(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/pantalla/create')){
                                   
            $pantallas_padre = pantalla::where('padre',0)->get();

            return view ("pantalla.create",['pantallas_padre'=>$pantallas_padre]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

    }


    public function insert(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/pantalla/create')){
            
           
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
        
        
    }

    public function rolesPantalla($id){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/roles/pantalla/0')){

            $pantallas = pantalla::where('padre',0)->where('estado_pantalla',1)->orderBy('orden','ASC')->get();
            $rol = rol::find($id); 
            $pantallas_rol= $rol->pantallas;
            $roles = rol::orderBy('id', 'ASC')->get();
            $lista_pantallas= array();
            foreach($pantallas_rol as $pantalla){
                array_push($lista_pantallas,$pantalla->id);
            }
    
            return view("pantalla.selectPantallaId",["pantallas"=>$pantallas,"rol"=>$rol,"roles"=>$roles,"lista_pantallas"=>$lista_pantallas]);
        }
        
            
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
        
        
    }

    public function save(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/pantalla/update')){
            
           
            if($request->txtEstado == 1){
                $estado =1;
            }else{
                $estado=0;
            }
                
            $obj_pantalla = pantalla::find($request->txtid);    
            $obj_pantalla->nombre_pantalla=$request->txtNombre;
            $obj_pantalla->titulo_pantalla = str_replace(' ', '', $request->txtNombre);        
            $obj_pantalla->url_pantalla=$request->txtUrl;
            $obj_pantalla->padre = $request->txtPadre;
            $obj_pantalla->estado_pantalla = $estado;
            $obj_pantalla->save();
            return redirect(route('pantalla.index'))->withErrors(['status' => "Se ha editado la pantalla" ]);
        }
        
              
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);      
    }

    public function pantallaSave(Request $request){
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        
        if(Auth::user()->accesoRuta('/roles/pantalla/0')){            
            
            
            
            $rol = Rol::find($request->txtid);
            $rol->pantallas()->sync($request->pantallas_id);
            
            
            
            return redirect()->back()->withErrors(['status' => "El rol se modifico correctamente" ]);
        }
        
            
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function delete($id){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        
        if(Auth::user()->accesoRuta('/pantalla/delete')){  
            
            $pantalla = pantalla::find($id);         
            

            $pantalla->delete();
            
            
            return redirect()->back()->withErrors(['status' => "El elimino la pantalla correctamente" ]);
        }
        
            
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

    }
}
