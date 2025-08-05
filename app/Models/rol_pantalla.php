<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rol_pantalla extends Model
{
    use HasFactory;
    protected $table = "rol_pantalla";
    protected $primaryKey="id";
    protected $fillable=array("pantalla_id","rol_id");

    public function usuarios()
    {
        return $this->hasMany('App\Models\usuario');
    }

    public function pantalla()
    {
        return $this->belongsTo('App\Models\pantalla');
    }


}
