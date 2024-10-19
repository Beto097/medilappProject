<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caracteristica_examen extends Model
{
    use HasFactory;
    protected $table = "caracteristica_examen";
    protected $primaryKey="id";
    protected $fillable=array("nombre_caracteristica_examen","unidad_caracteristica_examen","valor_referencia_caracteristica_examen");
}
