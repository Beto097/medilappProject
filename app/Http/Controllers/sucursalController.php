<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\sucursal;

use Sesssion;

class sucursalController extends Controller
{
    public function index(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/sucursal')){
                        
            if (Auth::user()->rol->tipo_rol == 1) {
                $resultado = sucursal::get();  
            } else {
                $resultado = sucursal::where('estado_sucursal',1)->get(); 
            }


            return view ("sucursal.index", ["resultado"=>$resultado]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function create(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/sucursal/create')){
                        

            return view ("sucursal.create");
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function insert(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/sucursal/create')){
                        
            $obj_sucursal = new sucursal();        
            $obj_sucursal->nombre_sucursal=$request->txtNombre;
            $obj_sucursal->telefono_sucursal = $request->txtTelefono;

            $obj_sucursal->save();

            return redirect(route('sucursal.index'))->withErrors(['status' => "Se ha creado la sucursal ".$obj_sucursal->nombre_sucursal]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function save(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/sucursal/update')){
                        
            $obj_sucursal = sucursal::find($request->txtId);

            $obj_sucursal->nombre_sucursal=$request->txtNombre;
            $obj_sucursal->telefono_sucursal = $request->txtTelefono;

            $obj_sucursal->save();

            return redirect(route('sucursal.index'))->withErrors(['status' => "Se ha actualizado la sucursal ".$obj_sucursal->nombre_sucursal]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function actualizar(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/sucursal/actualizar')){
                        
            $obj_usuario = Auth::user();
            
            $obj_usuario->sucursal_id =$request->selectSucursal;

            $obj_usuario->save();

            return redirect()->back()->withErrors(['status' => "Se ha la sucursal del usuario"]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function delete($id){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/sucursal/delete')){
                        
            $obj_sucursal = sucursal::find($id);

            $obj_sucursal->estado_sucursal='0';
            
            $obj_sucursal->save();

            return redirect(route('sucursal.index'))->withErrors(['status' => "Se ha eliminado la sucursal ".$obj_sucursal->nombre_sucursal]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function desbloquear($id){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/sucursal/delete')){
                        
            $obj_sucursal = sucursal::find($id);

            $obj_sucursal->estado_sucursal='1';
            
            $obj_sucursal->save();

            return redirect(route('sucursal.index'))->withErrors(['status' => "Se ha desbloqueado la sucursal ".$obj_sucursal->nombre_sucursal]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }


}
