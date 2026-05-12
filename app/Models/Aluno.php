<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    // Bloco 1 - Fillable
    protected $fillable = [
        'user_id',
        'turma_id',
        'matricula',
        'data_nascimento',
    ];

    // Bloco 2 - Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class, 'user_id', 'user_id');
    }

    public function pedidos()
    {
        return $this->hasMany(PedidoCantina::class, 'user_id', 'user_id');
    }
}