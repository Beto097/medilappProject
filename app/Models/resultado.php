<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resultado extends Model
{
    use HasFactory;
    protected $table = "resultado";
    protected $primaryKey="id";
    protected $fillable=array("caracteristica_examen_id","valor","examen_orden_laboratorio_id");

    public function caracteristica_examen()
    {
        return $this->belongsTo('App\Models\caracteristica_examen');
    }
}
