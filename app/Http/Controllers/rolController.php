<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\rol;

use Session;

class rolController extends Controller
{
    public function index(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/rol')){
                        
            if (Auth::user()->rol->tipo_rol == 1) {

                $resultado = rol::get(); 

            } else {

                $resultado=ral::where('estado_pantalla',1)->get();
        
            }
            
            return view ("rol.index", ["resultado"=>$resultado]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function create(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/rol/create')){                        
           
            
            return view ("rol.create");
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function insert(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/rol/create')){
            
           
            if($request->txtTipo == 1){
                $tipo =1;
            }else{
                $tipo=0;
            }

            $existe = rol::where('nombre_rol',$request->txtNombre)->count();

            if($existe>0){

                return redirect()->back()->withInput()->withErrors(['danger' => "Ya existe el rol" ]);
            }
                
            $rol = new rol();   
            $rol->nombre_rol = $request->txtNombre;
            $rol->estado_rol = '1';
            $rol->tipo_rol = $tipo;
    
            $rol->save();
            return redirect(route('rol.index'))->withErrors(['status' => "Se ha creado el rol correctamente" ]);
        }
        
              
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);            
        
        
    }

    public function delete($id){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/rol/delete')){                        
           
            $rol = rol::find($id);
            $rol->delete();
                
            return redirect(route('rol.index'))->withErrors(['status' => "Se ha eliminado el rol correctamente" ]);
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

}
