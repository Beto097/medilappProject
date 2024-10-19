<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pantalla extends Model
{
    use HasFactory;
    protected $table = "pantalla";
    protected $connection = 'mysql';
    protected $primaryKey="id";
    protected $fillable=array("nombre_pantalla","url_pantalla","estado_pantalla","padre");


    
    public function rol_pantallas(){
        return $this->hasMany('App\Models\rol_pantalla');
    }


    public function padre(){

        return pantalla::find($this->padre);
    }
    


}
