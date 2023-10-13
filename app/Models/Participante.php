<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $table = 'participante';
    protected $fillable = [
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'correo_electronico',
        'numero_celular',
        'carrera',
        'talla_polera',
        'carnet_identidad',
        'codigo_sis_o_institucion',
        'semestre',
        'id_formulario'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
