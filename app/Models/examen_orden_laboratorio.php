<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class examen_orden_laboratorio extends Model
{
    use HasFactory;   
    protected $table = "examen_orden_laboratorio";
    protected $primaryKey="id";
    protected $fillable=array("orden_laboratorio_id","examen_id","estado_examen");

    public function examen()
    {
        return $this->belongsTo('App\Models\examen');
    }

    public function orden_laboratorio()
    {
        return $this->belongsTo('App\Models\orden_laboratorio');
    }
}
