<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'autor',
        'qtd_total',
        'qtd_disponivel',
    ];

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }

    public function emprestimosAtivos()
    {
        return $this->hasMany(Emprestimo::class)->where('status', 'ativo');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function getDisponivelAttribute(): bool
    {
        return $this->qtd_disponivel > 0;
    }
}