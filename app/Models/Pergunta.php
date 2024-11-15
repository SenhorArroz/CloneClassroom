<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'texto',
        'pontos',
        'atividade_id',
    ];
    public function respostas()
{
    return $this->hasMany(Resposta::class);
}   
}
