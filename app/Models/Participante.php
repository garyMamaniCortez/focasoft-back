<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $table = 'participante';
    protected $fillable = [

    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
