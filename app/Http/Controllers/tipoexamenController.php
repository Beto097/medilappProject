<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\usuario;
use App\Models\tipo_examen;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class tipoexamenController extends Controller
{
    public function index(){
        
        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
           
        if (!Auth::user()->permisos('tipoexamen')){
            
            return redirect(route('index'));
        }

        if(Auth::user()->rol_id==1){
            $resultado = tipo_examen::get(); 
        }else{
            $resultado = tipo_examen::where('estado_tipo_examen',1)->get(); 
        }
         
        return view ("tipo_examen.index", ["resultado"=>$resultado]);

           
        
    }

    public function create(){

        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
           
        if (!Auth::user()->permisos('tipoexamen','create')){
            
            return redirect(route('index'));
        }
                
        return view("tipo_examen.create");

    }

    public function insert(Request $request){
        
        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
           
        if (!Auth::user()->permisos('tipoexamen','create')){
            
            return redirect(route('index'));
        }

        $obj_tipo_examen = new tipo_examen();
        $obj_tipo_examen->nombre_tipo_examen = $request->txttipoexamen;
        $obj_tipo_examen->save();

        return redirect(route('tipoexamen.index'))->withErrors(['status' => "Se creó el tipo de examen: "]);

    }

    public function update($id){

         if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
           
        if (!Auth::user()->permisos('tipoexamen','update')){
            
            return redirect(route('index'));
        }

        $resultado = tipo_examen::get()->where('id',$id);
        return view ("tipo_examen.update",  ["resultado"=>$resultado]);
        
    }

    public function save(Request $request){
        
        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
           
        if (!Auth::user()->permisos('tipoexamen','update')){
            
            return redirect(route('index'));
        }

        $obj_tipo_examen = tipo_examen::find($request->txtId);
        $obj_tipo_examen->nombre_tipo_examen = $request->txttipoexamen;
        $obj_tipo_examen->save();
        return redirect(route('tipoexamen.index'))->withErrors(['status' => "Se ha actualizado el tipo de examen" ]);

    }

    public function delete($id){

        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
           
        if (!Auth::user()->permisos('tipoexamen','delete')){
            
            return redirect(route('index'));
        }        
        
        $obj = tipo_examen::find($id);
        $obj->estado_tipo_examen =0;
        $obj->save();
        return redirect (route("tipoexamen.index"));

    }
    
    public function desbloquear($id){
        
        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }
           
        if (!Auth::user()->permisos('tipoexamen','delete')){
            
            return redirect(route('index'));
        }  

        $obj_tipo = tipo_examen::find($id);
        $obj_tipo->estado_tipo_examen = 1;
        $obj_tipo->save();
        return redirect(route('tipoexamen.index'))->withErrors(['status' => "Se ha desbloqueado el tipo de examen" ]);

    }

    
}
