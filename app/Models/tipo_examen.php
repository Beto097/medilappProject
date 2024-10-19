<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_examen extends Model
{
    use HasFactory;
    protected $table = "tipo_examen";
    protected $primaryKey="id";
    protected $fillable=array("nombre_tipo_examen");

    public function examen()
    {
        return $this->hasMany('App\Models\examen');
    }
}
