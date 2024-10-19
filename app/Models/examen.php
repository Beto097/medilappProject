<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class examen extends Model
{
    use HasFactory;
    protected $table = "examen";
    protected $primaryKey="id";
    protected $fillable=array("nombre_examen","codigo_examen","detalle_examen","tipo_examen_id");

    public function tipo_examen()
    {
        return $this->belongsTo('App\Models\tipo_examen');
        
    }

    public function examen_orden_laboratorio()
    {
        return $this->hasMany('App\Models\examen_orden_laboratorio');
    }
    
    public function examen_caracteristica_examen()
    {
        return $this->hasMany('App\Models\examen_caracteristica_examen');
    }

    
    
}
