<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medico extends Model
{
    use HasFactory;
    protected $table = "medico";
    protected $primaryKey="id";
    protected $fillable=array("numero_registro","nombre_medico","email_medico","telefono_medico");

    public function orden_laboratorio()
    {
        return $this->hasMany('App\Models\orden_laboratorio');
    }
    
}
