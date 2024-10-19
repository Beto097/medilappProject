<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class rol extends Model
{
    use HasFactory;
    protected $table = "rol";
    protected $connection = 'mysql';
    protected $primaryKey="id";
    protected $fillable=array("nombre_rol");

    public function usuarios()
    {
        return $this->hasMany('App\Models\usuario');
    }

    public function pantallas()
    {
        
        return $this->belongsToMany('App\Models\pantalla', 'rol_pantalla', 'rol_id', 'pantalla_id');
        
    }

    public function company()
    {
        return $this->belongsTo('App\Models\company');
    }

    public function companys()
    {
        if(Auth::user()->rol_id==1){
            $companys = company::where('id','<>',0)->get();
            return $companys;
        }
        return null;
    }

}
