<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paciente extends Model
{
    use HasFactory;
    protected $table = "paciente";
    protected $primaryKey="id";
    protected $fillable=array("identificacion_paciente","nombre_paciente","apellido_paciente","sexo_paciente","fecha_nacimiento_paciente","telefono_paciente","email_paciente");

    public function orden_laboratorio()
    {
        return $this->hasMany('App\Models\orden_laboratorio');
    }
}
