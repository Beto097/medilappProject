<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orden_laboratorio extends Model
{
    use HasFactory;
    protected $table = "orden_laboratorio";
    protected $primaryKey="id";
    protected $fillable=array("fecha_orden","paciente_id","usuario_id","medico_id");

    public function usuario()
    {
        return $this->belongsTo('App\Models\usuario');
    }
    public function paciente()
    {
        return $this->belongsTo('App\Models\paciente');
    }
    public function medico()
    {
        return $this->belongsTo('App\Models\medico');
    }
        public function rol()
    {
        return $this->belongsTo('App\Models\rol');
    }

    public function examen()
    {
        return $this->belongsTo('App\Models\examen');
    }
        public function tipo_examen()
    {
        return $this->belongsTo('App\Models\tipo_examen');
    }
    public function examen_orden_laboratorio()
    {
        return $this->hasMany('App\Models\examen_orden_laboratorio');
    }

    public function examenes()
    {
        return $this->belongsToMany('App\Models\examen')->withPivot('estado_examen');
    }
    
    
}
