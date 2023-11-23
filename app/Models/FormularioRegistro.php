<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioRegistro extends Model
{
    protected $table = 'formulario';
    protected $fillable = [
        'id_evento',
        'preguntas',
        'obligatorias'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
