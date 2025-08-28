<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\examen;
use App\Models\tipo_examen;
use App\Models\caracteristica_examen;
use App\Models\examen_caracteristica_examen;
use Session;
use Illuminate\Support\Facades\Auth;

class examenController extends Controller
{
    public function index(){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen')){
            $resultado = examen::where('estado_examen',1)->where('es_principal','<>',0)->get(); 
    
            $grupos = examen_caracteristica_examen::groupBy('examen_id')
                            ->selectRaw('count(*) as total, examen_id')
                            ->get();              
           
            return view('examen.index', ["resultado"=>$resultado, "grupos"=>$grupos]);                             
        }

        return redirect(route('index'));
    }

    public function crear(){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/create')){
            $tipo_examenes = tipo_examen::where('estado_tipo_examen',1)->get();
            return view("examen.create",["tipo_examenes"=>$tipo_examenes]);
        }

        return redirect(route('index'));
    }

    public function insert(Request $request){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/create')){
            try {
                if($request->cbxTipoExamen == 0){
                    $obj_tipo_examen = new tipo_examen();
                    $obj_tipo_examen->nombre_tipo_examen = $request->txtNombre;
                    $obj_tipo_examen->estado_tipo_examen = 0;
                    $detalle_examen = $request->txtDescripcion;
                    $detalle_examen = str_replace("<","	&lt;",$detalle_examen);
                    $detalle_examen = str_replace(">","	&gt;",$detalle_examen);
                    $detalle_examen = str_replace("↑",'<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',$detalle_examen);
                    $detalle_examen = str_replace("↓",'<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',$detalle_examen);
                    $obj_tipo_examen->detalle_tipo_examen = nl2br($detalle_examen);                                            
                    $obj_tipo_examen->save();

                    $obj_examen = new examen(); 
                    $obj_examen->nombre_examen = $request->txtNombre;                    
                    $obj_examen->tipo_examen_id = $obj_tipo_examen->id;
                    $obj_examen->tiene_referencia =$request->cbxReferencia;
                    $detalle_examen = $request->txtDescripcion;
                    $detalle_examen = str_replace("<","	&lt;",$detalle_examen);
                    $detalle_examen = str_replace(">","	&gt;",$detalle_examen);
                    $detalle_examen = str_replace("↑",'<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',$detalle_examen);
                    $detalle_examen = str_replace("↓",'<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',$detalle_examen);
                    $obj_examen->detalle_examen = nl2br($detalle_examen);
                    $obj_examen->es_principal = 2;                        
                    $obj_examen->save();
                } else {
                    $obj_examen = new examen(); 
                    $obj_examen->nombre_examen = $request->txtNombre;                    
                    $obj_examen->tipo_examen_id = $request->cbxTipoExamen;
                    $obj_examen->tiene_referencia = $request->cbxReferencia;
                    $detalle_examen = $request->txtDescripcion;
                    $detalle_examen = str_replace("<","	&lt;",$detalle_examen);
                    $detalle_examen = str_replace(">","	&gt;",$detalle_examen);    
                    $detalle_examen = str_replace("↑",'<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',$detalle_examen);
                    $detalle_examen = str_replace("↓",'<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',$detalle_examen);
                    $obj_examen->detalle_examen =nl2br($detalle_examen);                   
                    $obj_examen->es_principal = 1; 
                    
                    if(isset($request->ckbReferencia)){
                        $obj_examen->tiene_referencia=1;
                    } else {
                        $obj_examen->tiene_referencia=0;
                    }
                    
                    if (isset($request->ckbExterno)) {
                        $obj_examen->es_externo = 1;
                    } else {
                        $obj_examen->es_externo = 0;
                    }  
                    
                    $obj_examen->save();
                    
                    if ($obj_examen->es_externo == 1) {
                        $es_impreso = caracteristica_examen::where('nombre_caracteristica_examen','Documento_impreso')->first();
                        if($es_impreso) {
                            $caracteristica = new examen_caracteristica_examen();
                            $caracteristica->examen_id = $obj_examen->id;
                            $caracteristica->caracteristica_examen_id =$es_impreso->id;
                            $caracteristica->num_orden = 1;
                            $caracteristica->save();
                        }
                        return redirect(route('examen.index'))->with('status', 'El examen se guardó correctamente');
                    }
                }
                
                return redirect()->route('examen.crear2', ['id' => $obj_examen->id]);
                
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Error al crear el examen: ' . $e->getMessage()])->withInput();
            }
        }

        return redirect(route('index'));
    }
    public function crear2($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/create')){
            $examen = examen::find($id);
            if (!$examen) {
                return redirect(route('examen.index'))->withErrors(['error' => 'Examen no encontrado.']);
            }
            
            $caracteristicas_examen = caracteristica_examen::where('estado_caracteristica_examen',1)->orderBy('nombre_caracteristica_examen')->get();
            $caracteristicas = examen_caracteristica_examen::where('examen_id',$id)->get();
            
            $lista_caracteristicas = array();
            foreach($caracteristicas as $caracteristica){
                array_push($lista_caracteristicas,$caracteristica->caracteristica_examen_id);
            }
        
            return view("examen.create2",["lista_caracteristicas"=>$lista_caracteristicas,"caracteristicas_examen"=>$caracteristicas_examen,"id_examen"=>$id]);
        }

        return redirect(route('index'));
    }

    public function update($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/update')){
            $examen = examen::find($id);
            if (!$examen) {
                return redirect(route('examen.index'))->withErrors(['error' => 'Examen no encontrado.']);
            }
            
            $tipo_examenes = tipo_examen::where('estado_tipo_examen',1)->get();
            $detalle_examen = $examen->detalle_examen;
            $detalle_examen = str_replace("<br />","",$detalle_examen);
            $detalle_examen = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',"↓",$detalle_examen);
            $detalle_examen = str_replace('<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',"↑",$detalle_examen);
            $detalle_examen = str_replace('&lt;',"<",$detalle_examen);
            $detalle_examen = str_replace('&gt;',">",$detalle_examen);

            return view("examen.update", ["tipo_examenes"=>$tipo_examenes,"examen"=>$examen,"detalle_examen"=>$detalle_examen]);
        }

        return redirect(route('index'));
    }

    public function update2($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/update')){
            $examen = examen::find($id);
            if (!$examen) {
                return redirect(route('examen.index'))->withErrors(['error' => 'Examen no encontrado.']);
            }
            
            $caracteristicas_examen = caracteristica_examen::where('estado_caracteristica_examen',1)->orderBy('nombre_caracteristica_examen')->get();
            $caracteristicas = examen_caracteristica_examen::where('examen_id',$id)->get();
            
            $lista_caracteristicas = array();
            foreach($caracteristicas as $caracteristica){
                array_push($lista_caracteristicas,$caracteristica->caracteristica_examen_id);
            }
        
            return view("examen.create2",["lista_caracteristicas"=>$lista_caracteristicas,"caracteristicas_examen"=>$caracteristicas_examen,"id_examen"=>$id]);
        }

        return redirect(route('index'));
    }

    public function save(Request $request){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/update')){
            try {
                $obj_examen = examen::find($request->txtid);
                if (!$obj_examen) {
                    return redirect(route('examen.index'))->withErrors(['error' => 'Examen no encontrado.']);
                }
                
                $obj_examen->nombre_examen = $request->txtNombre;
                $obj_examen->tipo_examen_id = $request->cbxTipoExamen;
                $detalle_examen = $request->txtDescripcion;
                $detalle_examen = str_replace("<","	&lt;",$detalle_examen);
                $detalle_examen = str_replace(">","	&gt;",$detalle_examen);    
                $detalle_examen = str_replace("↑",'<span style="font-family: DejaVu Sans, sans-serif;">&uarr;</span>',$detalle_examen);
                $detalle_examen = str_replace("↓",'<span style="font-family: DejaVu Sans, sans-serif;">&darr;</span>',$detalle_examen);
                $obj_examen->detalle_examen = nl2br($detalle_examen);
                
                if(isset($request->cbxReferencia)){
                    $obj_examen->tiene_referencia = 1;
                } else {
                    $obj_examen->tiene_referencia = 0;
                }
                
                if (isset($request->ckbExterno)) {
                    $obj_examen->es_externo = 1;
                } else {
                    $obj_examen->es_externo = 0;
                }  
                
                $obj_examen->save();
                
                if ($obj_examen->es_externo == 1) {                        
                    return redirect(route('examen.index'))->with('status', 'El examen se guardó correctamente');
                }
                
                return redirect()->route('examen.update2', ['id' => $obj_examen->id]);
                
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Error al actualizar el examen: ' . $e->getMessage()])->withInput();
            }
        }

        return redirect(route('index'));
    }

    public function delete($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/delete')){
            $examen = examen::find($id);
            if (!$examen) {
                return redirect(route('examen.index'))->withErrors(['error' => 'Examen no encontrado.']);
            }
            
            $examen->estado_examen = 0;
            $examen->save();
            
            return redirect(route('examen.index'))->with('status', 'Se eliminó el examen correctamente');
        }
            
        return redirect(route('index'));
    }


    public function insert2(Request $request){ 
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/create')){
            try {
                $examen = examen::find($request->txtid);
                if (!$examen) {
                    return redirect(route('examen.index'))->withErrors(['error' => 'Examen no encontrado.']);
                }
                
                if($examen->es_principal == 2){
                    DB::table('examen_caracteristica_examen')->where('examen_id', '=', $request->txtid)->delete();
                    foreach($request->caracteristicas_id as $key=>$caracteristica){ 
                        $obj_caracteristica = new examen_caracteristica_examen();
                        $obj_caracteristica->examen_id = $examen->id;
                        $obj_caracteristica->num_orden = $key;
                        $obj_caracteristica->caracteristica_examen_id = $caracteristica;
                        $obj_caracteristica->save();

                        $caracteristica_examen = caracteristica_examen::find($caracteristica);
                        if($caracteristica_examen) {
                            $obj_examen = new examen();
                            $obj_examen->nombre_examen = $caracteristica_examen->nombre_caracteristica_examen;                    
                            $obj_examen->tipo_examen_id = $examen->tipo_examen_id;
                            $obj_examen->tiene_referencia = $examen->tiene_referencia;
                            $obj_examen->detalle_examen = $examen->detalle_examen;
                            $obj_examen->es_principal = 0; 
                            $obj_examen->padre = $examen->id;
                            $obj_examen->save();

                            $obj_caracteristica = new examen_caracteristica_examen();
                            $obj_caracteristica->examen_id = $obj_examen->id;
                            $obj_caracteristica->num_orden = $key;
                            $obj_caracteristica->caracteristica_examen_id = $caracteristica;
                            $obj_caracteristica->save();
                        }
                    }  
                } else {
                    DB::table('examen_caracteristica_examen')->where('examen_id', '=', $request->txtid)->delete();
                    foreach($request->caracteristicas_id as $key=>$caracteristica){ 
                        $obj_caracteristica = new examen_caracteristica_examen();
                        $obj_caracteristica->examen_id = $request->txtid;
                        $obj_caracteristica->num_orden = $key;
                        $obj_caracteristica->caracteristica_examen_id = $caracteristica;
                        $obj_caracteristica->save();
                    }  
                }
                
                return redirect()->route('examen.crear3', ['id' => $request->txtid]);
                
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Error al guardar características: ' . $e->getMessage()])->withInput();
            }
        }

        return redirect(route('index'));
    }

    public function save2(Request $request){   
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/update')){
            try {
                $examen = examen::find($request->txtid);
                if (!$examen) {
                    return redirect(route('examen.index'))->withErrors(['error' => 'Examen no encontrado.']);
                }
                
                if($examen->es_principal == 2){
                    DB::table('examen_caracteristica_examen')->where('examen_id', '=', $examen->id)->delete();
                    $examenes = examen::where('padre',$examen->id)->get();
                    $lista_examenes = array();
                    foreach($examenes as $fila){
                        array_push($lista_examenes,$fila->id);
                    }
                    
                    foreach($lista_examenes as $fila){
                        DB::table('examen_caracteristica_examen')->where('examen_id',$fila)->delete();
                        DB::table('examen')->where('id',$fila)->delete();
                    }
                    
                    foreach($request->caracteristicas_id as $key=>$caracteristica){ 
                        $obj_caracteristica = new examen_caracteristica_examen();
                        $obj_caracteristica->examen_id = $examen->id;
                        $obj_caracteristica->num_orden = $key;
                        $obj_caracteristica->caracteristica_examen_id = $caracteristica;
                        $obj_caracteristica->save();

                        $caracteristica_examen = caracteristica_examen::find($caracteristica);
                        if($caracteristica_examen) {
                            $obj_examen = new examen();
                            $obj_examen->nombre_examen = $caracteristica_examen->nombre_caracteristica_examen;                    
                            $obj_examen->tipo_examen_id = $examen->tipo_examen_id;
                            $obj_examen->tiene_referencia = $examen->tiene_referencia;
                            $obj_examen->es_principal = 0; 
                            $obj_examen->detalle_examen = $examen->detalle_examen;
                            $obj_examen->padre = $examen->id;
                            $obj_examen->save();

                            $obj_caracteristica = new examen_caracteristica_examen();
                            $obj_caracteristica->examen_id = $obj_examen->id;
                            $obj_caracteristica->num_orden = $key;
                            $obj_caracteristica->caracteristica_examen_id = $caracteristica;
                            $obj_caracteristica->save();
                        }
                    }  
                } else {
                    DB::table('examen_caracteristica_examen')->where('examen_id', '=', $request->txtid)->delete();
                    foreach($request->caracteristicas_id as $key=>$caracteristica){ 
                        $obj_caracteristica = new examen_caracteristica_examen();
                        $obj_caracteristica->examen_id = $request->txtid;
                        $obj_caracteristica->num_orden = $key;
                        $obj_caracteristica->caracteristica_examen_id = $caracteristica;
                        $obj_caracteristica->save();
                    }  
                } 
                
                return redirect()->route('examen.crear3', ['id' => $request->txtid]);
                
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Error al guardar características: ' . $e->getMessage()])->withInput();
            }
        }
        
        return redirect(route('index'));
    }

    public function crear3($id){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/create')){
            $examen = examen::find($id);
            if (!$examen) {
                return redirect(route('examen.index'))->withErrors(['error' => 'Examen no encontrado.']);
            }
            
            $caracteristicas = examen_caracteristica_examen::where('examen_id',$id)->orderBy('num_orden')->get();
            return view("examen.create3",['caracteristicas'=>$caracteristicas,"examen_id"=>$id]); 
        }

        return redirect(route('index'));
    }

    public function insert3(Request $request){
        if (!Auth::user()) {
            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/examen/create') || Auth::user()->accesoRuta('/examen/update')){
            try {
                if ($request->inputOrden != null) {
                    $ListaDeID = explode(",", $request->inputOrden); 
                    
                    $examen = examen::find($request->examen_id);
                    if (!$examen) {
                        return redirect(route('examen.index'))->withErrors(['error' => 'Examen no encontrado.']);
                    }
                    
                    if($examen->es_principal == 2){
                        $examenes = examen::where('padre',$examen->id)->get();
                        $lista_examenes = array();
                        foreach($examenes as $fila){
                            array_push($lista_examenes,$fila->id);
                        }

                        foreach($ListaDeID as $key=>$id){
                            examen_caracteristica_examen::where('examen_id',$request->examen_id)
                                                        ->where('caracteristica_examen_id',$id)
                                                        ->update(['num_orden' => $key]);
                            
                            foreach($lista_examenes as $fila_1){
                                examen_caracteristica_examen::where('examen_id',$fila_1)
                                                        ->where('caracteristica_examen_id',$id)
                                                        ->update(['num_orden' => $key]);
                            }
                        }
                    } else {
                        foreach($ListaDeID as $key=>$id){
                            examen_caracteristica_examen::where('examen_id',$request->examen_id)
                                                        ->where('caracteristica_examen_id',$id)
                                                        ->update(['num_orden' => $key]);
                        }
                    }
                }
                
                return redirect(route('examen.index'))->with('status', 'El examen se guardó correctamente');
                
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Error al actualizar orden: ' . $e->getMessage()])->withInput();
            }
        }

        return redirect(route('index'));
    }    

}
