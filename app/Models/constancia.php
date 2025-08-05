<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class constancia extends Model
{
    use HasFactory;

    protected $table = "constancia";

    public static function ultimo(){

        $constancia = constancia::orderBy('numero','DESC')->first();

        return $constancia->numero +1;

        
    }
} 