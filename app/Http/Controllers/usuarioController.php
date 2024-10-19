<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\usuario;
use App\Models\company;
use App\Models\rol;
use Illuminate\Support\Facades\DB;
use Session; 
use Auth;

class usuarioController extends Controller
{
    public function index(){
        
        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
     
        
        if (!Auth::user()->permisos('usuario')){
            
            return redirect(route('index'));
        }
              
        if (Auth::user()->rol->id>1) {                    
            $resultado = usuario::where('estado_usuario','>', 0)->where('company_id',Auth::user()->company->id)->get();
            $roles = rol::where('company_id',Auth::user()->company_id)->get();
        } else {
            $resultado = usuario::where('estado_usuario','>', 0)->get();
            $roles = rol::get();
        }
        
        $companys = company::where('id','!=',0)->get();
        return view ("usuario.index", ["resultado"=>$resultado,'roles'=>$roles,'companys'=>$companys]);

        

        
    }

    public function create(){

        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
        
        if (!Auth::user()->permisos('usuario','create')){
            
            return redirect(route('index'));
        }

        $roles = rol::get();
        $companys = company::where('id','!=',0)->get();
        return view("usuario.create",["roles"=>$roles,'companys'=>$companys]);

            
    }

    public function insert(Request $request){
        
        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
        
        if (!Auth::user()->permisos('usuario','create')){
            
            return redirect(route('index'));
        }
                
        if ($request->txtContraseña!=$request->txtContraseña_confirmation) {
            return redirect()->back()->withErrors(['danger' => 'las contraseñas no coinciden' ]);
        }

        $obj_usuario = new usuario();
        $obj_usuario->nombre_usuario = $request->txtUsuario;
        $obj_usuario->email_usuario = $request->txtEmail;
        $obj_usuario->company_id = $request->txtCompany;
        $obj_usuario->password_usuario = md5($request->txtContraseña);
        $obj_usuario->rol_id = $request->txtRol;
        $obj_usuario->estado_usuario = $request->txtEstado;

      

        if (Auth::user()->rol_id==1) {

            $obj_usuario->company_id = $request->txtCompany;

        }else{
            
            $obj_usuario->company_id = Auth::user()->company_id;

        }
        

        try {
            $obj_usuario->save();
            return redirect(route('usuario.index'))->withErrors(['status' => "Se creó el usuario: ".$obj_usuario->nombre_usuario]);

        } catch (\Illuminate\Database\QueryException $qe) {
            
            return redirect()->back()->withErrors(['danger' => 'Usuario o Correo duplicados' ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['danger' => $th]);
        }   
           


           
  
    }

    public function update($id){

        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
        
        if (!Auth::user()->permisos('usuario','update')){
            
            return redirect(route('index'));
        }

        $resultado = usuario::get()->where('id',$id);
        $roles = rol::get();
        return view ("usuario.update",  ["resultado"=>$resultado, "roles"=>$roles]);


    }

    public function save(Request $request){

        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
        
        if (!Auth::user()->permisos('usuario','update')){
            
            return redirect(route('index'));
        }
               
        $obj_usuario = usuario::find($request->txtId);
        if($request->txtContraseña==($obj_usuario->password_usuario)){
            $contraseña_verificada = $obj_usuario->password_usuario;
            
        }else{
            $contraseña_verificada = md5($request->txtContraseña); 
            
        }

        // Busqueda Usuario
        $nombre_existe = usuario::where('nombre_usuario', $request->txtUsuario )->count();
        if($nombre_existe>=1){
            $obj_usuario = usuario::where('nombre_usuario', $request->txtUsuario )->first();
            if($obj_usuario->id == $request->txtId){
                $email_existe = usuario::where('email_usuario', $request->txtEmail )->count();
                if($email_existe>=1){
                    $obj_email = usuario::where('email_usuario', $request->txtEmail )->first();
                    if($obj_email->id == $request->txtId){         
                        $obj_usuario->nombre_usuario = $request->txtUsuario;
                        $obj_usuario->email_usuario = $request->txtEmail;
                        $obj_usuario->password_usuario = $contraseña_verificada;
                        $obj_usuario->rol_id = $request->txtRol;
                        $obj_usuario->estado_usuario = $request->txtEstado;
                        $obj_usuario->company_id = Auth::user()->company_id;
                        
                        try {
                            $obj_usuario->save();
                            return redirect(route('usuario.index'))->withErrors(['status' => "Se ha actualizado el usuario: ".$obj_usuario->nombre_usuario ]);
        
                        } catch (\Illuminate\Database\QueryException $qe) {
                            
                            return redirect()->back()->withErrors(['danger' => 'Usuario o Correo duplicados' ]);
                        } catch (Exception $e) {
                            return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
                        } catch (\Throwable $th) {
                            return redirect()->back()->withErrors(['danger' => $th]);
                        }  
                        
                        
                    }else{
                        
                        return redirect()->back()->withErrors(['danger' => 'Ingreso un correo que ya esta en uso' ]);
                    }
                
                }else{
                    $obj_usuario->nombre_usuario = $request->txtUsuario;
                    $obj_usuario->email_usuario = $request->txtEmail;
                    $obj_usuario->password_usuario = $contraseña_verificada;
                    $obj_usuario->rol_id = $request->txtRol;
                    $obj_usuario->estado_usuario = $request->txtEstado;
                    try {
                        $obj_usuario->save();
                        return redirect(route('usuario.index'))->withErrors(['status' => "Se ha actualizado el usuario: ".$obj_usuario->nombre_usuario ]);
    
                    } catch (\Illuminate\Database\QueryException $qe) {
                        
                        return redirect()->back()->withErrors(['danger' => 'Usuario o Correo duplicados' ]);
                    } catch (Exception $e) {
                        return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
                    } catch (\Throwable $th) {
                        return redirect()->back()->withErrors(['danger' => $th]);
                    } 
                }
            
            }else{
                return redirect()->back()->withErrors(['danger' => 'Ingreso un nombre que ya esta en uso' ]);
            }
        }else{
            
            $email_existe = usuario::where('email_usuario', $request->txtEmail )->count();
            if($email_existe>=1){
                $obj_email = usuario::where('email_usuario', $request->txtEmail )->first();
                if($obj_email->id == $request->txtId){         
                    $obj_usuario->nombre_usuario = $request->txtUsuario;
                    $obj_usuario->email_usuario = $request->txtEmail;
                    $obj_usuario->password_usuario = $contraseña_verificada;
                    $obj_usuario->rol_id = $request->txtRol;
                    $obj_usuario->estado_usuario = $request->txtEstado;
                    try {
                        $obj_usuario->save();
                        return redirect(route('usuario.index'))->withErrors(['status' => "Se ha actualizado el usuario: ".$obj_usuario->nombre_usuario ]);
    
                    } catch (\Illuminate\Database\QueryException $qe) {
                        
                        return redirect()->back()->withErrors(['danger' => 'Usuario o Correo duplicados' ]);
                    } catch (Exception $e) {
                        return redirect()->back()->withErrors(['danger' => $e->getMessage()]);
                    } catch (\Throwable $th) {
                        return redirect()->back()->withErrors(['danger' => $th]);
                    } 
                }else{
                    return redirect()->back()->withErrors(['danger' => 'Ingreso un email que ya esta en uso' ]);
                }
            
            }else{
                return redirect()->back()->withErrors(['danger' => 'Ingreso un nombre que ya esta en uso' ]);
            }
        }

           

    }

    public function delete($id)
    {
        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
        
        if (!Auth::user()->permisos('usuario','delete')){
            
            return redirect(route('index'));
        }

        $obj = usuario::find($id);
        $obj->estado_usuario =0;
        $obj->save();
        return redirect (route("usuario.index"));

          
    }

    public function bloquear($id)
    {
        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
        
        if (!Auth::user()->permisos('usuario','delete')){
            
            return redirect(route('index'));
        }

        $obj = usuario::find($id);
        $obj->estado_usuario =2;
        $obj->save();
        return redirect (route("usuario.index"));

    
       
    }

    public function desbloquear($id){

        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
        
        if (!Auth::user()->permisos('usuario','delete')){
            
            return redirect(route('index'));
        }


        $obj = usuario::find($id);
        $obj->estado_usuario =1;
        $obj->save();
        return redirect (route("usuario.index"));

          

        
    }

    public function updatePassword($id){
        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
        
        
        $usuario = usuario::find($id);            
        return view('usuario.actualizarPassword', ["usuario"=>$usuario]);
           
    }
    
    public function updatePasswordSave(Request $request){
       

        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
        
        
        $usuario = usuario::find($request->txtId);
        if ($usuario->password_usuario == md5($request->txtPasswordActual)) {
            if ($request->txtPasswordNuevo == $request->txtPasswordConfirmacion) {
                $usuario->password_usuario = md5($request->txtPasswordNuevo);
                $usuario->save();
                return redirect(route('index'))->withErrors(['status' => "Su contraseña se ha actualizado"]);;
            } else {
                return redirect()->back()->withInput()->withErrors(['txtPasswordConfirmacion' => "No coincide la confirmacion con la nueva contraseña"]);
            }
            
        } else {
            return redirect()->back()->withInput()->withErrors(['txtPasswordActual' => "No es su contraseña actual intente de nuevo"]);
        }
                

             

    }

    public function userName($usuario){
        $valor= array();
        $existe = usuario::where('nombre_usuario',$usuario)->count();
        if($existe ==1){
           
            $valor= array("nombre"=>$usuario); 
            
        }

        return $valor;
    }

    public function Correo($correo){
        $valor= array();
        $existe = usuario::where('email_usuario',$correo)->count();
        if($existe ==1){
           
            $valor= array("email"=>$correo); 
            
        }

        return $valor;
    }

}
