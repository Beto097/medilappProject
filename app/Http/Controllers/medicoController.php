<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\medico;

use Session;

class medicoController extends Controller
{
    public function index(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/medico')){
                        
            if (Auth::user()->rol->tipo_rol == 1) {
                $resultado = medico::get();  
            } else {
                $resultado = medico::where('estado_medico',1)->get(); 
            }

            return view ("medico.index", ["resultado"=>$resultado]);
            
        }

        return redirect(route('index'));
    }

    public function consultarRegistro($registro){

        if (!Auth::user()) {

            return 'no tienes acceso';
        }
        $valor= array();
        $existe = medico::where('numero_registro',$registro)->count();
        if($existe ==1){
            $medico = medico::where('numero_registro',$registro)->first();
            $valor= array("registro"=>$registro,"nombre"=>$medico->nombre_medico); 
            
        }

        return $valor;
    }
}
