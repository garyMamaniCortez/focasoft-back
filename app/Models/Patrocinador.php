<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrocinador extends Model
{
    protected $table = 'patrocinador';
    protected $fillable = [
        'id',
        'nombre',
        'pagina_web',
        'logo'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
