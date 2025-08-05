<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pantalla extends Model
{
    protected $table = "pantalla";
    protected $primaryKey="id";

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_pantalla', 'pantalla_id', 'rol_id');
    }

    public function subMenu()
    {
       
        $pantallas_rol = Auth()->user()->rol->pantallas;
        $lista = array();
        
        foreach($pantallas_rol as $pantalla_rol){
            array_push($lista,$pantalla_rol->id);
        }

        return pantalla::where('padre',$this->id)->whereIn('id',$lista)->get();
    }

    public function sub_pantallas()
    {  

        return pantalla::where('padre',$this->id)->get();

    }
}
