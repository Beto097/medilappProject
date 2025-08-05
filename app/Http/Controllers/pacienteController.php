<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\paciente;
use App\Models\consulta;
use App\Models\rol;
use App\Models\User;
use Carbon\Carbon;

use Session;

class pacienteController extends Controller
{
    public function index(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/paciente')){
            if (Auth::user()->rol->tipo_rol == 1) {
            $resultado = paciente::orderBy('created_at', 'desc')->take(50)->get();
            } else {
            $resultado = paciente::where('estado_paciente', 1)
                ->orderBy('created_at', 'desc')
                ->take(50)
                ->get();
            }

            return view("paciente.index", ["resultado" => $resultado]);
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function create(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/paciente/create')){
                        

            return view ("paciente.create");
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function consultar($id){

        if (!Auth::user()) {

            return 'no tienes acceso';
        }

        $valor= array();
        $cedula = str_replace(' ','',trim($id));         
        $existe = paciente::where('identificacion_paciente',$cedula)->count();
        
        if($existe >0){
            $paciente = paciente::where('identificacion_paciente',$cedula)->first();            
            $edad = $paciente->edad();
            $valor= array("cedula"=>$cedula,"nombre"=>$paciente->nombre_paciente." ".$paciente->apellido_paciente,"edad"=>$edad,'consulta'=>$paciente->consultaActiva()); 
            return $valor;
        }
        
        return response()->json(['error' => 'Paciente no encontrado'], 404);
        
    }

    public function buscar(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/paciente')){                        
            

            return view ("paciente.buscar");
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function search(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/paciente')){        

            $keyWord = '%'.$request->txtBuscar.'%';

            return view("paciente.index", [
                'resultado' => paciente::latest()
    
                            ->where(function ($query) use ($keyWord){
                                $query->orWhere('identificacion_paciente', 'LIKE', $keyWord)
                                ->orWhere('nombre_paciente', 'LIKE', $keyWord)
                                ->orWhere('apellido_paciente', 'LIKE', $keyWord)
                                ->orWhere(DB::raw("CONCAT(nombre_paciente,' ',apellido_paciente)"), 'LIKE', str_replace(" ", "%", $keyWord));
                            
                            })
                            
                            ->get(),
                ]); 
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function insert(Request $request){
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }


        if(Auth::user()->accesoRuta('/paciente/create')){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas
                //esto ya estaba 
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
                $obj_paciente->estado_civil_paciente = $request->txtEstadoCivil;
                $obj_paciente->lugar_trabajo = $request->txtTrabajo;
                $obj_paciente->direccion_paciente = $request->txtDireccion;
                $obj_paciente->email_paciente =  strtolower($request->txtemail);
                $obj_paciente->comentario_paciente = nl2br($request->txtComentario);
                $obj_paciente->save();


                if($request->esModal){
                    if($request->esModal==2){
                        return redirect()->back()->with(['txtCedula'=>$request->txtCedula,'txtRegistro'=>$request->txtRegistro]);
                    }
                }
                return redirect()->back()->withErrors(['status' => "Se Agregó el Nuevo Paciente " .$obj_paciente->identificacion_paciente]); 
            }

        }
        
            
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);          
       

        
    }
    public function save(Request $request)
    {
        if (!Auth::user()) {
            Session::put('url', url()->current());
            return redirect(route('login.index'));
        }

        if (Auth::user()->accesoRuta('/paciente/update')) { // Validar acceso a la ruta
            $paciente = paciente::find($request->txtid);

            if (!$paciente) {
                return back()->withErrors(['status' => "¡El paciente no existe en el sistema!"]);
            }

            // Actualizar datos
            $paciente->identificacion_paciente = $request->txtCedula;
            $paciente->nombre_paciente = strtoupper($request->txtnombre);
            $paciente->apellido_paciente = strtoupper($request->txtapellido);
            $paciente->sexo_paciente = $request->txtsexo;
            $paciente->fecha_nacimiento_paciente = $request->txtfecnac;
            $paciente->telefono_paciente = $request->txttelefono;
            $paciente->estado_civil_paciente = $request->txtEstadoCivil;
            $paciente->lugar_trabajo = $request->txtTrabajo;
            $paciente->direccion_paciente = $request->txtDireccion;
            $paciente->email_paciente = strtolower($request->txtemail);
            $paciente->comentario_paciente = nl2br($request->txtComentario);
            $paciente->save();

            

            return redirect()->back()->withErrors(['status' => "Paciente " . $paciente->identificacion_paciente . " actualizado correctamente."]);
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }



    public function verHistorial($id){
        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }


        if(Auth::user()->accesoRuta('/paciente/historia/clinica')){//solo modificar la ruta buscar las rutas en web.php o el la tabla pantallas

            $paciente = paciente::find($id);

            if ($paciente->consultaActiva()) {


                $consulta = consulta::whereIn('estado_consulta', ['Pendiente', 'EN CURSO'])->where('paciente_id',$paciente->id)->first();

                return view('paciente.historial',['consulta'=>$consulta,'paciente'=>$paciente]);
            }

            return view('paciente.historial',['paciente'=>$paciente]);

        }
        
            
        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);          
       

        
    }
    public function ajaxBuscar(Request $request)
    {
        if (!Auth::user()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $q = $request->input('q', '');

        if (Auth::user()->rol->tipo_rol == 1) {
            $pacientes = paciente::where(function($query) use ($q) {
                    $query->where('identificacion_paciente', 'LIKE', $q . '%')
                        ->orWhere('nombre_paciente', 'LIKE', $q . '%')
                        ->orWhere('apellido_paciente', 'LIKE', $q . '%')
                        ->orWhere(DB::raw("CONCAT(nombre_paciente,' ',apellido_paciente)"), 'LIKE', $q . '%');
                })
                ->orderBy('created_at', 'desc')
                ->take(50)
                ->get();
        } else {
            $pacientes = paciente::where('estado_paciente', 1)
                ->where(function($query) use ($q) {
                    $query->where('identificacion_paciente', 'LIKE', $q . '%')
                        ->orWhere('nombre_paciente', 'LIKE', $q . '%')
                        ->orWhere('apellido_paciente', 'LIKE', $q . '%');
                })
                ->orderBy('created_at', 'desc')
                ->take(50)
                ->get();
        }

        $data = [];
        foreach ($pacientes as $fila) {
            $acciones = view('partials.paciente_acciones', compact('fila'))->render();

            $data[] = [
                $fila->id,
                $fila->identificacion_paciente,
                $fila->nombre_paciente . ' ' . $fila->apellido_paciente,
                $fila->sexo_paciente == 'm' ? '<span class="label label-primary">Masculino</span>' : '<span class="label label-info">Femenino</span>',
                $fila->edad(),
                $fila->telefono_paciente,
                $acciones
            ];
        }

        return response()->json(['data' => $data]);
    }
}
