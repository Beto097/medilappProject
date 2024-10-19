<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class examen_caracteristica_examen extends Model
{
    use HasFactory;
    protected $table = "examen_caracteristica_examen";
    protected $primaryKey="id";
    protected $fillable=array("examen_id","num_orden","caracteristica_examen_id");

    public function caracteristica_examen()
    {
        return $this->belongsTo('App\Models\caracteristica_examen');
    }
}
