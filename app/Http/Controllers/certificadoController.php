<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\consulta;
use App\Models\certificado;

use Illuminate\Http\Request;
use Session;

class certificadoController extends Controller
{
    public function insert(Request $request){    
    
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }
        
        if(Auth::user()->accesoRuta('/certificado/create')){

            $numero = certificado::ultimo();
                       
            $certificado = new certificado();
            $certificado->numero = $numero;
            $certificado->consulta_id = $request->txtId;
            $certificado->fecha_certificado = $request->fecha_certificado;
            $certificado->save();
 
            
            return redirect()->back()->withErrors(['status' => "Se creo la constancia correctamente." ]);
        }
        
              
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);            
        
        
    }

    public function print($id){
        
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/certificado/imprimir')){

            $consulta = consulta::find($id);
            
            $numero = certificado::max('numero');

            $fecha_certificado = certificado::where('numero', $numero)->value('fecha_certificado');

            $firmaPath = public_path("img/firmas/{$consulta->doctor->nombre_usuario}.PNG");
            $selloPath = public_path("img/sellos/{$consulta->doctor->nombre_usuario}.PNG");

            
            $firmaExiste = File::exists($firmaPath);
            $selloExiste = File::exists($selloPath);

            $pdf = \PDF::loadView('consulta.certificadoPdf', [
                'consulta' => $consulta,
                'numero' => $numero,
                'fecha' => $fecha_certificado,
                'firma' => $firmaExiste,
                'sello' => $selloExiste
            ])->setPaper([0, 0, 595.2756,  419.5276]);

            $nombreArchivo = 'Certificado '.$consulta->paciente->identificacion_paciente.'.pdf';
            return $pdf->stream($nombreArchivo);
            

            
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

        


    }
}
