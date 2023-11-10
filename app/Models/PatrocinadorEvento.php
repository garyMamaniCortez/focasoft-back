<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatrocinadorEvento extends Model
{
    protected $table = 'patrocinador_evento';
    protected $fillable = [
        'id_evento',
        'id_patrocinador'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
