<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class certificado extends Model
{
    use HasFactory;

    protected $table = "certificado";

    public static function ultimo(){

        $certificado = certificado::orderBy('numero','DESC')->first();

        return $certificado->numero +1;

        
    }
}
