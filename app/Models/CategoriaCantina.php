<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaCantina extends Model
{
    use HasFactory;

    protected $table = 'categorias_cantina';

    protected $fillable = [
        'nome',
    ];

    public function produtos()
    {
        return $this->hasMany(ProdutoCantina::class, 'categoria_id');
    }

    public function produtosAtivos()
    {
        return $this->hasMany(ProdutoCantina::class, 'categoria_id')->where('ativo', true);
    }
}