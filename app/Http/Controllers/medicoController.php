<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\medico;
use App\Models\rol;
use App\Models\User;
use App\Models\sucursal;

use Session;

class medicoController extends Controller
{
    public function index(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/medico')){
                        
            if (Auth::user()->rol->tipo_rol == 1) {
                $resultado = medico::get();  
            } else {
                $resultado = medico::where('estado_medico',1)->get(); 
            }
            $sucursales = sucursal::where('estado_sucursal',1)->get();
            return view ("medico.index", ["resultado"=>$resultado,'sucursales'=>$sucursales]);
            
        }

        return redirect(route('index'));
    }

    public function insert(Request $request)
    {
        // 1. Verificar autenticación
        if (!Auth::check()) {
            Session::put('url', url()->current());
            return redirect()->route('login.index');
        }

        // 2. Verificar acceso
        if (!Auth::user()->accesoRuta('/medico/create')) {
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta función."]);
        }

        // 3. Validar datos
        $request->validate([
            'txtNumero'      => 'required|string|max:50|unique:medico,numero_registro',
            'txtCedula'      => 'required|string|max:50|unique:usuario,nombre_usuario',
            'txtNombre'      => 'required|string|max:100',
            'txtApellido'    => 'required|string|max:100',
            'txtEmail'       => 'required|email|max:150|unique:medico,email_medico|unique:usuario,email_usuario',
            'txtTelefono'    => 'nullable|string|max:20',
            'txtPassword'    => 'required|string|min:6',
            'selectSucursal' => 'required|exists:sucursal,id',
            'txtFFin'        => 'nullable|date',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Obtener rol Doctor
                $rol = Rol::where('nombre_rol', 'Médico')->firstOrFail();

                // Crear médico
                $medico = medico::create([
                    'numero_registro' => $request->txtNumero,
                    'cedula_medico'   => $request->txtCedula,
                    'nombre_medico'   => strtoupper($request->txtNombre . ' ' . $request->txtApellido),
                    'email_medico'    => strtolower($request->txtEmail),
                    'telefono_medico' => $request->txtTelefono,
                    'estado_medico'        => '1',
                ]);

                // Crear usuario
                User::create([
                    'primer_nombre_usuario' => $request->txtNombre,
                    'apellido_usuario'      => $request->txtApellido,
                    'nombre_usuario'        => $request->txtCedula,
                    'email_usuario'         => strtolower($request->txtEmail),
                    'password_usuario'      => md5($request->txtPassword),
                    'rol_id'                => $rol->id,
                    'sucursal_id'           => $request->selectSucursal,
                    'fecha_fin'             => $request->txtFFin,
                    'estado_usuario'        => '1',
                ]);
            });

            return redirect()->back()->withErrors('status', 'Médico creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['danger' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function update($id){
        
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/medico/update')){
            
            if(strlen ( $id )>10){
                $id = decrypt($id);
                $resultado = medico::get()->where('id',$id);
                return view ("medico.update",  ["resultado"=>$resultado]);
            }else{
                return "error";
            }
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
        
    }

    public function save(Request $request){
        
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/medico/update')){
            
            $obj_medico = medico::find($request->txtId);
            
            if($obj_medico->numero_registro == $request->txtNumero){
                
                $obj_medico->numero_registro =$request->txtNumero;
                $obj_medico->nombre_medico = strtoupper($request->txtNombre);
                $obj_medico->email_medico = strtolower($request->txtEmail);
                $obj_medico->telefono_medico = $request->txtTelefono;
                $obj_medico->save();
                return redirect(route('medico.index'))->withErrors(['status' => "Se ha guardado el medico " ]);
            
            }else{

                $existe = medico::where('numero_registro',$request->txtNumero)->count();

                if($existe == 1){
                    if($request->esModal==2){
                        return redirect()->back()->withErrors(['danger'=> "Ingreso un numero de registro que ya existe"]);
                    }
                    return back()->withInput()->withErrors(['status' => "El nuevo numero de registro ya esta asignado a otro medico" ]); 
                }else{           

                    $obj_medico->numero_registro =$request->txtNumero;
                    $obj_medico->nombre_medico = $request->txtNombre;
                    $obj_medico->email_medico = $request->txtEmail;
                    $obj_medico->telefono_medico = $request->txtTelefono;
                    $obj_medico->save();
                    return redirect(route('medico.index'))->withErrors(['status' => "Se ha guardado el medico " ]);
                }
            } 
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

                 

    }

    public function delete($id){

        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/medico/delete')){
            
            $obj_medico = medico::find($id);
            $obj_medico->estado_medico = 0;
            $obj_medico->save();
            return redirect(route('medico.index'))->withErrors(['status' => "Se ha eliminado el medico" ]);
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
        

    }

    public function consultarRegistro($registro){

        if (!Auth::user()) {
            return 'no tienes acceso';
        }
        
        $valor= array();
        $existe = medico::where('numero_registro',$registro)->count();
        if($existe ==1){
            $medico = medico::where('numero_registro',$registro)->first();
            $valor= array("registro"=>$registro,"nombre"=>$medico->nombre_medico); 
        }

        return $valor;
    }

    public function habilitar(Request $request)
    {

        // 1. Verificar autenticación
        if (!Auth::check()) {
            Session::put('url', url()->current());
            return redirect()->route('login.index');
        }

        // 2. Verificar acceso
        if (!Auth::user()->accesoRuta('/medico/dias')) {
            return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta función."]);
        }

        $usuario = User::findOrFail($request->txtId);

        if ($usuario->password_usuario == $request->txtPassword) {
            $contrasena = $request->txtPassword;
        } else {
            $contrasena = md5($request->txtPassword);
        }
        
        $usuario->update([
            'password_usuario'  => $contrasena,
            'estado_usuario'    => $request->txtEstado,
            'sucursal_id'       => $request->selectSucursal,
            'fecha_fin'         => $request->txtFFin,
        ]);

        return redirect()->back()->withErrors(['status' => 'Médico habilito correctamente.']);
    }
}