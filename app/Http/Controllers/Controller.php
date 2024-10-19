<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\rol;
use App\Models\medico;
use App\Models\company;
use App\Models\pantalla;
use App\Models\paciente;
use App\Models\notificacion;
use App\Models\rol_pantalla;
use App\Models\orden_laboratorio;
use App\Models\examen_orden_laboratorio;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index(){

        if (!Auth::user()) {

            $current = url()->current();
            Session::put('url', $current); 
            return redirect(route('login.index'));

        }         

            
        //return Session::get('usuario_rol_id');
        $rol = rol::where('id',Auth::user()->rol_id)
                                        ->where('tipo_rol',1)                                            
                                        ->count();
        
        
        
                                       
        if(true){

            $nuevospacientes = paciente::where('created_at','>',Carbon::today()->subMonth(1)->toDateString())->count();
            $ordenes_totales_mes = orden_laboratorio::where('estado_orden_laboratorio','<>','Eliminado')
                                                ->where('fecha_orden','>',Carbon::today()->subMonth(1)->toDateString())
                                                ->count();
            $examenes_totales_mes = examen_orden_laboratorio::where('padre','<',1)
                                                ->where('created_at','>',Carbon::today()->subMonth(1)->toDateString())
                                                ->count();
            $total_pacientes = paciente::where('estado_paciente',1)->count();

            

            $examenes = orden_laboratorio::where('estado_orden_laboratorio','<>','Eliminado')
                                        ->where('fecha_orden','>',Carbon::today()->subMonth(1)->toDateString())
                                        ->groupBy('medico_id')
                                        ->selectRaw('count(*) as total, medico_id,CAST((RAND()*100)+156 as UNSIGNED) as A,CAST((RAND()*100)+156 as UNSIGNED) as B')
                                        ->get();

            return view('index',[   'nuevos_pacientes'=>$nuevospacientes,
                                    'ordenes_totales_mes'=>$ordenes_totales_mes,
                                    'examenes_totales_mes' => $examenes_totales_mes,
                                    'total_pacientes' => $total_pacientes,
                                    'examenes' => $examenes
                                ]);
            $ordenes_totales = orden_laboratorio::where('estado_orden_laboratorio','<>','Eliminado')
                                                ->where('fecha_orden',Carbon::today()->toDateString())
                                                ->count();
            $ordenes_totales_mes = orden_laboratorio::where('estado_orden_laboratorio','<>','Eliminado')
                                                ->where('fecha_orden','>',Carbon::today()->subWeek(4)->toDateString())
                                                ->count();
            
            $ordenes_terminadas_mes = orden_laboratorio::where('estado_orden_laboratorio','Terminado')
                                                ->where('fecha_orden','>',Carbon::today()->subWeek(4)->toDateString())
                                                ->count();
            $porcentaje_terminado_mes = ($ordenes_terminadas_mes/$ordenes_totales_mes)*100;
            $ordenes_enproceso_mes = orden_laboratorio::where('estado_orden_laboratorio','En Proceso')
                                                    ->where('fecha_orden','>',Carbon::today()->subWeek(4)->toDateString())
                                                    ->count();
            $porcentaje_enproceso_mes = ($ordenes_enproceso_mes/$ordenes_totales_mes)*100;
            $ordenes_pendientes_mes = orden_laboratorio::where('estado_orden_laboratorio','Pendiente')
                                                    ->where('fecha_orden','>',Carbon::today()->subWeek(4)->toDateString())
                                                    ->count();
            $porcentaje_pendiente_mes = ($ordenes_pendientes_mes/$ordenes_totales_mes)*100;
            
            if($ordenes_totales==0){
                return view("dashboard.index",["ordenes_totales"=>0,
                                            "ordenes_terminadas"=>0,
                                            "porcentaje_terminado"=>100,
                                            "ordenes_enproceso"=>0,
                                            "porcentaje_enproceso"=>100,
                                            "ordenes_pendientes"=>0,
                                            "porcentaje_pendiente"=>100,
                                            "ordenes_totales_mes"=>$ordenes_totales_mes,
                                            "ordenes_terminadas_mes"=>$ordenes_terminadas_mes,
                                            "porcentaje_terminado_mes"=>$porcentaje_terminado_mes,
                                            "ordenes_enproceso_mes"=>$ordenes_enproceso_mes,
                                            "porcentaje_enproceso_mes"=>$porcentaje_enproceso_mes,
                                            "ordenes_pendientes_mes"=>$ordenes_pendientes_mes,
                                            "porcentaje_pendiente_mes"=>$porcentaje_pendiente_mes]);
            }
            $ordenes_terminadas = orden_laboratorio::where('estado_orden_laboratorio','Terminado')
                                                    ->where('fecha_orden',Carbon::today()->toDateString())
                                                    ->count();
            $porcentaje_terminado = ($ordenes_terminadas/$ordenes_totales)*100;
            $ordenes_enproceso = orden_laboratorio::where('estado_orden_laboratorio','En Proceso')
                                                    ->where('fecha_orden',Carbon::today()->toDateString())
                                                    ->count();
            $porcentaje_enproceso = ($ordenes_enproceso/$ordenes_totales)*100;
            $ordenes_pendientes = orden_laboratorio::where('estado_orden_laboratorio','Pendiente')
                                                    ->where('fecha_orden',Carbon::today()->toDateString())
                                                    ->count();
            $porcentaje_pendiente = ($ordenes_pendientes/$ordenes_totales)*100;
            
            
            return view("dashboard.index",["ordenes_totales"=>$ordenes_totales,
                                            "ordenes_terminadas"=>$ordenes_terminadas,
                                            "porcentaje_terminado"=>$porcentaje_terminado,
                                            "ordenes_enproceso"=>$ordenes_enproceso,
                                            "porcentaje_enproceso"=>$porcentaje_enproceso,
                                            "ordenes_pendientes"=>$ordenes_pendientes,
                                            "porcentaje_pendiente"=>$porcentaje_pendiente,
                                            "ordenes_totales_mes"=>$ordenes_totales_mes,
                                            "ordenes_terminadas_mes"=>$ordenes_terminadas_mes,
                                            "porcentaje_terminado_mes"=>$porcentaje_terminado_mes,
                                            "ordenes_enproceso_mes"=>$ordenes_enproceso_mes,
                                            "porcentaje_enproceso_mes"=>$porcentaje_enproceso_mes,
                                            "ordenes_pendientes_mes"=>$ordenes_pendientes_mes,
                                            "porcentaje_pendiente_mes"=>$porcentaje_pendiente_mes]);
        }
        
        return view("welcome");
       
        
    }

    public static function pantallasMenuXUsuario(){
        
        $pantallas_rol = rol_pantalla::where('rol_id',Auth::user()->rol->id)->get();
        $lista = array();
        
        foreach($pantallas_rol as $pantalla_rol){
            array_push($lista,$pantalla_rol->pantalla->id);
        }
        

        $pantallas = pantalla::whereIn('id',$lista)->get();
       
        return $pantallas;

    }

    public static function validarPermiso($url){
        
        $pantallas = Controller::urlsPantallasXUsuario();
        
        if (in_array($url,$pantallas)){
            return true;
        }
        return false;

    }


    public static function urlsPantallasXUsuario(){

        
        $pantallas_rol = rol_pantalla::where('rol_id',Auth::user()->rol_id)->get();
        $lista = array();

        foreach($pantallas_rol as $pantalla_rol){
            array_push($lista,$pantalla_rol->pantalla->url_pantalla);
        }
        

        
       
        return $lista;

    }
    public static function notificaciones(){

        $notificaciones_sin_leer = notificacion::where('notifiable_id',Session::get('usuario_log_id'))->whereNull('read_at')->orderBy('created_at','desc')->get();
        
        return $notificaciones_sin_leer;
        
            
        
    }

    public static function cantidadNotificaciones(){

        $cantidad = notificacion::whereNull('read_at')
                                    ->where('notifiable_id',Session::get('usuario_log_id'))
                                    ->count();
        
        return $cantidad;
        
            
        
    }

    public function acceso(){
        return redirect(route('login.index'));

        if (!Auth::user()) {

            
        }
    }

    /* public static function permisos($ruta,$permiso){

        $pantalla_rol = Controller::urlsPantallasXUsuario();
       
        foreach ($pantalla_rol as $pantalla) {

            
            
            if (str_contains($pantalla, $ruta)&& str_contains($pantalla, $permiso)) {
                return true;
            } 
           
            
            // if ('/ordenesLaboratorio/ver'==$pantalla || '/ordenesLaboratorio'==$pantalla  ) {
            //     $permisos['ver']=0;
            //     if($ruta == 'orden_laboratorio' || $ruta == 'resultado'){
            //         $permisos['ver']=1;
            //     } 
            // }            
            
            
        }  
        return false;
            
        
    } */

    public static function generaPassword($longitud){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $longitud; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function consultar($cedula){
        $valor= array();
        $existe = paciente::where('identificacion_paciente',$cedula)->count();
        if($existe ==1){
            $paciente = paciente::where('identificacion_paciente',$cedula)->first();
            $valor= array("cedula"=>$cedula,"nombre"=>$paciente->nombre_paciente." ".$paciente->apellido_paciente); 
            
        }

        return $valor;
    }

    public function consultarRegistro($registro){
        $valor= array();
        $existe = medico::where('numero_registro',$registro)->count();
        if($existe ==1){
            $medico = medico::where('numero_registro',$registro)->first();
            $valor= array("registro"=>$registro,"nombre"=>$medico->nombre_medico); 
            
        }

        return $valor;
    }

    public function notificacionBorrarTodas(){
        $notificaciones = notificacion::where('notifiable_id',Session::get('usuario_log_id'))->get();
        foreach ($notificaciones as $notificacion) {
            $notificacion->delete();
        }
        return redirect()->back()->withErrors(['status' => "Las Notificaciones fueron borradas" ]);
    }


    public function generarPassword(){


        
        $string = "";
        $string .= Controller::listaCaracteres();
        $string .= Controller::listaNumeros();
        $string .= Controller::listaEspeciales();
        $password = "";
        $length = strlen($string)-1;

        for ($i=0; $i < 63; $i++) { 
            
            $password .= $string[rand(0,$length)]; 

        }

        
        return $password;
    }


    public function listaCaracteres(){

        return "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

    }

    public function listaNumeros(){

        return "12345678901234567890";

    }

    public function listaEspeciales(){

        return "";

    }

    public function ordenCliente($id){

        $orden = orden_laboratorio::where('token',$id)->first();

        return $orden;
    }

    public function seleccionarCompany($id){

        if($id==0){

            Session::forget('dataBaseName');
            return redirect(route('index'));
        }

        $company = company::find($id);
        
        Session::put('dataBaseName', $company->database_name); 
        Session::put('companyName', $company->company_name); 
        return redirect()->back();
    }

    public function prueba(Request $request){

        $jsondata = '{
            "PAC": {
                "usuario": "844084-1-504061",
                "pass": "pruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebapruebaprueba",
                "QR": "CEA4A5457603B609E05349D1950A8972CEA4A5457604B609E05349D1950A8972CEA4A5457605B609E05349D1950A8972CEA4A5457606B609E05349D1950A8972"
            },
            "conf": {
                "cer": "QmFnIEF0dHJpYnV0ZXMKICAgIGZyaWVuZGx5TmFtZTogY249W0ZdIEZPUk1VTEFSSU9TIENPTUVSQ0lBTEVTIFNBIC0gODQ0MDg0LTEtNTA0MDYxIC0gMDAgLSBDSEFOSVMgVEVKQURBIE1BTlVFTCBSSUNBUkRPLG91PUZBQ1RVUkEgRUxFQ1RST05JQ0Esbz1GSVJNQSBFTEVDVFJPTklDQSxjPVBBIE5vbi1yZXB1ZGlhdGlvbiBLZXkKICAgIGxvY2FsS2V5SUQ6IDI5IEY1IDNGIDM1IDIxIDFFIDA0IEUwIDJEIEIyIDRDIDk1IEFBIDhDIEJFIEUwIApLZXkgQXR0cmlidXRlczogPE5vIEF0dHJpYnV0ZXM+Ci0tLS0tQkVHSU4gRU5DUllQVEVEIFBSSVZBVEUgS0VZLS0tLS0KTUlJRkRqQkFCZ2txaGtpRzl3MEJCUTB3TXpBYkJna3Foa2lHOXcwQkJRd3dEZ1FJTHQ0T0pUS1hCbUVDQWdnQQpNQlFHQ0NxR1NJYjNEUU1IQkFnRzc1R21xL3Q2NkFTQ0JNanJvY0ZoNWxERkNaWmYwbGp0cCtCM0xWeHg5cDVtCkZKVmdacGZBL3dva3djbXI5YUpCQjFjUlhvbDhZTkE0c2xZdUV2Uk1RTEk5S3BqaElLelpjWjJVaXBxbVV2OTMKTXJjcjFZaG1GY1U1cVJ5eFQyVExRTGlneHNNa0ZiTG9TZy9rNmcrOW9STnd0bFlGRy9oZktwa1NEWXRMdEhYTApaY2FCMTcralY2NHl0WG1WR290YzlTdVBzaFk2NnlvcXhYdVo2UWVudm5YNmk5N2NwVHI5QlAybkdtbFZyNVBJCm1YbG45TVNWVmtYRW82YWdMT1FxTjJZeUt0S3ZlQjZZOFV1UFoycnVnNzZiVUhPb0doY1hyV25qQUQrMi9ibDAKQ2VzTkttMldoS0MrbXBiV0RlUmlwR053NGM1aGE0eGRVS29NRXFwYVhWUU9admtQbjg2VGFlbzd6dXJMYWhPdQppOTJnSHFHcGtsMFowREpoMmJjZXVyTXBVV2g3OWNXUWoxZU5MRWVaeXozUXVxYUtIVFFIdFRzcnhNbjdiQm85CndqUTI3SU9YYXJHY2pZNTBPUkk2VG9UR05wTUpMNndwRFVTdllZT2dJZ1h5d296QzFHeDNKdWJqcmFsZ2plcjgKVGkzelpwY2tRUFBIdjNxZllTZDRBbHE0OGc1dGJKV0VGR3QyQVZYQnA2YTRFMTNtdlNpVjk5R2tUUnNJNDZaQwp1NStDZStiNzlkTDZsaGJPVGgva3o2UFBTcEoyNUhjVG1iRHIzR1F5bS9ML0JoQitiZEpCTTNVQVhzVEx1R3d2ClMxVjBTS040UytWVGlxMG12L2x1ZFZlOGxpa1ZXNmtpbVBnUWVQNFJLL1RKdEpCK3l4RDNtQ05oU1AyN05EOE0KejJHRGJ0MU9Rb0JKaTh2a3VJNnZsb3FJVGZJNlBOVFFDc1Y2Z1p0M2NUYUltU1lQa2QrOVhFNytyVFZuU2o0TQpBL3dHb0Nsd1gxaHBObXo3VGVpaTZkZ3RmTFI2S25uVnd4bjVMdkk0ZldOamFMVlhlZ2t5TFRpOEJqZXpYUHpFCkRTY1VKQTl1RVdPc2lwWHlFZlFVYWhPNXBmanBXYWhVdVI0bVBIOXN1TXVHeE1HdmQ3Z0tNbzhDeWkrd3JlTksKalZTNG52Qm1lVFNRVHR2VW1lZEEvZGpRdzg2ZjhQU0tOeTB0QWUxdVkxeVR0TkxIaGtUT2hlK1lUQzQyVFVQQQpWRGdCMGxoYS8zNEJMQmYxNzJSeFYvNG9vdEFSZVlrWUloOURYM0w1Vkh1eURyLzFnaSsreE02RExsaGdST0ZmCld2WUExbTZyeE9vcGMxZ3d3Nlc2WFUxSkNTNmwrNy9qVFdxejdOWW9qaUxtSUJMay9hVitwK2F5WnZtZXBWOXAKSEFQL01zSmJla2xoL2F3Zm5iR1JpbGJZcEZPZFZobWNWMDFhUGdrUnMrdUIyUXFGUTRsUERLaHpoSW9LSVJZSAp6VVl5RUEwQkZteUxPU2xGVE1wcXBweU1DVkhweDZIN3hwOTlabnU5dWZnWjl2cVVwNFNRK2NRdEliSGt5UmM1CmJaU2JaMndnbktydkFFam41ZUJkZkc2V2NZR1FWejNCNnhrZk9yekRjclVFYktoOFpQZndzclZYWGh1dGJvRHUKVHhaMktGbXRsZ1R0eWhZN3F5ZXBwekE5RjZNWlB6bksxUFpyTjVCQk1CT1E3SS9uZ1ROaTVkY0lndGRrZDhwaQphL1IwSnN6QTh1Z2ErVFYvZTBaK05rOWpTVlVoRm1uZy9BMUI2UnY4MzdWV0NjTmEyOTdZbDM5UjdZS1N0eTBnCkp1NTI3dkJ4SjAxcUpJckxtWEZnd05tbDlJRUdoaGlraDFRSUFBeG9tZ0gzS3pXZi9qc2NrNjhkSnNOMjh5V2UKdGplbkdzQ3h4QmlmSzBJKzlGNUthRHJoNmR2R3dDckdxeVZBM3NQbmE2N1BEOVhFWnVxNCtOVWFOenRsNXd4SwpBZXk4UnIvZXN2ZVdHczFQbCtianlCZEZPOEg5NlFBSXNhY2k1aTZUd0pIdVptZGEwQWlNWFIvVGNHYStCRlgrCk4xeU1RMkFJVkNLSkI5V0FoUnRDdnkveHdMeEVLakNpZ3RNRXFOSUlFdTlKcTVNbkZudTB1TnVWTGRuRWNEZ0oKWEJZPQotLS0tLUVORCBFTkNSWVBURUQgUFJJVkFURSBLRVktLS0tLQpCYWcgQXR0cmlidXRlcwogICAgZnJpZW5kbHlOYW1lOiBjbj1bRl0gRk9STVVMQVJJT1MgQ09NRVJDSUFMRVMgU0EgLSA4NDQwODQtMS01MDQwNjEgLSAwMCAtIENIQU5JUyBURUpBREEgTUFOVUVMIFJJQ0FSRE8sb3U9RkFDVFVSQSBFTEVDVFJPTklDQSxvPUZJUk1BIEVMRUNUUk9OSUNBLGM9UEEgTm9uLXJlcHVkaWF0aW9uIENlcnRpZmljYXRlCiAgICBsb2NhbEtleUlEOiAyOSBGNSAzRiAzNSAyMSAxRSAwNCBFMCAyRCBCMiA0QyA5NSBBQSA4QyBCRSBFMCAKc3ViamVjdD0vQz1QQS9PPUZJUk1BIEVMRUNUUk9OSUNBL09VPUZBQ1RVUkEgRUxFQ1RST05JQ0EvQ049W0ZdIEZPUk1VTEFSSU9TIENPTUVSQ0lBTEVTIFNBIC0gODQ0MDg0LTEtNTA0MDYxIC0gMDAgLSBDSEFOSVMgVEVKQURBIE1BTlVFTCBSSUNBUkRPCmlzc3Vlcj0vQz1QQS9PPUZJUk1BIEVMRUNUUk9OSUNBL0NOPUNBIFBBTkFNQSBDTEFTRSAyCi0tLS0tQkVHSU4gQ0VSVElGSUNBVEUtLS0tLQpNSUlHZWpDQ0JXS2dBd0lCQWdJUUtmVS9OU0VlQk9BdHNreVZxb3krNERBTkJna3Foa2lHOXcwQkFRc0ZBREJGCk1Rc3dDUVlEVlFRR0V3SlFRVEVhTUJnR0ExVUVDZ3dSUmtsU1RVRWdSVXhGUTFSU1QwNUpRMEV4R2pBWUJnTlYKQkFNTUVVTkJJRkJCVGtGTlFTQkRURUZUUlNBeU1CNFhEVEl6TURreU1qRTJNRFl6TWxvWERUSTFNRGt5TWpFMgpNRFl6TWxvd2dhWXhDekFKQmdOVkJBWVRBbEJCTVJvd0dBWURWUVFLREJGR1NWSk5RU0JGVEVWRFZGSlBUa2xEClFURWNNQm9HQTFVRUN3d1RSa0ZEVkZWU1FTQkZURVZEVkZKUFRrbERRVEZkTUZzR0ExVUVBd3hVVzBaZElFWlAKVWsxVlRFRlNTVTlUSUVOUFRVVlNRMGxCVEVWVElGTkJJQzBnT0RRME1EZzBMVEV0TlRBME1EWXhJQzBnTURBZwpMU0JEU0VGT1NWTWdWRVZLUVVSQklFMUJUbFZGVENCU1NVTkJVa1JQTUlJQklqQU5CZ2txaGtpRzl3MEJBUUVGCkFBT0NBUThBTUlJQkNnS0NBUUVBdFRudWxPRmdncjBkUVlFZVRqYWFYbzQ0b0xEa003QlI1ZnpiM1RyazNTUXAKcUdrU2hMOWNWYTd3MHJxQ1BPZm1ObWg5NnVJMHZVVU5jdG1iMDF6bkZjTVJGMXBrTlFnK01MSHAyYmtZZ2RwTgpCdHBNTXZibG4xdThiWTBadVMrUW1Qc1kxK0tLcjlUUk5mbWlia3l5Z0JqQW50V0Y3KzJYak5ZK3VQZ20zellwCjgwbGJXN0dvN1R2eGhrb2Qzb0hyelhPeUlud1I3RHQ3NTVkS2lOMVNlR0owdWR4bllLemN5WDMra015UzlleXQKNVhFdnEyVlBzVXVrZlpFVTM1cENQN0ZhUmNvcHNJYU81MHAyaUJMUGNIVmxONUJxMnJMOXFIazRReEtibk1LLwpaT0JkYkM0TXRpcFdZRXhyWE9VdVlMVlY2ZWNaMFVSTXJJYlhqWE9nMVFJREFRQUJvNElEQWpDQ0F2NHdEZ1lEClZSMFBBUUgvQkFRREFnWkFNQmtHQTFVZEpRUVNNQkFHQ0NzR0FRVUZCd01DQmdSVkhTVUFNR2NHQ0NzR0FRVUYKQndFQkJGc3dXVEFpQmdnckJnRUZCUWN3QVlZV2FIUjBjRG92TDI5amMzQXVjR3RwTG1kdllpNXdZVEF6QmdncgpCZ0VGQlFjd0FvWW5hSFIwY0RvdkwzZDNkeTV3YTJrdVoyOWlMbkJoTDJOaFkyVnlkSE12WTJGd1l6SXVZM0owCk1JSEtCZ05WSFNBRWdjSXdnYjh3Z2J3R0NHQ0VUd0VDQWdZQ01JR3ZNRFlHQ0NzR0FRVUZCd0lCRmlwb2RIUncKT2k4dmQzZDNMbkJyYVM1bmIySXVjR0V2Ym05eWJXRjBhWFpoTDJsdVpHVjRMbWgwYld3d2RRWUlLd1lCQlFVSApBZ0l3YVJwblEyVnlkR2xtYVdOaFpHOGdjM1ZxWlhSdklHRWdiR0VnUkdWamJHRnlZV05wYjI0Z1pHVWdVSEpoClkzUnBZMkZ6SUdSbElFTmxjblJwWm1sallXTnBiMjRnWkdVZ1JtbHliV0VnUld4bFkzUnliMjVwWTJFZ1pHVWcKVUdGdVlXMWhJQ2d5TURFeUtUQ0NBUmNHQTFVZEVRU0NBUTR3Z2dFS3BJSHhNSUh1TVE0d0RBWUhZSVJQQVFFRwpBZ3dCTWpFUE1BMEdCMkNFVHdFQkJnRU1BakF3TVJ3d0dnWUhZSVJQQVFFQ0Fnd1BPRFEwTURnMExURXROVEEwCk1EWXhNU2N3SlFZSFlJUlBBUUVDQVF3YVJrOVNUVlZNUVZKSlQxTWdRMDlOUlZKRFNVRk1SVk1nVTBFeEZ6QVYKQmdkZ2hFOEJBUUVHREFveU5TOHdOaTh4T1RZeE1SWXdGQVlIWUlSUEFRRUJCUXdKT0MwME9EZ3RNek15TVJNdwpFUVlIWUlSUEFRRUJCQXdHVkVWS1FVUkJNUk13RVFZSFlJUlBBUUVCQXd3R1EwaEJUa2xUTVJRd0VnWUhZSVJQCkFRRUJBZ3dIVWtsRFFWSkVUekVUTUJFR0IyQ0VUd0VCQVFFTUJrMUJUbFZGVElFVWNtTm9ZVzVwYzBCamQzQmgKYm1GdFlTNXVaWFF3TlFZRFZSMGZCQzR3TERBcW9DaWdKb1lrYUhSMGNEb3ZMM2QzZHk1d2Eya3VaMjlpTG5CaApMMk55YkhNdlkyRndZekl1WTNKc01COEdBMVVkSXdRWU1CYUFGT2orYlBZSWxTcTYzR1M1b0ZsdTdkQzg4TWx5Ck1CMEdBMVVkRGdRV0JCUmhuQmdBR2FKYnc5WFZVbFFpaXRoSEQ4cnFVVEFKQmdOVkhSTUVBakFBTUEwR0NTcUcKU0liM0RRRUJDd1VBQTRJQkFRQ0hDN2REY2d1eEhnMmR2U0hPY3pIeFpuWFRXYU00bjJNek9JNEFDNE1RZEI3RAplSGwrNnhUQlVmNWlOQ25QRDJPajMza2tlOFZtNzZTZFBtSWVQSFVYM0p4OThMRzdiUXpNY0VqSVQ0NmRYNkxqCkxJODVWaFJPRnNvS2tUUFd6YzZvejE0dTcvdC9zSXRjUC9ybXF6NzVRNldlZ05ybS9pQWhPUHVSMSt1YThHNFAKR2pTL1ptUnBmUWpWTnhoeE9kUlVLb1owUkxRS2lIK0ZLQXFNZkpDeUdLUHBVdXZjZEYxRElVdlZLZm53ZjlESgpnellUOFY2alFRNzQzVk8yNkIrVmQyY3kwalhHTjlFbjI4ZXBXNGZpUFFidSsyZWZ6a0h1emt1K0JORTFsVVBxClhPb3c4R1hJdk13UlViRzJseEpGYkVNeFAxNmtNbHdiZWd1ckFYVjkKLS0tLS1FTkQgQ0VSVElGSUNBVEUtLS0tLQo=",
                "pass": "Tb1DOwrrxeLnjYxR70pr"
            },
            "rFE": {
                "dVerForm": "1.00",
                "gDGen": {
                    "iAmb": "2",
                    "iTpEmis": "01",
                    "iDoc": "01",
                    "dNroDF": "0000060617",
                    "dPtoFacDF": "002",
                    "dSeg": 981214352,
                    "dFechaEm": "AUTO",
                    "iNatOp": "01",
                    "iTipoOp": "1",
                    "iDest": "1",
                    "iFormCAFE": "1",
                    "iEntCAFE": "1",
                    "dEnvFE": "1",
                    "iProGen": "1",
                    "gEmis": {
                        "gRucEmi": {
                            "dTipoRuc": "2",
                            "dRuc": "844084-1-504061",
                            "dDV": "00"
                        },
                        "dNombEm": "FE generada en ambiente de pruebas - sin valor comercial ni fiscal",
                        "dSucEm": "0000",
                        "dCoordEm": "+8.98114,-79.52262",
                        "dDirecEm": "PH Global Plaza, 6to. piso. Calle 50",
                        "gUbiEm": {
                            "dCodUbi": "8-8-7",
                            "dCorreg": "Bella Vista",
                            "dDistr": "Panama",
                            "dProv": "Panama"
                        },
                        "dTfnEm": [
                            "123-4567"
                        ],
                        "dCorElectEmi": [
                            "demo@siteck.com.mx"
                        ]
                    },
                    "gDatRec": {
                        "iTipoRec": "01",
                        "gRucRec": {
                            "dTipoRuc": "2",
                            "dRuc": "155642124-2-2016",
                            "dDV": "95"
                        },
                        "dNombRec": "FE generada en ambiente de pruebas - sin valor comercial ni fiscal",
                        "dDirecRec": "Direcci\u00c3\u00b3n del receptor de la FE",
                        "gUbiRec": {
                            "dCodUbi": "8-8-12",
                            "dCorreg": "Juan Diaz",
                            "dDistr": "Panama",
                            "dProv": "Panama"
                        },
                        "cPaisRec": "PA"
                    }
                },
                
                
            }
        }';

        $json_array = json_decode($jsondata, true);

        return $json_array['rFE']['gDGen'];

        $datospost['json']=$datos;

        
        $datospost['modo']='JSON';
        $url = "https://pruebas.siteck.mx/api/";
        $res=$this->callAPI('POST', $url, $datospost);

        return  json_decode($res);


    }

    public function verCufe(){

        return view('cufe');


    }

   

    

    function callAPI($method, $url, $data){
        $curl = curl_init();
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => false,   // follow redirects
            CURLOPT_MAXREDIRS      => 1,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "api-mf", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 10,    // time-out on connect
            CURLOPT_TIMEOUT        => 10,    // time-out on response 
        );
        curl_setopt_array($curl, $options);	
        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
            break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'APIKEY: 111111111111111111111',
        'test-test: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);

    if(!$result){die("Connection Failure");}
    curl_close($curl);
    return $result;
    }

    

    
}
