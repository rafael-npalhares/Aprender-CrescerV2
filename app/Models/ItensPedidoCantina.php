<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItensPedidoCantina extends Model
{
    use HasFactory;

    protected $table = 'itens_pedido_cantina';

    protected $fillable = [
        'pedido_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
    ];

    protected function casts(): array
    {
        return [
            'preco_unitario' => 'decimal:2',
        ];
    }

    public function pedido()
    {
        return $this->belongsTo(PedidoCantina::class, 'pedido_id');
    }

    public function produto()
    {
        return $this->belongsTo(ProdutoCantina::class, 'produto_id');
    }

    public function getSubtotalAttribute(): float
    {
        return $this->quantidade * $this->preco_unitario;
    }

    public function getSubtotalFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->subtotal, 2, ',', '.');
    }
}