<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\referencia;
use App\Models\consulta;
use Carbon\Carbon;

use Session;

class referenciaController extends Controller
{
    public function insert(Request $request){    
    
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }
        
        if(Auth::user()->accesoRuta('/referencia/create')){
                       
            // Obtienes todos los datos
            $data = $request->except('_token','txtId');

            
            // Eliminas los campos vacíos (null o strings vacíos)
            $filtered = array_filter($data, function ($value) {
                return $value !== null && $value !== '';
            });

            $referencia = referencia::where('consulta_id', $request->txtId)->first();

            if (!$referencia) {
                $referencia = new referencia();
            }

            $referencia->datos = $filtered;
            $referencia->consulta_id = $request->txtId;
            $referencia->save();
 
            
            return redirect()->back()->withErrors(['status' => "Se creo la referencia correctamente." ]);   
        }
        
              
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);            
        
        
    }

    public function print($id){        

    
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        // if(Auth::user()->accesoRuta('/referencia/create')){
                       
            $consulta = consulta::find($id);      
            
            $fecha = Carbon::now(); // o cualquier fecha que tengas

            $fechaDividida = [
                'dia'    => $fecha->format('d'),
                'mes'    => $fecha->format('m'),
                'anio'   => $fecha->format('Y'),
                'hora'   => $fecha->format('H'),
                'minuto' => $fecha->format('i'),
            ];

            $firmaPath = public_path("img/firmas/{$consulta->doctor->nombre_usuario}.PNG");
            $selloPath = public_path("img/sellos/{$consulta->doctor->nombre_usuario}.PNG");

            
            $firmaExiste = File::exists($firmaPath);
            $selloExiste = File::exists($selloPath);

            $pdf = \PDF::loadView('consulta.referenciaPdf', [
                'consulta' => $consulta,  
                'fecha'=>$fechaDividida,             
                'firma' => $firmaExiste,
                'sello' => $selloExiste
            ])->setPaper([0, 0, 595.28,841.89]);

            $nombreArchivo = $consulta->paciente->identificacion_paciente.'.pdf';
            return $pdf->stream($nombreArchivo);
        // }
        
              
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);            
        
        
    }
}
