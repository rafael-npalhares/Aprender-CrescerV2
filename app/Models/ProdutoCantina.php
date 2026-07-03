<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdutoCantina extends Model
{
    use HasFactory;

    protected $table = 'produtos_cantina';

    protected $fillable = [
        'categoria_id',
        'nome',
        'descricao',
        'foto',
        'preco',
        'quantidade_estoque',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
            'ativo' => 'boolean',
        ];
    }

    // ─── Relacionamentos ─────────────────────────────────────────────────────

    public function categoria()
    {
        return $this->belongsTo(CategoriaCantina::class, 'categoria_id');
    }

    public function itensPedido()
    {
        return $this->hasMany(ItensPedidoCantina::class, 'produto_id');
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    public function getEsgotadoAttribute(): bool
    {
        return $this->quantidade_estoque <= 0;
    }

    /**
     * Fotos ficam em public/img/cantina/
     * No banco salvo como: img/cantina/espetinho.jpeg
     * Acessado via: asset('img/cantina/espetinho.jpeg')
     */
    public function getFotoUrlAttribute(): string
    {
        return $this->foto
            ? asset($this->foto)
            : asset('img/cantina/sem-foto.png');
    }

    public function getPrecoFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeDisponiveis($query)
    {
        return $query->where('ativo', true)->where('quantidade_estoque', '>', 0);
    }
}