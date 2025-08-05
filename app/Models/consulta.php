<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class consulta extends Model
{
    protected $table = "consulta";

    public function paciente()
    {
        return $this->belongsTo('App\Models\paciente');
    }

    public function archivos()
    {
        return $this->hasMany('App\Models\archivo');
    }

    public static function actualizarEstados(){
        $consultas = consulta::Where('estado_consulta','EN CURSO')->get();
        $consultas_pendientes = consulta::Where('estado_consulta','Pendiente')->get();
        $consultas_terminadas = consulta::Where('estado_consulta','TERMINADA')->get();

        foreach ($consultas as $consulta) {           

            if($consulta->updated_at->addHours(intval(env('TIEMPO_ESPERA_CONSULTA', '8')))<Carbon::now()){
                $consulta->estado_consulta = "TERMINADA";
                $consulta->save();
            }
        }
        foreach ($consultas_pendientes as $consulta) {           

            if($consulta->updated_at->addHours(intval(env('TIEMPO_ESPERA_CONSULTA', '12')))<Carbon::now()){
                $consulta->estado_consulta = "CANCELADA";
                $consulta->save();
            }
            
        }
        foreach ($consultas_terminadas as $consulta) {           

            if($consulta->updated_at->addHours(intval(env('TIEMPO_ESPERA_CONSULTA', '8')))<Carbon::now()){
                $consulta->estado_consulta = "CERRADA";
                $consulta->save();
            }
        }
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\User','medico_id');
    }

    public function tieneReceta(){

        $exite = receta::where('consulta_id',$this->id)->count();

        if ($exite>0) {
            return true;
        }

        return false;
    }

    public function numeroReceta(){

        $receta = receta::where('consulta_id',$this->id)->first();

        return $receta->numero;

        
    }

    public function recetas()
    {
        return $this->hasMany('App\Models\receta');
    }

    public function referencia()
    {
        return $this->hasOne('App\Models\referencia');
    }

    public function tieneCertificado(){

        $exite = certificado::where('consulta_id',$this->id)->count();

        if ($exite>0) {
            return true;
        }

        return false;
    }

    public function tieneReferencia(){

        $exite = referencia::where('consulta_id',$this->id)->count();

        if ($exite>0) {
            return true;
        }

        return false;
    }

    public function tieneConstancia(){

        $exite = constancia::where('consulta_id',$this->id)->count();

        if ($exite>0) {
            return true;
        }

        return false;
    }

    public function tieneImprimir(){

    

        if ($this->tieneCertificado() || $this->tieneConstancia() || $this->tieneReceta() || $this->tieneReferencia()) {
            return true;
        }

        return false;
    }
    

}
