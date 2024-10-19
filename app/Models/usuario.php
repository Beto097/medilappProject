<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class usuario extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $table = "usuario";
    protected $primaryKey="id";
    protected $connection = 'mysql';
    
    
    public function rol()
    {
        return $this->belongsTo('App\Models\rol');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\company');
    }
}

