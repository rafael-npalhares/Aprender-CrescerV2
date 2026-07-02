<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PedidoCantina extends Model
{
    use HasFactory;

    protected $table = 'pedidos_cantina';

    protected $fillable = [
        'user_id',
        'numero_pedido',
        'senha_retirada',
        'data_retirada',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'data_retirada' => 'date',
        ];
    }

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function itens()
    {
        return $this->hasMany(ItensPedidoCantina::class, 'pedido_id');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    // Número do pedido formatado: #001, #002...
    public function getNumeroFormatadoAttribute(): string
    {
        return '#' . str_pad($this->numero_pedido, 3, '0', STR_PAD_LEFT);
    }

    // Total do pedido somando (quantidade × preco_unitario) de todos os itens
    public function getTotalAttribute(): float
    {
        return $this->itens->sum(fn($item) => $item->quantidade * $item->preco_unitario);
    }

    // Total formatado em reais: R$ 27,50
    public function getTotalFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->getTotal(), 2, ',', '.');
    }

    // Gera o próximo número de pedido sequencial global
    public static function proximoNumero(): int
    {
        return (static::max('numero_pedido') ?? 0) + 1;
    }

    // Gera senha de retirada numérica aleatória de 4 dígitos
    public static function gerarSenha(): string
    {
        return str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeEntregues($query)
    {
        return $query->where('status', 'entregue');
    }

    public function scopeCancelados($query)
    {
        return $query->where('status', 'cancelado');
    }
}