<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class medico extends Model
{
    protected $table = "medico";

    protected $fillable = [
        'numero_registro',
        'cedula_medico',
        'nombre_medico',
        'email_medico',
        'telefono_medico'
    ];
}
