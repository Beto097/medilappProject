<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $connection = 'mysql';
    protected $table = "usuario";
    protected $primaryKey="id";
    
    
    public function rol()
    {
        return $this->belongsTo('App\Models\rol');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\company');
    }

    public function urlsPantallasXUsuario(){

        
        $pantallas_rol = rol_pantalla::where('rol_id',$this->rol_id)->get();
        $lista = array();

        foreach($pantallas_rol as $pantalla_rol){
            array_push($lista,$pantalla_rol->pantalla->url_pantalla);
        } 
        return $lista;

    }
    
    public function permisos($ruta,$permiso = ''){   

       
       
        foreach ($this->rol->pantallas as $pantalla) {
            
            
            if ($pantalla->request_pantalla == $ruta && $permiso == '') {
                return true;
                
            }
            
            if ($pantalla->request_pantalla == $ruta && str_contains($pantalla->url_pantalla, $permiso)) {
                return true;
            }
            
        }  

        return false;        
        
    }

    

    
}

