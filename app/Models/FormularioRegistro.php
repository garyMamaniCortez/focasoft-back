<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioRegistro extends Model
{
    protected $table = 'formulario';
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
        'semestre'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
