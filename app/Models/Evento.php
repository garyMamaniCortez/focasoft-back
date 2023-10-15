<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'evento';
    protected $fillable = [
        'id',
        'titulo',
        'fecha_ini',
        'fecha_fin',
        'tipo',
        'descripcion',
        'afiche',
        'id_formulario',
        'requisitos',
        'premios',
        'pratocinadores',
        'contactos'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
