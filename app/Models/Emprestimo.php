<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'livro_id',
        'data_emprestimo',
        'data_prevista_devolucao',
        'data_devolucao',
        'renovacoes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'data_emprestimo'         => 'date',
            'data_prevista_devolucao' => 'date',
            'data_devolucao'          => 'date',
        ];
    }

    // Prazo padrão de devolução em dias
    const PRAZO_DIAS = 15;

    // Máximo de renovações permitidas
    const MAX_RENOVACOES = 2;

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    // Verifica se o empréstimo está em atraso (data prevista já passou e não devolvido)
    public function getEmAtrasoAttribute(): bool
    {
        return $this->status === 'ativo'
            && $this->data_prevista_devolucao->isPast();
    }

    // Verifica se ainda pode ser renovado
    public function getPodeRenovarAttribute(): bool
    {
        return $this->status === 'ativo'
            && $this->renovacoes < self::MAX_RENOVACOES;
    }

    // Renova o empréstimo: estende prazo em mais 15 dias a partir de hoje
    public function renovar(): void
    {
        $this->update([
            'data_prevista_devolucao' => Carbon::now()->addDays(self::PRAZO_DIAS),
            'renovacoes'              => $this->renovacoes + 1,
        ]);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeAtrasados($query)
    {
        return $query->where('status', 'atrasado');
    }
}