<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'conteudo',
        'visivel_para',
        'data_expiracao',
        'fixado',
        'ativo',
    ];

    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}