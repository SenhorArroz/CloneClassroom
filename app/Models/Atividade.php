<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'texto',
        'resposta',
        'categoria_id',
        'sala_id',
    ];
}
