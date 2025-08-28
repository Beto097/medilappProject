<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ordenlaboratorio;
use App\Models\medico;
use App\Models\paciente;
use App\Models\rol;
use App\Models\examen;
use App\Notifications\notificacionsOrdenes;
use App\Models\tipo_examen;
use App\Models\examen_orden_laboratorio;
use App\Models\sucursal;
use Session; // Agregar 
use Carbon\Carbon;

class ordenLaboratorioController extends Controller
{
    public function index(){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio')){
            
            if (Auth::user()->rol->tipo_rol == 1) {
                $resultado = ordenlaboratorio::get(); 
            } else {
                $resultado = ordenlaboratorio::get()->where('estado_orden_laboratorio','<>','Eliminado'); 
            }
                                
            return view ("ordenLaboratorio.index", ["resultado"=>$resultado]);
        }
        
        return redirect(route('index'));
    }
    public function create(){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/create')){
            
            $rol = rol::where('nombre_rol','like','laboratorio%')->first();
            
            // Inicializar externos como colección vacía por defecto
            $externos = collect();
            
            // Solo buscar usuarios externos si se encuentra el rol
            if ($rol) {
                $externos = User::where('rol_id', $rol->id)->get();
            }
            
            // Obtener sucursales activas para el modal de médicos
            $sucursales = sucursal::where('estado_sucursal', 1)->get();
            
            return view("ordenLaboratorio.create", ['externos' => $externos, 'sucursales' => $sucursales]);
        }           
          
        return redirect(route('index'));
    }
    public function create2($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/create')){
            
            $paciente = paciente::find($id);
            return redirect(route('ordenlaboratorio.create'))->with(['txtCedula'=>$paciente->identificacion_paciente]);
        }
       
        return redirect(route('index'));
    }
    public function insert(Request $request){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/create')){
            
            $txtFecha = Carbon::now()->format('Y-m-d');
            $externo = 0;
            if($request->esExterno){
                $externo = 1;
            }
            
            $paciente = paciente::where('identificacion_paciente',$request->txtCedula)->first();
            $medico = medico::where('numero_registro',$request->txtRegistro)->first();
            
            // Validar que el paciente y médico existen
            if (!$paciente) {
                return redirect()->back()->withErrors(['txtCedula' => 'Paciente no encontrado con la cédula proporcionada.'])->withInput();
            }
            
            if (!$medico) {
                return redirect()->back()->withErrors(['txtRegistro' => 'Médico no encontrado con el número de registro proporcionado.'])->withInput();
            }
            
            $obj_ordenlaboratorio = new ordenlaboratorio();
            $obj_ordenlaboratorio->fecha_orden = $txtFecha;
            $obj_ordenlaboratorio->paciente_id = $paciente->id; 
            $obj_ordenlaboratorio->usuario_id = Auth::id();               
            $obj_ordenlaboratorio->medico_id = $medico->id;
            $obj_ordenlaboratorio->estado_orden_laboratorio = "Pendiente";
            $obj_ordenlaboratorio->esExterno = $externo;
            $obj_ordenlaboratorio->externo_id = $request->selectExterno; 
            $obj_ordenlaboratorio->save();
            $nueva_orden = $obj_ordenlaboratorio->id;

            $tipo_examen = tipo_examen::get();
            $caracteristica_examen = examen::where('estado_examen',1)->get();
            
            // Debug temporal - remover después
            \Log::info('Debug Orden Laboratorio:', [
                'tipo_examen_count' => $tipo_examen->count(),
                'caracteristica_examen_count' => $caracteristica_examen->count(),
                'nueva_orden' => $nueva_orden
            ]);
            
            return view ("ordenLaboratorio.createnext", ["tipo_examen"=>$tipo_examen,"caracteristica_examen"=>$caracteristica_examen, "nueva_orden"=>$nueva_orden]);
        }
        
        return redirect(route('index'));
    }
    public function createnext(Request $request){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/create')){
            
            $conteo = array();
            foreach($request->examenes_id as $examen){
    
                $examen_1= examen::find($examen);
                
                
                if($examen_1->padre>0){
                    if (empty($conteo[$examen_1->padre])) {
                        $obj_orden_examen = new examen_orden_laboratorio ();
                        $obj_orden_examen->ordenlaboratorio_id = $request->txtNueva_Orden;
                        $obj_orden_examen->examen_id = $examen_1->padre;
                        $obj_orden_examen->padre=-1;
                        $obj_orden_examen->estado_examen = "Pendiente";
                        $obj_orden_examen->save();
                    }
                   $conteo[$examen_1->padre] =  1;
                }
                
                $obj_orden_examen = new examen_orden_laboratorio ();
                $obj_orden_examen->ordenlaboratorio_id = $request->txtNueva_Orden;
                $obj_orden_examen->examen_id = $examen;
                $obj_orden_examen->estado_examen = "Pendiente";
                $obj_orden_examen->padre=$examen_1->padre;
                $obj_orden_examen->save();
            
            }

            $ordenlaboratorio = ordenlaboratorio::find($request->txtNueva_Orden);

           
        
            //Enviar notificacionea a usuarios
            $notificacion['orden_id'] = $request->txtNueva_Orden;
            $notificacion['mensaje'] = 'El paciente '.$ordenlaboratorio->paciente->nombre_paciente." ".$ordenlaboratorio->paciente->apellido_paciente.' tiene una nueva orden';
            
            $roles = rol::where('nombre_rol','like','labora%')->get();
            $lista_roles = array();
            
            // Solo procesar si se encontraron roles
            if ($roles->isNotEmpty()) {
                foreach($roles as $rol){
                    array_push($lista_roles,$rol->id);
                }
                
                // Solo enviar notificaciones si hay roles válidos
                if (!empty($lista_roles)) {
                    User::whereIn('rol_id',$lista_roles)                            
                            ->each(function(User $user) use ($notificacion){
                                $user->notify(new notificacionsOrdenes($notificacion));
                            });
                }
            }
            
            return redirect (route("ordenlaboratorio.index"));
        }
        
        return redirect(route('index'));
    }

    public function update($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/update')){
            
            $resultado = ordenlaboratorio::find($id);
            
            // Verificar que la orden existe
            if (!$resultado) {
                return redirect(route('ordenlaboratorio.index'))->with('error', 'Orden de laboratorio no encontrada.');
            }
            
            $paciente = paciente::find($resultado->paciente_id);
            $medico = medico::find($resultado->medico_id);
            
            // Verificar que el paciente y médico existen
            if (!$paciente || !$medico) {
                return redirect(route('ordenlaboratorio.index'))->with('error', 'Datos de paciente o médico no encontrados.');
            }
            
            return view ("ordenlaboratorio.update", ["fila"=>$resultado,"medico"=>$medico,"paciente"=>$paciente]);
        }
        
        return redirect(route('index'));
    }

    public function save(Request $request){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/update')){
            
            $paciente = paciente::where('identificacion_paciente',$request->txtCedula)->first();
            $medico = medico::where('numero_registro',$request->txtRegistro)->first();
            $obj_ordenlaboratorio = ordenlaboratorio::find($request->txtId);

            // Validar que todos los registros existen
            if (!$paciente) {
                return redirect()->back()->withErrors(['txtCedula' => 'Paciente no encontrado con la cédula proporcionada.'])->withInput();
            }
            
            if (!$medico) {
                return redirect()->back()->withErrors(['txtRegistro' => 'Médico no encontrado con el número de registro proporcionado.'])->withInput();
            }
            
            if (!$obj_ordenlaboratorio) {
                return redirect(route('ordenlaboratorio.index'))->with('error', 'Orden de laboratorio no encontrada.');
            }

            $obj_ordenlaboratorio->fecha_orden = $request->txtFecha;
            $obj_ordenlaboratorio->paciente_id = $paciente->id;        
            $obj_ordenlaboratorio->medico_id = $medico->id;
            $obj_ordenlaboratorio->usuario_id = Auth::id();
            $obj_ordenlaboratorio->estado_orden_laboratorio = "Pendiente";
            $obj_ordenlaboratorio->save();
            
            // Redirect to the updatenext view with the order ID
            return redirect()->route('ordenlaboratorio.updatenext.view', ['id' => $obj_ordenlaboratorio->id]);
        }
        
        return redirect(route('index'));
    }

    public function showUpdatenext($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/update')){
            
            $obj_ordenlaboratorio = ordenlaboratorio::find($id);
            
            if (!$obj_ordenlaboratorio) {
                return redirect(route('ordenlaboratorio.index'))->with('error', 'Orden de laboratorio no encontrada.');
            }
            
            $resultados = examen_orden_laboratorio::where("ordenlaboratorio_id", $obj_ordenlaboratorio->id)->get();
            $tipo_examen = tipo_examen::get();
            $examenes = examen::get();
            $lista_examen = array();
            
            foreach($resultados as $resultado){
                array_push($lista_examen, $resultado->examen_id);
            }
            
            return view ("ordenlaboratorio.updatenext", [
                "lista_examenes" => $lista_examen, 
                "examenes" => $examenes, 
                "tipo_examen" => $tipo_examen, 
                "id_orden_laboratorio" => $obj_ordenlaboratorio->id
            ]);
        }
        
        return redirect(route('index'));
    }

    public function updatenext(Request $request){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/update')){
            
            DB::table('examen_orden_laboratorio')->where('ordenlaboratorio_id','=',$request->txtOrdenLaboratorio)->delete() ;

            foreach($request->examenes_id as $examen){
            
                
                $obj_orden_examen = new examen_orden_laboratorio ();
                $obj_orden_examen->ordenlaboratorio_id = $request->txtOrdenLaboratorio;
                $obj_orden_examen->examen_id = $examen;
                $obj_orden_examen->estado_examen = "Pendiente";
                $obj_orden_examen->save();
            
            }
                    
            return redirect (route("ordenlaboratorio.index"));
        }
        
        return redirect(route('index'));
    }

    public function delete($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/delete')){
            
            $obj = ordenlaboratorio::find($id);
            $obj->estado_orden_laboratorio = "Eliminado";
            $obj->save();
            return redirect (route("ordenlaboratorio.index"));
        }
        
        return redirect(route('index'));
    }

    public function desbloquear($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/ordenlaboratorio/delete')){
            
            $examenes_total = examen_orden_laboratorio::where('ordenlaboratorio_id',$id)->count();
            $examenes_terminados = examen_orden_laboratorio::where('ordenlaboratorio_id',$id)->where('estado_examen','Terminado')->count();
            $obj = ordenlaboratorio::find($id);
            if ($examenes_terminados==0) {
                $obj->estado_orden_laboratorio = "Pendiente";
            }elseif($examenes_terminados<$examenes_total){
                $obj->estado_orden_laboratorio = "En Proceso";
            }else{
                $obj->estado_orden_laboratorio = "Terminado";
            }
            $obj->save();
            return redirect (route("ordenlaboratorio.index"));
        }
        
        return redirect(route('index'));
    }

    public function consultar($cedula){
        $valor= array();
        $existe = paciente::where('identificacion_paciente',$cedula)->count();
        if($existe ==1){
            $paciente = paciente::where('identificacion_paciente',$cedula)->first();
            $valor= array("cedula"=>$cedula,"nombre"=>$paciente->nombre_paciente." ".$paciente->apellido_paciente); 
            
        }

        return $valor;
    }

    public function consultarRegistro($registro){
        $valor= array();
        $existe = medico::where('numero_registro',$registro)->count();
        if($existe ==1){
            $medico = medico::where('numero_registro',$registro)->first();
            $valor= array("registro"=>$registro,"nombre"=>$medico->nombre_medico); 
            
        }

        return $valor;
    }

    public function verHistorial($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/paciente')){
            
            if (Auth::user()->rol->tipo_rol == 1) {
                $resultado = ordenlaboratorio::where('paciente_id',$id)->get(); 
            } else {
                $resultado = ordenlaboratorio::get()->where('estado_orden_laboratorio','<>','Eliminado')->where('paciente_id',$id); 
            }
                                
            return view ("ordenLaboratorio.index", ["resultado"=>$resultado]);
        }
        
        return redirect(route('index'));
    }

}
