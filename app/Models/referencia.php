<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referencia extends Model
{
    use HasFactory;

    protected $table = 'referencia';

    protected $fillable = ['datos'];

    protected $casts = [
        'datos' => 'array',
    ];
}
