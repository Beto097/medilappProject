<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\receta;
use App\Models\consulta;


use Session;

class recetaController extends Controller
{

    public function recetaSave(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/receta/create')){

            // Validar que todos los arrays tengan datos y la misma longitud
            $txtTipo = $request->txtTipo ?? [];
            $txtMedicamento = $request->txtMedicamento ?? [];
            $txtDosis = $request->txtDosis ?? [];
            $txtCantidad = $request->txtCantidad ?? [];
            $txtTratamiento = $request->txtTratamiento ?? [];

            // Verificar que todos los arrays tengan la misma longitud
            $expectedCount = count($txtCantidad);
            if (count($txtTipo) !== $expectedCount || 
                count($txtMedicamento) !== $expectedCount || 
                count($txtDosis) !== $expectedCount || 
                count($txtTratamiento) !== $expectedCount) {
                
                return back()->with('error', 'Error en los datos del formulario. Todos los campos son requeridos.');
            }

            // Verificar que no haya campos vacíos
            for ($i = 0; $i < $expectedCount; $i++) {
                if (empty($txtTipo[$i]) || empty($txtMedicamento[$i]) || 
                    empty($txtDosis[$i]) || empty($txtCantidad[$i]) || 
                    empty($txtTratamiento[$i])) {
                    
                    return back()->with('error', 'Todos los campos de la receta son requeridos.');
                }
            }

            $numeroBase = receta::ultimaReceta();
            // Agrupar datos por tipo de dosis
            $data = [];
            for ($i = 0; $i < $expectedCount; $i++) {
                $tipo = $txtTipo[$i];
                $data[$tipo][] = [
                    'cantidad' => $txtCantidad[$i],
                    'medicamento' => $txtMedicamento[$i],
                    'tipo' => $tipo,
                    'dosis' => $txtDosis[$i],
                    'tratamiento' => $txtTratamiento[$i],
                ];
            }
            $contadorGlobal = $numeroBase;
            // Procesar cada grupo de dosis
            foreach ($data as $grupoTipo) {
                $grupoCount = count($grupoTipo);
                for ($i = 0; $i < $grupoCount; $i++) {
                    // Cada 2 elementos se incrementa el número
                    $numeroAsignado = $contadorGlobal + intdiv($i, 2);

                    $receta = new receta();
                    $receta->cantidad = $grupoTipo[$i]['cantidad'];
                    $receta->medicamento = $grupoTipo[$i]['medicamento'];
                    $receta->tipo = $grupoTipo[$i]['tipo'];
                    $receta->dosis = $grupoTipo[$i]['dosis'];
                    $receta->tratamiento = $grupoTipo[$i]['tratamiento'];
                    $receta->consulta_id = $request->txtIdConsulta;
                    $receta->numero = $numeroAsignado;
                    $receta->save();
                }

                // Incrementar el contador global al final de cada grupo
                $contadorGlobal += intdiv($grupoCount + 1, 2); // Redondea hacia arriba cada 2
            }
   
   
           

            return redirect()->back()->withErrors(['status' => "Se ha creado correctamente la receta"]);
            
            

            
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
        


    }

    public function edit(Request $request){
  
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }


        if(Auth::user()->accesoRuta('/receta/create')){
            
            receta::where('consulta_id',$request->txtIdConsulta)->delete();

            // Validar que todos los arrays tengan datos y la misma longitud
            $txtTipo = $request->txtTipo ?? [];
            $txtMedicamento = $request->txtMedicamento ?? [];
            $txtDosis = $request->txtDosis ?? [];
            $txtCantidad = $request->txtCantidad ?? [];
            $txtTratamiento = $request->txtTratamiento ?? [];

            // Si no hay datos, retornar con éxito (todos los elementos fueron eliminados)
            if (empty($txtCantidad)) {
                return redirect()->back()->withErrors(['status' => "Se ha actualizado correctamente la receta"]);
            }

            // Verificar que todos los arrays tengan la misma longitud
            $expectedCount = count($txtCantidad);
            if (count($txtTipo) !== $expectedCount || 
                count($txtMedicamento) !== $expectedCount || 
                count($txtDosis) !== $expectedCount || 
                count($txtTratamiento) !== $expectedCount) {
                
                return back()->with('error', 'Error en los datos del formulario. Todos los campos son requeridos.');
            }

            // Verificar que no haya campos vacíos
            for ($i = 0; $i < $expectedCount; $i++) {
                if (empty($txtTipo[$i]) || empty($txtMedicamento[$i]) || 
                    empty($txtDosis[$i]) || empty($txtCantidad[$i]) || 
                    empty($txtTratamiento[$i])) {
                    
                    return back()->with('error', 'Todos los campos de la receta son requeridos.');
                }
            }

            $numeroBase = receta::ultimaReceta();
            // Agrupar datos por tipo de dosis
            $data = [];

            for ($i = 0; $i < $expectedCount; $i++) {
                $tipo = $txtTipo[$i];
                $data[$tipo][] = [
                    'cantidad' => $txtCantidad[$i],
                    'medicamento' => $txtMedicamento[$i],
                    'tipo' => $tipo,
                    'dosis' => $txtDosis[$i],
                    'tratamiento' => $txtTratamiento[$i],
                ];
            }
            $contadorGlobal = $numeroBase;
            // Procesar cada grupo de dosis
            foreach ($data as $grupoTipo) {
                $grupoCount = count($grupoTipo);
                for ($i = 0; $i < $grupoCount; $i++) {
                    // Cada 2 elementos se incrementa el número
                    $numeroAsignado = $contadorGlobal + intdiv($i, 2);

                    $receta = new receta();
                    $receta->cantidad = $grupoTipo[$i]['cantidad'];
                    $receta->medicamento = $grupoTipo[$i]['medicamento'];
                    $receta->tipo = $grupoTipo[$i]['tipo'];
                    $receta->dosis = $grupoTipo[$i]['dosis'];
                    $receta->tratamiento = $grupoTipo[$i]['tratamiento'];
                    $receta->consulta_id = $request->txtIdConsulta;
                    $receta->numero = $numeroAsignado;
                    $receta->save();
                }

                // Incrementar el contador global al final de cada grupo
                $contadorGlobal += intdiv($grupoCount + 1, 2); // Redondea hacia arriba cada 2
            }
   
           

            return redirect()->back()->withErrors(['status' => "Se ha actualizado correctamente la receta"]);

            
           
            
        }
    

        
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

        


    }

    public function print($id){
        
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/receta/imprimir')){

            $consulta = consulta::with('recetas')->find($id);
            
            $grupos = $consulta->recetas->groupBy('numero');
            $firmaPath = public_path("img/firmas/{$consulta->doctor->nombre_usuario}.PNG");
            $selloPath = public_path("img/sellos/{$consulta->doctor->nombre_usuario}.PNG");

            
            $firmaExiste = File::exists($firmaPath);
            $selloExiste = File::exists($selloPath);

            $pdf = \PDF::loadView('consulta.pdf', [
                'consulta' => $consulta,
                'grupos' => $grupos,
                'firma' => $firmaExiste,
                'sello' => $selloExiste
            ])->setPaper([0, 0, 419.5276, 595.2756]);

            $nombreArchivo = $consulta->paciente->identificacion_paciente.'.pdf';
            return $pdf->stream($nombreArchivo);
            
            return redirect()->back()->withErrors(['status' => "Se imprimio correctamente la receta"]);
            
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

        


    }

    public function printCompleto($id){
        
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/receta/imprimir')){

            $consulta = consulta::with('recetas')->find($id);
            
            $grupos = $consulta->recetas->groupBy('numero');
            $firmaPath = public_path("img/firmas/{$consulta->doctor->nombre_usuario}.PNG");
            $selloPath = public_path("img/sellos/{$consulta->doctor->nombre_usuario}.PNG");

            
            $firmaExiste = File::exists($firmaPath);
            $selloExiste = File::exists($selloPath);

            $pdf = \PDF::loadView('consulta.pdfCompleto', [
                'consulta' => $consulta,
                'grupos' => $grupos,
                'firma' => $firmaExiste,
                'sello' => $selloExiste
            ])->setPaper('letter', 'landscape');

            $nombreArchivo = 'Receta Completa '.$consulta->paciente->identificacion_paciente.'.pdf';
            return $pdf->stream($nombreArchivo);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }
    public function buscarMedicamento(Request $request)
    {
        $term = $request->get('term');

        $medicamentos = Receta::where('nombre', 'LIKE', '%' . $term . '%')
            ->distinct()
            ->orderBy('nombre')
            ->pluck('nombre');

        return response()->json($medicamentos);
    }

    public function printOld($id){

        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/receta/imprimir')){
            
            $consulta = consulta::with('recetas')->find($id);
            
            $grupos = $consulta->recetas->groupBy('numero');
            $firmaPath = public_path("img/firmas/{$consulta->doctor->nombre_usuario}.PNG");
            $selloPath = public_path("img/sellos/{$consulta->doctor->nombre_usuario}.PNG");

            $firma = File::exists($firmaPath);
            $sello = File::exists($selloPath);

            $pdf = \PDF::loadView('consulta.pdfOld', compact('grupos', 'consulta', 'firma', 'sello'));
            $pdf->setPaper([0, 0, 612, 792], 'landscape'); // 8.5x11 inches landscape

            return $pdf->stream('receta-old-'.$consulta->id.'.pdf');
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }


}
