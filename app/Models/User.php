<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'primer_nombre_usuario',
        'apellido_usuario',
        'nombre_usuario',
        'email_usuario',
        'password_usuario',
        'rol_id',
        'sucursal_id',
        'fecha_fin',
        'estado_usuario'
    ];

    protected $hidden = [
        'password_usuario'
    ];

    protected $table = "usuario";

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rol()
    {
        return $this->belongsTo('App\Models\rol');
    }

    public function sucursal()
    {
        return $this->belongsTo('App\Models\sucursal');
    }


    public function accesoRuta($ruta){

        foreach ($this->rol->pantallas as $pantalla) {
            if ($pantalla->url_pantalla == $ruta) {
                return  true;
            }
        }
        return false;
    }
}
