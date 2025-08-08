<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\examen;
use App\Models\tipo_examen;
use App\Models\paciente;
use App\Models\resultado;
use App\Models\ordenlaboratorio;
use App\Models\rol;
use App\Models\User;
use App\Models\notificacion;
use App\Models\medico;
use App\Models\pantalla;
use App\Models\rol_pantalla;
use App\Models\caracteristica_examen;
use App\Models\examen_orden_laboratorio;
use App\Models\examen_caracteristica_examen;
use App\Notifications\ordenTerminada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\ResultadoLaboratorio;
use Session;

class resultadoController extends Controller
{
    public function index(){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio')){
            
            if (Auth::user()->rol->tipo_rol == 1) {
                $resultado = ordenlaboratorio::with(['paciente', 'usuario', 'medico'])
                                           ->where('estado_orden_laboratorio','<>','Eliminado')
                                           ->where('created_at', '>=', Carbon::now()->subDays(30))
                                           ->orderBy('id','DESC')
                                           ->get();
            } else {
                $resultado = ordenlaboratorio::with(['paciente', 'usuario', 'medico'])
                                           ->where('estado_orden_laboratorio','<>','Eliminado')
                                           ->orderBy('id','DESC')
                                           ->get();
            }

            $numero_exam = examen_orden_laboratorio::where('padre','<=',0)
                                        ->groupBy('ordenlaboratorio_id')
                                        ->selectRaw('count(*) as total, ordenlaboratorio_id')
                                        ->get();
            $numero_examenes = [];
            foreach($numero_exam as $examen){
                $numero_examenes[$examen->ordenlaboratorio_id] = $examen->total;
            } 

            $rol = rol::where('nombre_rol','like','laboratorio%')->first();
            $externos = collect();
            
            if ($rol) {
                $externos = User::where('rol_id', $rol->id)->get();
            }
            
            return view('resultado.index', [
                "resultado" => $resultado,
                "numero_examenes" => $numero_examenes,
                "externos" => $externos
            ]);
        }
        
        return redirect(route('index'));
    }

    public function historial(){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio')){
            
            $resultado = ordenlaboratorio::with(['paciente', 'usuario', 'medico'])
                                       ->where('estado_orden_laboratorio','<>','Eliminado')
                                       ->orderBy('id','DESC')
                                       ->get();

            $numero_exam = examen_orden_laboratorio::where('padre','<=',0)
                                        ->groupBy('ordenlaboratorio_id')
                                        ->selectRaw('count(*) as total, ordenlaboratorio_id')
                                        ->get();
            $numero_examenes = [];
            foreach($numero_exam as $examen){
                $numero_examenes[$examen->ordenlaboratorio_id] = $examen->total;
            } 

            $rol = rol::where('nombre_rol','like','laboratorio%')->first();
            $externos = collect();
            
            if ($rol) {
                $externos = User::where('rol_id', $rol->id)->get();
            }
            
            return view('resultado.index', [
                "resultado" => $resultado,
                "numero_examenes" => $numero_examenes,
                "externos" => $externos
            ]);
        }
        
        return redirect(route('index'));
    }


    public function examenes($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio')){
            
            $orden = ordenlaboratorio::where('id',$id)
                                   ->where('estado_orden_laboratorio','<>','Eliminado')
                                   ->first();

            if(!$orden){
                return redirect(route('resultado.index'))
                    ->withErrors(['status' => "La orden no existe o fue eliminada"]);
            }

            // Verificar permisos adicionales para usuarios externos/pacientes
            if (Auth::user()->rol->tipo_rol == 2) {
                if (Auth::user()->rol->nombre_rol == 'Paciente') {
                    $paciente = paciente::where('identificacion_paciente', Auth::user()->name)->first();
                    if(!$paciente || $orden->paciente_id != $paciente->id){
                        return redirect()->back();
                    }
                } else {
                    if($orden->externo_id != Auth::id()){
                        return redirect()->back();
                    }
                }
            }
            
            $resultado = examen_orden_laboratorio::where('ordenlaboratorio_id',$id)
                                                ->where('padre','<',1)
                                                ->get();
            
            $lista_examen = array();
            foreach($resultado as $resul){
                array_push($lista_examen,$resul->examen_id);
            }
            
            $examenes = examen::whereIn('id',$lista_examen)->get();
            
            $lista_examenes = array();
            foreach($examenes as $examen){
                if($examen->es_externo==0){
                    array_push($lista_examenes,$examen->tipo_examen_id);
                }
            }
            
            $lista_tipo = array();
            foreach(array_unique($lista_examenes) as $tipo){
                $i = 0;
                foreach($lista_examenes as $exam){
                    if($exam==$tipo){
                        $i=$i+1;
                    }
                }
                if($i>1){
                    array_push($lista_tipo,$tipo);
                }
            }

            $tipos_examen = tipo_examen::whereIn('id',$lista_tipo)->get();
            
            $count = 0;
            if(sizeof($lista_examenes)==sizeof($lista_tipo)){
                $count = 1;
            }
                               
            return view('resultado.examenes', [
                "resultado" => $resultado,
                "orden" => $orden,
                "tipos_examen" => $tipos_examen,
                "count" => $count
            ]);
        }
        
        return redirect(route('index'));
    }
    
    public function eliminarExamen($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/delete')){
            $examen = examen_orden_laboratorio::find($id);
            
            if ($examen) {
                $examen->delete();
                return redirect()->back()->with('success', 'El examen fue eliminado');
            }
            
            return redirect()->back()->withErrors(['error' => 'Examen no encontrado']);
        }
        
        return redirect(route('index'));
    }

    public function resultados($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/resultado/update')){
            
            $examen_orden = examen_orden_laboratorio::find($id);
            
            if (!$examen_orden) {
                return redirect(route('resultado.index'))
                    ->withErrors(['error' => 'Examen no encontrado']);
            }
            
            $examen = examen::find($examen_orden->examen_id);        
            $orden = ordenlaboratorio::find($examen_orden->ordenlaboratorio_id);
            
            if (!$examen || !$orden) {
                return redirect(route('resultado.index'))
                    ->withErrors(['error' => 'Datos de examen u orden no encontrados']);
            }
            
            // Calcular la edad del paciente
            $paciente = paciente::find($orden->paciente_id);
            if (!$paciente) {
                return redirect(route('resultado.index'))
                    ->withErrors(['error' => 'Paciente no encontrado']);
            }
            
            $fechaHoy = Carbon::parse($orden->fecha_orden);
            $fechaNacimiento = Carbon::parse($paciente->fecha_nacimiento_paciente);
            $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                  
            $caracteristicas = examen_caracteristica_examen::where('examen_id',$examen->id)
                                                         ->orderBy('num_orden')
                                                         ->get();
                                                         
            return view('resultado.resultados', [
                "examen_orden" => $examen_orden,
                "orden" => $orden,
                "examen" => $examen,
                "edad_paciente" => $edad_paciente,
                'caracteristicas' => $caracteristicas
            ]);
        }
        
        return redirect(route('index'));
    }
    public function resultados1($id){
        if (Session::has('usuario_rol_id')) {
            $pantallas_menu = Controller::urlsPantallasXUsuario();
            
            if (in_array('/resultado/update',$pantallas_menu)){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                
                $examen_orden = examen_orden_laboratorio::find($id);
                $examen = examen::find($examen_orden->examen_id);        
                $orden = orden_laboratorio::find($examen_orden->orden_laboratorio_id);
                
                //calcular la edad del paciente;
                $paciente = paciente::find($orden->paciente_id);
                $fechaHoy = Carbon::parse(date($orden->fecha_orden));
                $fechaNacimiento = Carbon::parse(date($paciente->fecha_nacimiento_paciente));
                $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
                $examenes = examen_orden_laboratorio::where('orden_laboratorio_id',$orden->id)->where('padre',$examen->id)->get();
                $lista_caracteristicas = array();
                
                foreach($examenes as $fila){
                    array_push($lista_caracteristicas, $fila->examen_id);
                }  
                
                $caracteristicas = examen_caracteristica_examen::whereIn('examen_id',$lista_caracteristicas)->orderBy('num_orden')->get();
                
                return view('resultado.resultados', ["examen_orden"=>$examen_orden,"orden"=>$orden,"examen"=>$examen,"edad_paciente"=>$edad_paciente,'caracteristicas'=>$caracteristicas]);

            }
            
              
            return redirect(route('index'));
            
        }else{
            return redirect(route('login.index'));
        }
        
    }

    public function insertarResultados(Request $request){         
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/resultado/insert')){
            
            $resultado = $request->valores;
            
            foreach($request->caracteristica_id as $caracteristica){
                
                $obj_resultado = new resultado();
                $obj_resultado->caracteristica_examen_id = $caracteristica;
                $valor_resultado = $resultado[$caracteristica];
                $valor_resultado = str_replace("<","	&lt;",$valor_resultado);
                $valor_resultado = str_replace(">","	&gt;",$valor_resultado);
                $valor_resultado = str_replace("↑",'<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',$valor_resultado);
                $valor_resultado = str_replace("↓",'<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',$valor_resultado);
                $obj_resultado->valor =  nl2br($valor_resultado);
                $obj_resultado->examen_orden_laboratorio_id = $request->txtExamenOrdenLaboratorioId;
                $obj_resultado->save();
            }

            $examen_orden = examen_orden_laboratorio::find($request->txtExamenOrdenLaboratorioId);
            
            if (!$examen_orden) {
                return redirect()->back()->withErrors(['error' => 'Examen no encontrado']);
            }
            
            $examen_orden->estado_examen = "Terminado";
            if (isset($request->txtObservaciones)) {
                $examen_orden->datos = $request->txtObservaciones;
            }
            $examen_orden->save(); 
            
            $examenes_total = examen_orden_laboratorio::where('ordenlaboratorio_id',$examen_orden->ordenlaboratorio_id)
                                                    ->where('padre','<=',0)
                                                    ->count();
            $examenes_terminados = examen_orden_laboratorio::where('ordenlaboratorio_id',$examen_orden->ordenlaboratorio_id)
                                                         ->where('padre','<=',0)
                                                         ->where('estado_examen','Terminado')
                                                         ->count();
            
            $orden_laboratorio = ordenlaboratorio::find($examen_orden->ordenlaboratorio_id);
            
            if (!$orden_laboratorio) {
                return redirect()->back()->withErrors(['error' => 'Orden de laboratorio no encontrada']);
            }
            
            if($examenes_total == $examenes_terminados){
                $orden_laboratorio->estado_orden_laboratorio = "Terminado";
                $orden_laboratorio->save();
                
                // Notificación al paciente
                $notificacion['orden_id'] = $orden_laboratorio->id;
                $notificacion['mensaje'] = 'La orden de laboratorio N° '.$orden_laboratorio->id.' está terminada';
                              
                // Buscar usuario paciente por identificación
                $paciente_user = User::where('name', $orden_laboratorio->paciente->identificacion_paciente)->first();
                if ($paciente_user) {
                    $paciente_user->notify(new ordenTerminada($notificacion));
                }
                
                // Notificar a usuario externo si aplica
                if($orden_laboratorio->esExterno == 1 && $orden_laboratorio->externo_id){
                    $externo_user = User::find($orden_laboratorio->externo_id);
                    if ($externo_user) {
                        $externo_user->notify(new ordenTerminada($notificacion));
                    }
                }
                
            } else {
                $orden_laboratorio->estado_orden_laboratorio = "En Proceso";
                $orden_laboratorio->save();
            }

            return redirect(route('ordenLaboratorio.examenes', ['id' => $examen_orden->ordenlaboratorio_id]))
                ->with('success', 'Se guardaron los resultados del examen');
        }
        
        return redirect(route('index'));
    }

    public function verResultados($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio')){
            $examen_orden = examen_orden_laboratorio::find($id);
            
            if (!$examen_orden) {
                return redirect(route('resultado.index'))
                    ->withErrors(['error' => 'Examen no encontrado']);
            }
            
            $this->eliminarDuplicados($examen_orden->id);
            $resultados = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->get();
            $examen = examen::find($examen_orden->examen->id);      
            $orden = ordenlaboratorio::find($examen_orden->ordenlaboratorio_id);
            
            if (!$examen || !$orden) {
                return redirect(route('resultado.index'))
                    ->withErrors(['error' => 'Datos de examen u orden no encontrados']);
            }
            
            // Calcular la edad del paciente
            $paciente = paciente::find($orden->paciente_id);
            if (!$paciente) {
                return redirect(route('resultado.index'))
                    ->withErrors(['error' => 'Paciente no encontrado']);
            }
            
            $fechaHoy = Carbon::parse($orden->fecha_orden);
            $fechaNacimiento = Carbon::parse($paciente->fecha_nacimiento_paciente);
            $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
        
            return view('resultado.verResultados', [
                "examen_orden" => $examen_orden,
                "examen" => $examen,
                "orden" => $orden,
                "resultados" => $resultados,
                "edad_paciente" => $edad_paciente
            ]);
        }
        
        return redirect(route('index'));
    }

    public function eliminarDuplicados($id){
        $duplicados = resultado::where('examen_orden_laboratorio_id',$id)
                              ->groupBy('caracteristica_examen_id')
                              ->select('caracteristica_examen_id', DB::raw('count(*) as total'))
                              ->having('total', '>' , 1)
                              ->get();

        foreach ($duplicados as $duplicado) {
            $resultado = resultado::where('examen_orden_laboratorio_id',$id)
                                ->where('caracteristica_examen_id',$duplicado->caracteristica_examen_id)
                                ->orderBy('id','DESC')
                                ->first();
            if ($resultado) {
                $resultado->delete();
            }
        }               
    }

    public function update($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/resultado/update')){
            $examen_orden = examen_orden_laboratorio::find($id);
            
            if (!$examen_orden) {
                return redirect(route('resultado.index'))
                    ->withErrors(['error' => 'Examen no encontrado']);
            }
            
            $this->eliminarDuplicados($examen_orden->id);
            $examen = examen::find($examen_orden->examen_id);        
            $orden = ordenlaboratorio::find($examen_orden->ordenlaboratorio_id);
            
            if (!$examen || !$orden) {
                return redirect(route('resultado.index'))
                    ->withErrors(['error' => 'Datos de examen u orden no encontrados']);
            }
            
            // Calcular la edad del paciente
            $paciente = paciente::find($orden->paciente_id);
            if (!$paciente) {
                return redirect(route('resultado.index'))
                    ->withErrors(['error' => 'Paciente no encontrado']);
            }
            
            $fechaHoy = Carbon::parse($orden->fecha_orden);
            $fechaNacimiento = Carbon::parse($paciente->fecha_nacimiento_paciente);
            $edad_paciente = $fechaHoy->diffInYears($fechaNacimiento);
            $resultados = resultado::where('examen_orden_laboratorio_id',$examen_orden->id)->get(); 
            
            // Limpiar valores para edición
            foreach($resultados as $resultado){
                $valor = $resultado->valor;
                $valor = str_replace("<br />","",$valor);
                $valor = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',"↓",$valor);
                $valor = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',"↑",$valor);
                $valor = str_replace('&lt;',"<",$valor);
                $valor = str_replace('&gt;',">",$valor);
                
                $resultado->valor = $valor;
                
                if ($resultado->caracteristica_examen) {
                    $referencia = $resultado->caracteristica_examen->valor_referencia_caracteristica_examen;
                    $referencia = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',"↓",$referencia);
                    $referencia = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',"↑",$referencia);
                    $referencia = str_replace('&lt;',"<",$referencia);
                    $referencia = str_replace('&gt;',">",$referencia);
                    $resultado->caracteristica_examen->valor_referencia_caracteristica_examen = $referencia;
                }
            }
            
            return view('resultado.update', [
                "resultados" => $resultados,
                "examen_orden" => $examen_orden,
                "orden" => $orden,
                "examen" => $examen,
                "edad_paciente" => $edad_paciente
            ]);
        }
        
        return redirect(route('index'));
    }

    public function save(Request $request){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/resultado/update')){
            $resultado = $request->valores;
            
            foreach($request->resultado_id as $result){
                $obj_resultado = resultado::find($result);   
                
                if ($obj_resultado) {
                    $valor_resultado = $resultado[$result];
                    $valor_resultado = str_replace("<","	&lt;",$valor_resultado);
                    $valor_resultado = str_replace(">","	&gt;",$valor_resultado);
                    $valor_resultado = str_replace("↑",'<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',$valor_resultado);
                    $valor_resultado = str_replace("↓",'<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',$valor_resultado);
                    $obj_resultado->valor = nl2br($valor_resultado);            
                    $obj_resultado->save();
                }
            }
    
            $examen_orden = examen_orden_laboratorio::find($request->txtExamenOrdenLaboratorioId);
            
            if ($examen_orden) {
                $examen_orden->datos = $request->txtObservaciones;
                $examen_orden->save(); 
                
                $examenes_total = examen_orden_laboratorio::where('ordenlaboratorio_id',$examen_orden->ordenlaboratorio_id)->count();
                $examenes_terminados = examen_orden_laboratorio::where('ordenlaboratorio_id',$examen_orden->ordenlaboratorio_id)
                                                            ->where('estado_examen','Terminado')
                                                            ->count();
                
                $orden_laboratorio = ordenlaboratorio::find($examen_orden->ordenlaboratorio_id);
                if ($orden_laboratorio && $examenes_total == $examenes_terminados) {
                    $orden_laboratorio->estado_orden_laboratorio = "Terminado";
                    $orden_laboratorio->save();
                }
        
                return redirect(route('ordenLaboratorio.examenes', ['id' => $examen_orden->ordenlaboratorio_id]))
                    ->with('success', 'Se actualizaron los resultados del examen');
            }
        }
        
        return redirect(route('index'));
    }
}
