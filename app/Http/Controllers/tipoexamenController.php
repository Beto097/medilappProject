<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\usuario;
use App\Models\tipo_examen;
use Illuminate\Support\Facades\DB;
use Session; 

class tipoexamenController extends Controller
{

    public function index(){
        
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/tipoexamen')){

            $resultado = tipo_examen::where('estado_tipo_examen',1)->get();                 
            return view ("tipo_examen.index", ["resultado"=>$resultado]);

        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
       
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
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/tipoexamen/create')){
                
                $obj_tipo_examen = new tipo_examen();
                $obj_tipo_examen->nombre_tipo_examen = $request->txttipoexamen;  
        
        
                $obj_tipo_examen->save();
                return redirect(route('tipoexamen.index'))->withErrors(['status' => "Se creó el tipo de examen: "]);
    
            }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
           


        
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
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/tipoexamen/update')){
            //esto ya estaba
            $obj_tipo_examen = tipo_examen::find($request->txtId);
            $obj_tipo_examen->nombre_tipo_examen = $request->txttipoexamen;
            $obj_tipo_examen->save();
            return redirect(route('tipoexamen.index'))->withErrors(['status' => "Se ha actualizado el tipo de examen" ]);

        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
        

    }

    public function delete($id){
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/tipoexamen/delete')){
            //esto ya estaba
            $obj = tipo_examen::find($id);
            $obj->estado_tipo_examen =0;
            $obj->save();
            return redirect (route("tipoexamen.index"));
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
       
    }
    
    public function desbloquear($id){
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/tipoexamen/delete')){
            //esto ya estaba
            $obj = tipo_examen::find($id);
            $obj->estado_tipo_examen =1;
            $obj->save();
            return redirect (route("tipoexamen.index"));
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
            
        

    }

    
}
