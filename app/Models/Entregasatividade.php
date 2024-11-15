<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entregasatividade extends Model
{
    use HasFactory;

    protected $fillable = [
        'pontuacao',
        'aluno_id',
        'atividade_id',
    ];
    public function aluno()
{
    return $this->belongsTo(User::class);
}
}
