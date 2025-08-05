<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class paciente extends Model
{
    protected $table = "paciente";

    public function consultas()
    {
        return $this->hasMany('App\Models\consulta')->orderBy('fecha_consulta', 'desc');
    }


    public function consultaActiva(){
        $exite = consulta::where('estado_consulta','Pendiente')->where('paciente_id',$this->id)->count();
        if($exite>0){
            return true;
        }

        return false;
    }

    public function esMayor(){

        $fechaNacimiento = Carbon::parse($this->fecha_nacimiento_paciente);
        $hoy = Carbon::now();
        $diferencia = $fechaNacimiento->diff($hoy);

        if ($diferencia->y >= 18) {
            return true;
        }
        
        return false;      

    }

    public function edad(){

        $fechaNacimiento = Carbon::parse($this->fecha_nacimiento_paciente);
        $hoy = Carbon::now();
        $diferencia = $fechaNacimiento->diff($hoy);
    
        if ($diferencia->y >= 2) {
            return $diferencia->y . ' años';
        }
    
        if ($diferencia->y = 1) {
            return $diferencia->y . ' año';
        }
    
        if ($diferencia->m >= 1) {
            return $diferencia->m . 'm ' . $diferencia->d . 'd';
        }
    
        return $diferencia->d . ' días';
    }

    public function nombres($id){
        
        $nombreCompleto = $this->nombre_paciente;

        $partes = explode(' ', trim($nombreCompleto));

        $primerNombre = array_shift($partes); // Primera palabra
        $segundoNombre = implode(' ', $partes); // El resto

        if($id==1){
            return $primerNombre;
        }
        return $segundoNombre;
    }

    public function archivos(){
        
        return $this->hasMany('App\Models\archivo');

    }

    public function apellidos($id)
    {
        $apellidosCompletos = $this->apellido_paciente;
        $apellidosCompletos = trim($apellidosCompletos);
        $partes = explode(' ', $apellidosCompletos);

        $preposiciones = ['de', 'del', 'la', 'los', 'las'];

        $primerApellido = '';
        $segundoApellido = '';

        $i = 0;
        $primerApellidoArray = [];

        // Construir el primer apellido
        while ($i < count($partes)) {
            $palabra = strtolower($partes[$i]);
            $primerApellidoArray[] = $partes[$i];
            $i++;

            if (!in_array($palabra, $preposiciones)) {
                // Si la siguiente palabra no es una preposición, cortamos
                if ($i < count($partes) && !in_array(strtolower($partes[$i]), $preposiciones)) {
                    break;
                }
            }
        }

        $primerApellido = implode(' ', $primerApellidoArray);

        // El resto es el segundo apellido
        $segundoApellidoArray = array_slice($partes, $i);
        $segundoApellido = implode(' ', $segundoApellidoArray);

        if($id==1){
            return $primerApellido;
        }
        return $segundoApellido;
    }
}
