<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\paciente;
use App\Models\rol;
use App\Models\usuario;
use App\Models\notificacion;
use App\Notifications\nuevoUsuario;
use Carbon\Carbon;
use Rules\Rules;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class pacienteController extends Controller
{
    //

    public function index(){

                
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('paciente')){
            
            return redirect(route('index'));
        }

        if(Auth::user()->rol_id==1){

            $resultado = paciente::get(); 

        }else{

            $resultado=paciente::where('estado_paciente',1)->get();

        }

        return view ("paciente.index", ["resultado"=>$resultado,]);
        
    }

    public function create(){
        
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('paciente','create')){
            
            return redirect(route('index'));
        }
            
           
        return view("paciente.create");       
        
    }

    public function insert(Request $request){       
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('paciente','create')){
            
            return redirect(route('index'));
        }

        $existe = paciente::where('identificacion_paciente', $request->txtcedula)->count();
        if($existe == 1){
            return back()->withInput()->withErrors(['status' => "La cédula que quiere ingresar ya se encuentra registrada en el sistema, ingrese una diferente!"]);
        }else{
            $obj_paciente = new paciente();
            $obj_paciente->identificacion_paciente = $request->txtCedula;
            $obj_paciente->nombre_paciente = strtoupper($request->txtnombre);
            $obj_paciente->apellido_paciente = strtoupper($request->txtapellido);
            $obj_paciente->sexo_paciente = $request->txtsexo;
            $obj_paciente->fecha_nacimiento_paciente = $request->txtfecnac;
            $obj_paciente->telefono_paciente = $request->txttelefono;
            $obj_paciente->email_paciente =  strtolower($request->txtemail);
            $obj_paciente->comentario_paciente = nl2br($request->txtComentario);            

            try {
                $obj_paciente->save();

                if($request->esModal){
                    if($request->esModal==2){
                        
                        return redirect(route('paciente.index'))->withErrors(['status' => "Se Agregó el Nuevo Paciente " .$obj_paciente->nombre_paciente." ".$obj_paciente->apellido_paciente ]); 
                    }
                }
                return redirect(route('paciente.index'))->withErrors(['status' => "Se Agregó el Nuevo Paciente " .$obj_paciente->nombre_paciente." ".$obj_paciente->apellido_paciente ]); 

            } catch (\Illuminate\Database\QueryException $qe) {                
                return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
            }

            /* if ($obj_paciente->email_paciente!='') {

                $password = Controller::generaPassword(10);                        
                $obj_usuario =new usuario();
                $obj_usuario->nombre_usuario = $obj_paciente->identificacion_paciente;
                $obj_usuario->email_usuario = $obj_paciente->email_paciente;
                $obj_usuario->password_usuario =  md5($password);
                $rol = rol::where('nombre_rol','Paciente')->first();
                $obj_usuario->rol_id = $rol->id;
                $obj_usuario->save();

                //Enviar notificacionea a usuarios
                $notificacion['identificacion_paciente'] = $obj_paciente->identificacion_paciente;
                $notificacion['mensaje'] = 'El paciente '.$obj_paciente->nombre_paciente." ".$obj_paciente->apellido_paciente.' se le creo una cuenta en webvalmar.com';
                $notificacion['password'] = $password;
                
                $roles = rol::where('nombre_rol','like','Recep%')->get();
                
                $lista_roles = array();
                foreach($roles as $rol){
                    array_push($lista_roles,$rol->id);
                }
                
                usuario::whereIn('rol_id',$lista_roles)                            
                        ->each(function(usuario $usuario) use ($notificacion){
                            $usuario->notify(new nuevoUsuario($notificacion));
                        });

                


            }
*/            
            
        }

            
            
              
           

        
    }

    public function update($id){
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('paciente','update')){
            
            return redirect(route('index'));
        }

        $resultado = paciente::get()->where('id',$id);
        return view ("paciente.update",  ["resultado"=>$resultado]);

           
        
    }

    public function save(Request $request){
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('paciente','update')){
            
            return redirect(route('index'));
        }
                
        $obj_paciente = paciente::find($request->txtid);
                
        if($obj_paciente->identificacion_paciente == $request->txtCedula){
    
            $obj_paciente->identificacion_paciente = $request->txtCedula;
            $obj_paciente->nombre_paciente =  strtoupper($request->txtnombre);
            $obj_paciente->apellido_paciente = strtoupper($request->txtapellido);
            $obj_paciente->sexo_paciente = $request->txtsexo;
            $obj_paciente->fecha_nacimiento_paciente = $request->txtfecnac;
            $obj_paciente->telefono_paciente = $request->txttelefono;
            $obj_paciente->email_paciente = strtolower($request->txtemail);
            $obj_paciente->comentario_paciente = nl2br($request->txtComentario);
            try {
                $obj_paciente->save();

                if($request->esModal==2){
                    return redirect()->back()->withErrors(['status' => "Se Modificó el Paciente Correctamente!"]);
                }
            
                return redirect(route('paciente.index'))->withErrors(['status' => "Se Modificó el Paciente Correctamente!" ]);

            } catch (\Illuminate\Database\QueryException $qe) {                
                return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
            }
            
        }else{
            $existe = paciente::where('identificacion_paciente', $request->txtCedula)->count();
            
            if($existe == 1){
                if($request->esModal==2){
                    return redirect()->back()->withErrors(['danger'=> "Ingreso una cedula que ya existe",'tipo'=>'danger']);
                    
                }
            
                return back()->withInput()->withErrors(['status' => "La cédula que quiere ingresar ya se encuentra registrada en el sistema, ingrese una diferente!"]);
            }else{
                $obj_paciente->identificacion_paciente = $request->txtCedula;
                $obj_paciente->nombre_paciente = $request->txtnombre;
                $obj_paciente->apellido_paciente = $request->txtapellido;
                $obj_paciente->sexo_paciente = $request->txtsexo;
                $obj_paciente->fecha_nacimiento_paciente = $request->txtfecnac;
                $obj_paciente->telefono_paciente = $request->txttelefono;
                $obj_paciente->email_paciente = $request->txtemail;
                try {
                    $obj_paciente->save();
    
                    if($request->esModal==2){
                        return redirect()->back()->withErrors(['status' => "Se Modificó el Paciente Correctamente!"]);
                    }
                
                    return redirect(route('paciente.index'))->withErrors(['status' => "Se Modificó el Paciente Correctamente!" ]);
    
                } catch (\Illuminate\Database\QueryException $qe) {                
                    return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
                } catch (Exception $e) {
                    return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
                } catch (\Throwable $th) {
                    return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
                }
            }
        }
           
        
        
    }

    public function eliminar($id){
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('paciente','delete')){
            
            return redirect(route('index'));
        }

        $resultado = paciente::find($id);
        $resultado->estado_paciente = 0;
        try {
            $resultado->save();
            return redirect (route('paciente.index'))->withErrors(['danger' => "Se Eliminó el Paciente Correctamente!" ]);

        } catch (\Illuminate\Database\QueryException $qe) {                
            return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
        }
        
            
        
    }

    public function desbloquear($id){
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('paciente','delete')){
            
            return redirect(route('index'));
        }

        $resultado = paciente::find($id);
        $resultado->estado_paciente = 1;
        try {
            $resultado->save();
            return redirect (route('paciente.index'))->withErrors(['status' => "Se Activo el Paciente Correctamente!" ]);

        } catch (\Illuminate\Database\QueryException $qe) {                
            return redirect()->back()->withErrors(['danger' => $qe->getMessage()]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['danger' => $th->getMessage()]);
        }
        
            
        
    }
    
    public function verPassword($id){
        $notificaciones = notificacion::where('notifiable_type','App\Models\usuario')->where('notifiable_id',Session::get('usuario_log_id'))->get();
        
        foreach ($notificaciones as $notificacion) {
            $data = json_decode($notificacion->data, true);
            if ($data['identificacion_paciente']==$id) {
                
                $notificacion->delete();
                
                $paciente = paciente::where('identificacion_paciente',$id)->first();
                
                return view('paciente.verPassword',['paciente'=>$paciente,'password'=>$data['password']]);
            }
            
        }
        
     
       
    }

    public function busqueda(){

        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('paciente','buscar')){
            
            return redirect(route('index'));
        }
        
        return view("paciente.buscar");
           
        
    }


    public function buscar(Request $request){
        
        if (!Auth::user()) {
            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));
        }
                
        if (!Auth::user()->permisos('paciente','buscar')){
            
            return redirect(route('index'));
        }
                
        $keyWord = '%'.$request->txtTexto .'%';
        $pacientes = paciente::orWhere('identificacion_paciente', 'LIKE', $keyWord)
                    ->orWhere('nombre_paciente', 'LIKE', $keyWord)
                    ->orWhere('apellido_paciente', 'LIKE', $keyWord)
                    ->orWhere('telefono_paciente', 'LIKE', $keyWord)
                    ->orWhere('email_paciente', 'LIKE', $keyWord)
                    ->get();
        
                 
        return view ("paciente.index", ["resultado"=>$pacientes]);

           
        
    }

    

}
