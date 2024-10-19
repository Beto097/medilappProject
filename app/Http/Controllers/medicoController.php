<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\medico;
use App\Models\rol;
use Illuminate\Support\Facades\DB;
use Session;
use Auth; 


class medicoController extends Controller
{
    //
    public function index(){

        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
           
        if (!Auth::user()->permisos('medico')){
            
            return redirect(route('index'));
        }

        if(Session::get('usuario_rol_id')==1){
            $resultado = medico::get(); 
        }else{
            $resultado = medico::where('estado_medico',1)->get(); 
        }
        
        
        return view('medico.index', ["resultado"=>$resultado]);

           
       
    }

      
    

    public function create(){
        
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('medico','create')){
            
            return redirect(route('index'));
        }
                
        return view("medico.create");

       
    }

    public function insert(Request $request){ 

        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('medico','create')){
            
            return redirect(route('index'));
        }

        $existe = medico::where('numero_registro',$request->txtNumero)->count();
        
        if($existe == 1){
            return back()->withInput()->withErrors(['status' => "Este medico ya esta registrado" ]); 
        }else{           

            $obj_medico = new medico();
            $obj_medico->numero_registro=$request->txtNumero;
            $obj_medico->nombre_medico = strtoupper($request->txtNombre);
            $obj_medico->email_medico = strtolower($request->txtEmail);
            $obj_medico->telefono_medico = $request->txtTelefono;
            $obj_medico->save();
            if($request->esModal){
                if($request->esModal==2){
                    return redirect()->back()->with(['txtCedula'=>$request->txtCedula,'txtRegistro'=>$obj_medico->numero_registro]);
                }
                if($request->esModal==3){
                    return redirect(route('orden_laboratorio.create'))->with(['txtCedula'=>$request->txtCedula,'txtRegistro'=>$obj_medico->numero_registro]);
                }
            }
    
            return redirect(route('medico.index'))->withErrors(['status' => "Se creó el medico " .$obj_medico->nombre_medico ]);
        }
    

        
        
        
    }

    public function update($id){
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('medico','update')){
            
            return redirect(route('index'));
        }

        if(strlen ( $id )>10){
            $id = decrypt($id);
            $resultado = medico::get()->where('id',$id);
            return view ("medico.update",  ["resultado"=>$resultado]);
        }else{
            return "error";
        }
           
        
    }

    public function save(Request $request){
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('medico','update')){
            
            return redirect(route('index'));
        }

        $obj_medico = medico::find($request->txtId);
        if($obj_medico->numero_registro == $request->txtNumero){
            
            $obj_medico->numero_registro =$request->txtNumero;
            $obj_medico->nombre_medico = strtoupper($request->txtNombre);
            $obj_medico->email_medico = strtolower($request->txtEmail);
            $obj_medico->telefono_medico = $request->txtTelefono;
            $obj_medico->save();
            return redirect(route('medico.index'))->withErrors(['status' => "Se actualizo el medico" ]);
        
            
        }else{

            $existe = medico::where('numero_registro',$request->txtNumero)->count();

            if($existe == 1){
                if($request->esModal==2){
                    return redirect()->back()->withErrors(['danger'=> "Ingreso un numero de registro que ya existe"]);
                    
                }
                return back()->withInput()->withErrors(['danger' => "El nuevo numero de registro ya esta asignado a otro medico" ]); 
            }else{           

                $obj_medico->numero_registro =$request->txtNumero;
                $obj_medico->nombre_medico = $request->txtNombre;
                $obj_medico->email_medico = $request->txtEmail;
                $obj_medico->telefono_medico = $request->txtTelefono;
                $obj_medico->save();
                return redirect(route('medico.index'))->withErrors(['status' => "Se actualizo el medico" ]);
            }
        } 

           

                 

    }

    public function delete($id){

        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('medico','delete')){
            
            return redirect(route('index'));
        }

        $obj_medico = medico::find($id);
        $obj_medico->estado_medico = 0;
        $obj_medico->save();
        return redirect(route('medico.index'))->withErrors(['danger' => "Se ha eliminado el medico" ]);


    }


    public function desbloquear($id){
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('medico','delete')){
            
            return redirect(route('index'));
        }

        
        $obj_medico = medico::find($id);
        $obj_medico->estado_medico = 1;
        $obj_medico->save();
        return redirect(route('medico.index'))->withErrors(['status' => "Se ha desbloqueado el medico" ]);


    }

   


}
