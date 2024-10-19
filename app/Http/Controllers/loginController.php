<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\usuario;
use App\Models\rol_pantalla;
use Session;
use Auth;

class loginController extends Controller
{
    Public function index() {

        if (Auth::user()) {
            
            return redirect(route('index'));

        }
        
        return view('login.index');
    }

    Public function login(Request $request) {
        $nombre=$request->usuario;
        $contraseña=$request->password;        
        
        $existe=usuario::where('nombre_usuario',$nombre)->count();
        
        if ($existe==1) {
            $usuario=usuario::where('nombre_usuario',$nombre)->first(); 
            if ($usuario['password_usuario']==md5($contraseña)) {

                Auth::login($usuario);
                if (Session::get('url')) {
                    return redirect(Session::get('url'));
                }
                return redirect(route('index'));
                
            }
            else {
                
                return redirect()->back()->withErrors(['danger' => "Contraseña incorrecta."])->withInput($request->all());
            }
        }
        else {
           
            return redirect()->back()->withErrors(['danger' => "El usuario es incorrecto."])->withInput($request->all());
        }
    }

    Public function validation () {
        return view('login.validar');
    }

    Public function emailvalidation (Request $request) {
        $email=$request->email;

        $existe=usuario::where('email_usuario',$email)->count();

        if ($existe==1) {
            /* Codigo de validacion email */
            return redirect(route('login.index'))->withErrors(['status' => "Se ha mandado la verificación al correo electrónico." ]);
        }
        else {
            return back()->withInput()->withErrors(['status' => "El correo electronico no existe." ]);
        }
    }
    public function cerrar(){
        Auth::logout();
        Session::flush();        

        return redirect(route('login.index'));
    }
}
