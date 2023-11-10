<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table = 'respuesta';
    protected $fillable = [
        'id_participante',
        'id_formulario',
        'datos_respuesta'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
