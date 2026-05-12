<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoCantina extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produto_id',
        'quantidade',
        'status',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produto()
    {
        return $this->belongsTo(ProdutoCantina::class, 'produto_id');
    }
}