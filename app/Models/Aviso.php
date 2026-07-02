<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aviso extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'conteudo',
        'visivel_para',
        'fixado',
        'ativo',
    ];

    // data_expiracao foi REMOVIDA do banco — não listar aqui

    protected function casts(): array
    {
        return [
            'fixado' => 'boolean',
            'ativo'  => 'boolean',
        ];
    }

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    // Apenas avisos ativos
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    // Avisos fixados primeiro, depois por data de criação
    public function scopeOrdenados($query)
    {
        return $query->orderByDesc('fixado')->orderByDesc('created_at');
    }

    // Filtra por visibilidade: retorna 'todos' + o perfil específico
    public function scopeVisivelPara($query, string $perfil)
    {
        return $query->whereIn('visivel_para', ['todos', $perfil . 's']);
    }
}