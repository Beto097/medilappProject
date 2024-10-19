<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\usuario;
use App\Models\orden_laboratorio;
use App\Models\medico;
use App\Models\paciente;
use App\Models\rol;
use App\Models\examen;
use App\Notifications\notificacionsOrdenes;
use App\Models\tipo_examen;
use App\Models\examen_orden_laboratorio;
use Session; // Agregar 
use Auth;
use Carbon\Carbon;

class ordenLaboratorioController extends Controller
{
    public function index(){

        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }        
                
        if (!Auth::user()->permisos('orden_laboratorio','create')){
            
            return redirect(route('index'));
        }

        if(Auth::user()->rol_id==1){
            $resultado = orden_laboratorio::get(); 
        }else{
            $resultado = orden_laboratorio::get()->where('estado_orden_laboratorio','<>','Eliminado'); 
        }
                                   
        return view ("ordenLaboratorio.index", ["resultado"=>$resultado]);

           
    }
    public function create(){
        
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }        
                
        if (!Auth::user()->permisos('orden_laboratorio','create')){
            
            return redirect(route('index'));
        }

        $rol = rol::where('nombre_rol','like','laboratorio%')->first();
        
        $externos = usuario::where('rol_id',$rol->id)->get();
        
        return view("ordenLaboratorio.create",['externos'=>$externos]);

          
        
        
        
    }
    public function create2($id){

        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }        
                
        if (!Auth::user()->permisos('orden_laboratorio','create')){
            
            return redirect(route('index'));
        }
                
        $paciente = paciente::find($id);
        return redirect(route('orden_laboratorio.create'))->with(['txtCedula'=>$paciente->identificacion_paciente]);

        
    }
    public function insert(Request $request){
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }        
                
        if (!Auth::user()->permisos('orden_laboratorio','create')){
            
            return redirect(route('index'));
        }

        $externo = 0;
        if($request->esExterno){
            $externo = 1;
        }
        $txtFecha = Carbon::now()->format('Y-m-d');
        $paciente = paciente::where('identificacion_paciente',$request->txtCedula)->first();
        $medico = medico::where('numero_registro',$request->txtRegistro)->first();
        $obj_orden_laboratorio = new orden_laboratorio();
        $obj_orden_laboratorio->fecha_orden = $txtFecha;
        $obj_orden_laboratorio->paciente_id = $paciente->id; 
        $obj_orden_laboratorio->usuario_id = Auth::user()->id;               
        $obj_orden_laboratorio->medico_id = $medico->id;
        $obj_orden_laboratorio->estado_orden_laboratorio = "Pendiente";
        $obj_orden_laboratorio->esExterno = $externo;
        $obj_orden_laboratorio->externo_id = $request->selectExterno; 

        try {

            $obj_orden_laboratorio->save();

        } catch (\Illuminate\Database\QueryException $qe) {                
            return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
        }
        
        $nueva_orden = $obj_orden_laboratorio->id;

        $tipo_examen = tipo_examen::get();
        $caracteristica_examen = examen::where('estado_examen',1)->get();
        
        return view ("ordenLaboratorio.createnext", ["tipo_examen"=>$tipo_examen,"caracteristica_examen"=>$caracteristica_examen, "nueva_orden"=>$nueva_orden]);
       

    }

    public function createnext(Request $request){
        
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }        
                
        if (!Auth::user()->permisos('orden_laboratorio','create')){
            
            return redirect(route('index'));
        }

        $conteo = array();
        foreach($request->examenes_id as $examen){

            $examen_1= examen::find($examen);
            
            
            if($examen_1->padre>0){
                if (empty($conteo[$examen_1->padre])) {
                    $obj_orden_examen = new examen_orden_laboratorio ();
                    $obj_orden_examen->orden_laboratorio_id = $request->txtNueva_Orden;
                    $obj_orden_examen->examen_id = $examen_1->padre;
                    $obj_orden_examen->padre=-1;
                    $obj_orden_examen->estado_examen = "Pendiente";
                    try {

                        $obj_orden_examen->save();
            
                    } catch (\Illuminate\Database\QueryException $qe) {                
                        return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
                    } catch (Exception $e) {
                        return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
                    } catch (\Throwable $th) {
                        return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
                    }
                    
                }
                $conteo[$examen_1->padre] =  1;
            }
            
            $obj_orden_examen = new examen_orden_laboratorio ();
            $obj_orden_examen->orden_laboratorio_id = $request->txtNueva_Orden;
            $obj_orden_examen->examen_id = $examen;
            $obj_orden_examen->estado_examen = "Pendiente";
            $obj_orden_examen->padre=$examen_1->padre;
            try {

                $obj_orden_examen->save();
    
            } catch (\Illuminate\Database\QueryException $qe) {                
                return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
            }
        
        }

        $orden_laboratorio = orden_laboratorio::find($request->txtNueva_Orden);

        
    
        //Enviar notificacionea a usuarios
        $notificacion['orden_id'] = $request->txtNueva_Orden;
        $notificacion['mensaje'] = 'El paciente '.$orden_laboratorio->paciente->nombre_paciente." ".$orden_laboratorio->paciente->apellido_paciente.' tiene una nueva orden';
        
        $roles = rol::where('nombre_rol','like','labora%')->get();
        $lista_roles = array();
        foreach($roles as $rol){
            array_push($lista_roles,$rol->id);
        }
        
        usuario::whereIn('rol_id',$lista_roles)->where('company_id',Auth::user()->company_id)                            
                ->each(function(usuario $usuario) use ($notificacion){
                    $usuario->notify(new notificacionsOrdenes($notificacion));
                });

        return redirect (route("orden_laboratorio.index"));

               
}

    public function update($id){
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }        
                
        if (!Auth::user()->permisos('orden_laboratorio','update')){
            
            return redirect(route('index'));
        }

        $resultado = orden_laboratorio::find($id);        
        $paciente = paciente::find($resultado->paciente_id);
        $medico = medico::find($resultado->medico_id);
        return view ("orden_laboratorio.update",  ["fila"=>$resultado,"medico"=>$medico,"paciente"=>$paciente]);

                   
    }

    public function save(Request $request){

        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }        
                
        if (!Auth::user()->permisos('orden_laboratorio','update')){
            
            return redirect(route('index'));
        }

        $paciente = paciente::where('identificacion_paciente',$request->txtCedula)->first();
        $medico = medico::where('numero_registro',$request->txtRegistro)->first();

        $obj_orden_laboratorio = orden_laboratorio::find($request->txtId);
        $obj_orden_laboratorio->fecha_orden = $request->txtFecha;
        $obj_orden_laboratorio->paciente_id = $paciente->id;        
        $obj_orden_laboratorio->medico_id = $medico->id;
        $obj_orden_laboratorio->usuario_id = Auth::user()->id;
        $obj_orden_laboratorio->estado_orden_laboratorio = "Pendiente";
        try {

            $obj_orden_laboratorio->save();

        } catch (\Illuminate\Database\QueryException $qe) {                
            return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
        }
        
        // $nueva_orden = $obj_orden_laboratorio->id;
        $resultados = examen_orden_laboratorio::where("orden_laboratorio_id",$obj_orden_laboratorio->id)->get();
        $tipo_examen = tipo_examen::get();

        $examenes = examen::get();
        $lista_examen = array();
        foreach($resultados as $resultado){
            array_push($lista_examen,$resultado->examen_id);
        }
        
        return view ("orden_laboratorio.updatenext",  ["lista_examenes"=>$lista_examen, "examenes"=>$examenes, "tipo_examen"=>$tipo_examen, "id_orden_laboratorio"=>$obj_orden_laboratorio->id]);

    }

    public function updatenext(Request $request){

        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }        
                
        if (!Auth::user()->permisos('orden_laboratorio','update')){
            
            return redirect(route('index'));
        }

        try {

            DB::table('examen_orden_laboratorio')->where('orden_laboratorio_id','=',$request->txtOrdenLaboratorio)->delete() ;

            foreach($request->examenes_id as $examen){
            
                
                $obj_orden_examen = new examen_orden_laboratorio ();
                $obj_orden_examen->orden_laboratorio_id = $request->txtOrdenLaboratorio;
                $obj_orden_examen->examen_id = $examen;
                $obj_orden_examen->estado_examen = "Pendiente";
                $obj_orden_examen->save();
            
            }

        } catch (\Illuminate\Database\QueryException $qe) {                
            return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
        }
                
        return redirect (route("orden_laboratorio.index"));
           
    }

    public function delete($id){

        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }        
                
        if (!Auth::user()->permisos('orden_laboratorio','delete')){
            
            return redirect(route('index'));
        }

        $obj = orden_laboratorio::find($id);
        $obj->estado_orden_laboratorio = "Eliminado";
        try {

            $obj->save();

        } catch (\Illuminate\Database\QueryException $qe) {                
            return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
        }
        
        return redirect (route("orden_laboratorio.index"));

    }

    public function desbloquear($id){

        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }        
                
        if (!Auth::user()->permisos('orden_laboratorio','delete')){
            
            return redirect(route('index'));
        }


        $examenes_total = examen_orden_laboratorio::where('orden_laboratorio_id',$id)->count();
        $examenes_terminados = examen_orden_laboratorio::where('orden_laboratorio_id',$id)->where('estado_examen','Terminado')->count();
        $obj = orden_laboratorio::find($id);
        if ($examenes_terminados==0) {
            $obj->estado_orden_laboratorio = "Pendiente";
        }elseif($examenes_terminados<$examenes_total){
            $obj->estado_orden_laboratorio = "En Proceso";
        }else{
            $obj->estado_orden_laboratorio = "Terminado";
        }

        try {

            $obj->save();

        } catch (\Illuminate\Database\QueryException $qe) {                
            return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
        }
                
        return redirect (route("orden_laboratorio.index"));
           
        

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
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('ordenesLaboratorio','historial')){
            
            return redirect(route('index'));
        }

        if(Auth::user()->rol_id==1){
            $resultado = orden_laboratorio::where('paciente_id',$id)->get(); 
        }else{
            $resultado = orden_laboratorio::get()->where('estado_orden_laboratorio','<>','Eliminado')->where('paciente_id',$id); 
        }
        
                            
        return view ("ordenLaboratorio.index", ["resultado"=>$resultado]);

            
    }

}
