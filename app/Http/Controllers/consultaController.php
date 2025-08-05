<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\consulta;
use App\Models\paciente;

use Session;

class consultaController extends Controller
{
    public function index(){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/consulta')){

            consulta::actualizarEstados();         


            if ((Auth::user()->accesoRuta('/consulta/all'))) {

               
                $resultado = consulta::whereNotIn('estado_consulta', ['ELIMINADA', 'CERRADA','CANCELADA'])
                    ->orderBy('created_at', 'DESC')
                    ->get();
                

            }elseif(Auth::user()->accesoRuta('/consulta/registrar')){   

                if (Auth::user()->sucursal) {                  
                    $resultado = consulta::whereIn('estado_consulta',['Pendiente','EN CURSO','TERMINADA'])
                    ->where('sucursal_id',Auth::user()->sucursal->id)
                    ->where('medico_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
                } else {
                    $resultado = consulta::where('estado_consulta','Pendiente')->get();
                }
                
                
            }else{

               if (Auth::user()->sucursal) {
                    $resultado = consulta::whereIn('estado_consulta',['Pendiente','EN CURSO','TERMINADA'])
                    ->where('sucursal_id',Auth::user()->sucursal->id)
                    ->orderBy('created_at','DESC')->get();
                } else {
                    $resultado = consulta::where('estado_consulta','Pendiente')->orWhere('estado_consulta','EN CURSO') ->orderBy('created_at','DESC')->get();
                }

            }          

            return view('consulta.index', ["resultado"=>$resultado]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

    }

    public function create2($id){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/consulta/create')){

            $obj_consulta = new consulta();        
            $obj_consulta->paciente_id=$id;
            $obj_consulta->estado_consulta = 'Pendiente';
            $obj_consulta->motivo_consulta = $request->selectMotivo === 'Otro' ? $request->txtOtroMotivo : $request->selectMotivo;
            $obj_consulta->usuario_id = Auth::user()->id;
            $obj_consulta->sucursal_id = Auth::user()->sucursal_id;      
            
            $obj_consulta->save();
            return redirect()->back()->withErrors(['status' => "Se ha creado la consulta para el paciente: " .$obj_consulta->paciente->identificacion_paciente ]);
            
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

    }

    public function insert(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/consulta/create')){  
            
            $paciente = paciente::where('identificacion_paciente',$request->txtCedula)->first();

            $edad = $paciente->edad();

            if ($edad<18) {

                $obj_consulta->responsable_menor = $request->txtNombre;
                $obj_consulta->parentesco_menor = $request->txtParentesco;
 
            }

            $obj_consulta = new consulta();        
            $obj_consulta->paciente_id=$paciente->id;
            $obj_consulta->estado_consulta = 'Pendiente';
            $obj_consulta->motivo_consulta = $request->selectMotivo === 'Otro' ? $request->txtOtroMotivo : $request->selectMotivo;
            $obj_consulta->usuario_id = Auth::user()->id;
            $obj_consulta->sucursal_id = Auth::user()->sucursal_id;  

            $obj_consulta->save();



            return redirect()->back()->withErrors(['status' => "Se ha creado la consulta para el paciente: " .$obj_consulta->paciente->identificacion_paciente ]);

        }



    }

    public function doctor(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/consulta/create')){

            $obj_consulta = new consulta();   
            $obj_consulta->paciente_id= $request->paciente_id;
            $obj_consulta->estado_consulta = 'Pendiente';   
            $obj_consulta->motivo_consulta = $request->selectMotivo === 'Otro' ? $request->txtOtroMotivo : $request->selectMotivo;
            $obj_consulta->sucursal_id = Auth::user()->sucursal_id; 
            $obj_consulta->medico_id =  $request->selectMedico;
            
            if ($request->tipo == 'menor') {
                $obj_consulta->responsable_menor = $request->txtNombre;
                $obj_consulta->parentesco_menor = $request->txtParentesco;
            }
                 
            $obj_consulta->save();
            return redirect()->back()->withErrors(['status' => "Se ha creado la consulta para el paciente: " .$obj_consulta->paciente->identificacion_paciente ]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

    }

    public function reasignar(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }


        if(Auth::user()->accesoRuta('/consulta/reasignar')){

            $obj_consulta = consulta::find($request->consulta_id);       
            $obj_consulta->medico_id =  $request->selectMedico;
            
           
            $obj_consulta->save();
            return redirect()->back()->withErrors(['status' => "Se ha reasignado la consulta para el paciente: " .$obj_consulta->paciente->identificacion_paciente ]);
            
        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);

    }

    public function iniciar($id){


        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/consulta')){

            $consulta = consulta::find($id);
            $paciente = paciente::find($consulta->paciente->id);

            return view('consulta.iniciar',['consulta'=>$consulta,'paciente'=>$paciente]);
        }
    }

    public function save(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }


        if(Auth::user()->accesoRuta('/consulta/registrar')){   


            
            $consulta = consulta::find($request->txtConsultaId);
            $consulta->fecha_consulta = $request->txtFecha;
            if ($consulta->medico_id == null) {
                $consulta->medico_id = Auth::user()->id;
            }
            $consulta->frecuencia_respiratoria = $request->txtFrecR;
            $consulta->frecuencia_cardiaca = $request->txtFrecC;
            $consulta->presion_arterial = $request->txtPresA;
            $consulta->temperatura = $request->txtTemp;
            $consulta->saturacion_oxigeno = $request->txtSatO;
            $consulta->historia_clinica = $request->txtHistoriaClinica;
            $consulta->examen_fisico = $request->txtExamenFisico;
            $consulta->talla = $request->txtTalla;
            $consulta->peso = $request->txtPeso;
            $consulta->laboratorios_examenes = $request->txtLaboratoriosExamenes;
            $consulta->alergias = $request->txtAlergias;
            $consulta->medicinas = $request->txtMedicamentos;
            $consulta->diagnostico = $request->txtDiagnostico;
            $consulta->recomendaciones = $request->txtRecomendaciones;

            $paciente = paciente::find($consulta->paciente_id);

            $paciente->alergias = $request->txtAlergias;
            $paciente->medicinas = $request->txtMedicamentos;


            $paciente->save();

            $consulta->estado_consulta = 'EN CURSO';

            if ($request->accion == 'terminar') {
                $consulta->estado_consulta = 'TERMINADA';
                $consulta->motivo_consulta = 'ATENDIDO';
            }
            
            $consulta->save();

            return redirect()->back()->withErrors(['status' => "Se ha guardo la consulta correctamente"]);

        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function delete($id){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        if(Auth::user()->accesoRuta('/consulta/delete')){               


            $consulta = consulta::find($id);
            $consulta->estado_consulta = 'ELIMINADA';
            $consulta->save();

            return redirect()->back()->withErrors(['danger' => "Se ha elimino la consulta correctamente"]);

        }

        return redirect()->back()->withErrors(['danger' => "No tienes acceso a esta funcion." ]);
    }

    public function select(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        // Validar que se haya enviado el documento
        if (!$request->selectDocumento || !$request->txtId) {
            return back()->with('error', 'Debe seleccionar un documento válido.');
        }

        // Para recetas, usar la versión simple (pdf.blade.php)
        if ($request->selectDocumento == 'receta') {
            return redirect(route('receta.print', ['id' => $request->txtId]));
        } elseif ($request->selectDocumento == 'certificado') {
            return redirect(route('certificado.print', ['id' => $request->txtId]));
        } elseif ($request->selectDocumento == 'constancia') {
            return redirect(route('constancia.print', ['id' => $request->txtId]));
        } elseif ($request->selectDocumento == 'referencia') {
            return redirect(route('referencia.print', ['id' => $request->txtId]));
        } else {
            return back()->with('error', 'Tipo de documento no válido.');
        }
    }

    public function selectToPrint(Request $request){

        if (!Auth::user()) {

            Session::put('url', url()->current());    
            return redirect(route('login.index'));
        }

        // Validar que se haya enviado el documento
        if (!$request->selectDocumento || !$request->txtId) {
            return back()->with('error', 'Debe seleccionar un documento válido.');
        }

        // Para recetas, usar la versión completa (pdfCompleto.blade.php)
        if ($request->selectDocumento == 'receta') {
            return redirect(route('receta.printCompleto', ['id' => $request->txtId]));
        } elseif ($request->selectDocumento == 'certificado') {
            return redirect(route('certificado.print', ['id' => $request->txtId]));
        } elseif ($request->selectDocumento == 'constancia') {
            return redirect(route('constancia.print', ['id' => $request->txtId]));
        } elseif ($request->selectDocumento == 'referencia') {
            return redirect(route('referencia.print', ['id' => $request->txtId]));
        } else {
            return back()->with('error', 'Tipo de documento no válido.');
        }
    }
}
