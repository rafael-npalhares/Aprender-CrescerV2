<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoCantina extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'preco',
        'quantidade_estoque',
        'ativo',
    ];

    public function pedidos()
    {
        return $this->hasMany(PedidoCantina::class, 'produto_id');
    }
}