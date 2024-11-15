<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_resposta',
        'is_correta',
        'texto',
        'pergunta_id',
    ];
    public function pergunta()
{
    return $this->belongsTo(Pergunta::class);
}
}
