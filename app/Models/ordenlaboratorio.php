<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ordenlaboratorio extends Model
{
    protected $table = "ordenlaboratorio";
    
    protected $fillable = [
        'fecha_orden',
        'paciente_id', 
        'usuario_id',
        'medico_id',
        'estado_orden_laboratorio',
        'esExterno',
        'token',
        'externo_id'
    ];

    /**
     * Relación con el modelo Paciente
     */
    public function paciente()
    {
        return $this->belongsTo(paciente::class, 'paciente_id');
    }

    /**
     * Relación con el modelo User (usuario que creó la orden)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con el modelo Medico
     */
    public function medico()
    {
        return $this->belongsTo(medico::class, 'medico_id');
    }

    /**
     * Relación con exámenes
     */
    public function examenes()
    {
        return $this->hasMany(examen_orden_laboratorio::class, 'ordenlaboratorio_id');
    }
}
