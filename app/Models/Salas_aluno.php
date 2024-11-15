<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Salas_aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_user',
        'id_salas',
    ];
}
