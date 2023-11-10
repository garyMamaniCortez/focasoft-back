<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'pregunta';
    protected $fillable = [
        'texto_pregunta',
        'tipo',
        'obligatorio',
        'opciones'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
