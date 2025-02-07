<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dam extends Model
{
    protected $table = 'dams';
    protected $fillable = [
        'curso',
        'modulo',
        'descripcion',
        'nHoras'
    ];
}