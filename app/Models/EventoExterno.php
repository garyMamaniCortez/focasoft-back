<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoExterno extends Model
{
    protected $table = 'evento_externo';
    protected $fillable = [
        'id',
        'titulo',
        'fecha_ini',
        'fecha_fin',
        'url',
        'descripcion',
        'afiche'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
