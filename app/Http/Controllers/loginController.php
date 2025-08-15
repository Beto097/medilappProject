<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\rol;
use App\Models\paciente;
use App\Models\consulta;
use App\Models\orden_laboratorio;
use App\Models\examen_orden_laboratorio;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use Session;

class loginController extends Controller
{
    public function dashboard(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
            
        }        


        consulta::actualizarEstados();  

    
        return view('index');
        
    }

    Public function index() {
        
        return view('login.index');
    }

    public function login(Request $request)
    {
        // 1. Validar datos de entrada
        $request->validate([
            'usuario'  => 'required|string',
            'password' => 'required|string',
        ]);

        $nombre = $request->usuario;
        $contraseña = $request->password;

        // 2. Buscar usuario
        $usuario = User::where('nombre_usuario', $nombre)->first();

        if (!$usuario) {
            return back()->withErrors(['danger' => "El usuario es incorrecto."])
                        ->withInput($request->only('usuario'));
        }

        // 3. Verificar fecha de fin de activación
        if (!empty($usuario->fecha_fin) && Carbon::parse($usuario->fecha_fin)->isPast()) {
            $usuario->estado_usuario = 0;
            $usuario->save();
        }

        // 3. Validar estado del usuario
        if ($usuario->estado_usuario == 0) {
            return back()->withErrors(['danger' => "No puede ingresar al sistema. Comuníquese con el administrador."])
                        ->withInput($request->only('usuario'));
        }

        // 4. Verificar contraseña
        // Si tu DB todavía guarda MD5, toca mantener temporalmente ese check
        if (Hash::check($contraseña, $usuario->password_usuario) || $usuario->password_usuario === md5($contraseña)) {
            Auth::login($usuario);

            // Redirigir a URL previa si existe
            if (Session::has('url')) {
                $url = Session::pull('url'); // además limpia la variable
                return redirect($url);
            }

            // Redirigir al dashboard o página principal
            return redirect()->route('index'); 
        }

        return back()->withErrors(['danger' => "Contraseña incorrecta."])
                    ->withInput($request->only('usuario'));
    }

    public function cerrar(){

        Auth::logout();
      
        return redirect(route('login.index'));
    }
}
