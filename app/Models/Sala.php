<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Sala extends Model
{

    use HasFactory;

    protected $fillable = [
        'codigo',
        'salaSlug',
        'name',
        'descricao',
        'image',
        'criador_id',
    ];
}
