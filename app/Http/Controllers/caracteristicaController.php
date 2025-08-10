<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\caracteristica_examen;
use Illuminate\Support\Facades\DB;
use Session;

class caracteristicaController extends Controller
{
    public function index(){
        

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/caracteristicaExamen')){
            //esto ya estaba
            
            $resultado = caracteristica_examen::where('estado_caracteristica_examen',1)->get();
            
            $valores_referencia = array();
            foreach ($resultado as $caracteristica) {
                $valores_referencia[$caracteristica->id] = str_replace("<br />","",$caracteristica->valor_referencia_caracteristica_examen );
            }
            return view ("caracteristica_examen.index", ["resultado"=>$resultado,"valores_referencia"=>$valores_referencia]);

        }
        
            
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
        
    }

 



    public function insert(Request $request){
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/caracteristicaExamen/create')){
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

            return redirect()->back()->withErrors(['status' => "Se creó la caracteristica " .$obj_caracteristica_examen->nombre_caracteristica_examen ]);

        }
    
        
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
        
    }



    public function save(Request $request){
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/caracteristicaExamen/update')){

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
            return redirect()->back()->withErrors(['status' => "Se ha guardado la caracteristica ".$obj_caracteristica_examen->nombre_caracteristica_examen ]);

        }

    
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    

    }

   

    public function delete($id){
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/caracteristicaExamen/delete')){
            $obj_caracteristica_examen = caracteristica_examen::find($id);

            $obj_caracteristica_examen->estado_caracteristica_examen = 0;
            $obj_caracteristica_examen->save();
            return redirect()->back()->withErrors(['danger' => "Se elimino la caracteristica ".$obj_caracteristica_examen->nombre_caracteristica_examen ]);

        }


        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    
       

    }

    
    public function desbloquear($id){
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/caracteristicaExamen/delete')){
            $obj_caracteristica_examen = caracteristica_examen::find($id);

            $obj_caracteristica_examen->estado_caracteristica_examen = 1;
            $obj_caracteristica_examen->save();
            return redirect()->back()->withErrors(['danger' => "Se agregar la caracteristica ".$obj_caracteristica_examen->nombre_caracteristica_examen ]);

        }


        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    
       
        
    }

    
}
