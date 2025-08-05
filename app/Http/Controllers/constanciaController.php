<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use App\Models\consulta;
use App\Models\constancia;

use Illuminate\Http\Request;

use Session;

class constanciaController extends Controller
{
    public function insert(Request $request){    
    
    if (!Auth::user()) {
        return response()->json(['success' => false, 'error' => 'No autenticado'], 401);
    }
    
    if(Auth::user()->accesoRuta('/constancia/create')){
        try {
            // Log para debug
            \Log::info('Datos recibidos para constancia:', $request->all());
            
            // Validar los datos de entrada
            $validatedData = $request->validate([
                'txtId' => 'required|numeric|exists:consulta,id',
                'hora_inicio' => 'required',
                'hora_fin' => 'required', 
                'fecha_constancia' => 'required|date'
            ]);
            
            \Log::info('Validación exitosa:', $validatedData);

            $constancia = constancia::where('consulta_id', $request->txtId)->first();

            if (!$constancia) {
                $constancia = new constancia();
            }

            $constancia->consulta_id = $request->txtId;
            $constancia->hora_inicio = $request->hora_inicio;
            $constancia->hora_fin = $request->hora_fin;
            $constancia->fecha = $request->fecha_constancia;
            
            \Log::info('Guardando constancia:', $constancia->toArray());
            $constancia->save();

            // Generar la URL del PDF
            $pdf_url = route('constancia.print', ['id' => $request->txtId]);

            return response()->json([
                'success' => true,
                'pdf_url' => $pdf_url
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación:', $e->errors());
            return response()->json([
                'success' => false, 
                'error' => 'Error de validación: ' . json_encode($e->errors())
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error en constancia insert:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false, 
                'error' => 'Error al crear la constancia: ' . $e->getMessage()
            ], 500);
        }
    }

    return response()->json(['success' => false, 'error' => 'No tienes acceso a esta funcion.'], 403);
}

    public function print($id){
        
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/constancia/imprimir')){

            $consulta = consulta::find($id);
            
            if (!$consulta) {
                return redirect()->back()->withErrors(['danger' => "No se encontró la consulta especificada."]);
            }
            
            $constancia = constancia::where('consulta_id', $id)->first();
            
            if (!$constancia) {
                return redirect()->back()->withErrors(['danger' => "No se encontró una constancia para esta consulta. Debe crear la constancia primero."]);
            }
            
            $firmaPath = public_path("img/firmas/{$consulta->doctor->nombre_usuario}.PNG");
            $selloPath = public_path("img/sellos/{$consulta->doctor->nombre_usuario}.PNG");

            
            $firmaExiste = File::exists($firmaPath);
            $selloExiste = File::exists($selloPath);

            $pdf = \PDF::loadView('consulta.constanciaPdf', [
                'consulta' => $consulta,
                'constancia' => $constancia,
                'firma' => $firmaExiste,
                'sello' => $selloExiste
            ])->setPaper([0, 0, 595.2756,  419.5276]);

            $nombreArchivo = 'Constancia '.$consulta->paciente->identificacion_paciente.'.pdf';
            return $pdf->stream($nombreArchivo);
            

            
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

        


    }
}
