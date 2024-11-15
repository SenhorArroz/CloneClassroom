<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentariospost extends Model
{
    use HasFactory;

    protected $fillable = [
        'texto',
        'criador_id',
        'post_id',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'criador_id');
    }
}
