<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receta extends Model
{
    use HasFactory;

    protected $table = "receta";

    public static function ultimaReceta(){

        $receta = receta::orderBy('numero','DESC')->first();

        return $receta->numero +1;

        
    }
}
