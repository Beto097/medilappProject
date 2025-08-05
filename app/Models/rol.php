<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rol extends Model
{
    protected $table = "rol";
    protected $primaryKey="id";

    public function usuarios()
    {
        return $this->hasMany('App\Models\usuario');
    }

    public function pantallas()
    {
        return $this->belongsToMany(pantalla::class, 'rol_pantalla', 'rol_id', 'pantalla_id');
    }

    public function menu()
    {        
        $pantallas_rol = $this->pantallas;       
        $lista = array();

        foreach($pantallas_rol as $pantalla_rol){
            array_push($lista,$pantalla_rol->id);
        }

        return pantalla::where('padre',0)->where('estado_pantalla',1)->whereIn('id',$lista)->orderBy('orden','ASC')->get(); 
    }
}
