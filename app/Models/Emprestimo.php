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

    const PRAZO_DIAS = 15;

    const MAX_RENOVACOES = 2;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function getEmAtrasoAttribute(): bool
    {
        return $this->status === 'ativo'
            && $this->data_prevista_devolucao->isPast();
    }

    public function getPodeRenovarAttribute(): bool
    {
        return $this->status === 'ativo'
            && $this->renovacoes < self::MAX_RENOVACOES;
    }

    public function renovar(): void
    {
        $this->update([
            'data_prevista_devolucao' => Carbon::now()->addDays(self::PRAZO_DIAS),
            'renovacoes'              => $this->renovacoes + 1,
        ]);
    }

    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeAtrasados($query)
    {
        return $query->where('status', 'atrasado');
    }
}